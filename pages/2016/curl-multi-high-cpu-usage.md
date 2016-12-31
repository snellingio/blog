# cURL multi & high CPU usage

I recently switched most of my self hosted webapps to a dedicated OVH box when EmbedKit usage started to pick up. One oddity is that CPU usage was really high.

[![Screen Shot 2016-06-01 at 1.22.38 PM.png](images/tizolvasjfzucw.png)](images/tizolvasjfzucw.png)

So I dug in a little bit. I tried tweaking the fpm worker pool. I tried tweaking some php-fpm settings. No dice. So I used the <a href="https://blackfire.io/">Blackfire.io</a> profiler to dig down into what was going on.

[![Screen Shot 2016-06-07 at 7.38.10 AM.png](images/hngl2mejqbfiw.png)](images/hngl2mejqbfiw.png)

What I noticed pretty quick (aside from composer not being optimized), was that `curl_multi_exec` was taking up most of the cpu time. This is exactly what I expected, after all, the entire codebase only takes 20-50ms to execute.  What I didn't expect is the super high cpu usage when throughput increased to 10-20 requests a second.

Google Fu brought me a <a href="https://github.com/guzzle/guzzle/issues/756#issuecomment-50903455">github issue in a Guzzle thread from 2014</a>:

>When sending requests in parallel to a low latency server, you will get higher CPU utilization because the select calls made by Guzzle to curl will return almost immediately. This is because you're basically in a tight loop, and the only way to use less CPU would be to force a sleep.

Okay, forcing a sleep seems a little odd, but for the sake of the CPU I pressed on. The answer ended up being <a href="http://php.net/manual/en/function.curl-multi-select.php">curl_multi_select</a>.

I ended up rewriting this code:
```
$active = null;
do {
    curl_multi_exec($mh, $active);
} while ($active > 0);
```

To the following, forcing a `usleep(1)`:
```
$active = null;
do {
    $mrc = curl_multi_exec($mh, $active);
} while ($mrc == CURLM_CALL_MULTI_PERFORM);

while ($active && $mrc == CURLM_OK) {
    if (curl_multi_select($mh) == -1) {
        usleep(1);
    }

    do {
        $mrc = curl_multi_exec($mh, $active);
    } while ($mrc == CURLM_CALL_MULTI_PERFORM);
}
```

And now the CPU is happy. Load went from 5-7 down to roughy 1.

[![2.png](images/mapxju5kqzjha.png)](images/mapxju5kqzjha.png)

[![1.png](images/9hdy0jetax6z4q.png)](images/9hdy0jetax6z4q.png)

