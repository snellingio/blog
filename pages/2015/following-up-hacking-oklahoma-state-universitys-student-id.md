# Following Up: Hacking Oklahoma State University’s Student ID

## Introduction

I published a pretty lengthy report “Hacking Oklahoma State University’s Student ID” on Sunday that I originally wrote in 2013. You can see the original post here: http://snelling.io/hacking-oklahoma-state-university-student-id

In two days, it was posted to Hacker News, Reddit /r/Netsec, and other sites that generated over 17,000 page views with hundreds of shares on Twitter and Facebook. Hindsight 20/20, I should have titled the report something differently to keep my Alma mater out of the headlines. With that said, the response from the community has been overwhelmingly positive, with several other University’s now auditing their own systems.

Edit: An awesome writeup in hackaday - read it here http://hackaday.com/2015/02/25/hacking-oklahoma-state-universitys-student-id-cards/

There are two main sections to this follow up:
- Answer some of the common questions people had, specifically the campus news paper.
- Dig deeper into who at Oklahoma State University read the original report.

Current OSU students will be interested in the first section, everyone else will be interested in the second. 

---------------------------------

## Public response to the O’Colly

The Daily O'Collegian, respectfully, reached out to me today saying they are going to be publishing an article on Friday, regardless of my response. 

Let me be very, very clear: The purpose of posting the original report was never to “go viral” or damage the University’s reputation. The purpose was to open up a broader discussion about security in general. Broken systems are all around us, and they will never be fixed unless we promote a culture ethical security research.

When I asked what the purpose of the O’Colly article was, and I received the following:

>Assuming the ID cards aren't secure (which I'm no IT major but after reading your write-up it makes sense to me) we want to find out if OSU knows their insecure, and if they knowingly just let it slide. That said, if you did the presentation and they only did the bandaid fix of taking down the ID query URL, then that doesn't reflect well on the university at all. We want to explain to the student body if their bursar and personal information is safe or not.

Hm. Feels like stirring the pot. I’m declining their interview because the last thing I want to do is spread fear, uncertainty, and doubt. I will answer the questions (modified by me) they asked publicly:

**Are Student ID cards still vulnerable?**

I do not believe there has been a major change to the way systems on campus validate the magnetic stripe on Student ID’s. I do believe there have been policy changes on how to treat Student ID’s on campus during purchases (example: photo identification required). 

One thing to mention here is that there is no “silver bullet” solution to fix all the problems. Yes, Oklahoma State should audit their systems, and reissue more secure Student ID’s. But the newest technologies are not without problems (specifically: RFID, NFC, and Chip & Pin).

Remember, You really should treat your Student ID like a credit card. Even if you allow someone to see  the front of your Student ID (and see the card number in the bottom right), someone could theoretically clone your card with very little work.

**What is the feasibility of accessing a random Student ID?**

Accessing a random ID would require you to either:
- Have an incredible guess on a card number (you have roughly a 2% chance)
- Have physical access to a card number

I’ll repeat: You really should treat your Student ID like a credit card. Even if you allow someone to see  the front of your Student ID (and see the card number in the bottom right), someone could theoritically clone your card with very little work.

**Have I been reached out to by the university as of this post?**

No. But I will update this answer accordingly.

---------------------------------

# So who read the report at Oklahoma State?

I mentioned at the beginning that over 17,000 unique visitors read the article. Neat! How were these visits tracked?
- Google Analytics
- Clicky Analytics

Google Analytics gives a really good view of the statistical demographic of people who read the original report:
[![](/images/quuulf90fuczew.png)](/images/quuulf90fuczew.png)

But, I was only interested in seeing if anyone at Oklahoma State read it.

Clicky allows us to dig a little deeper and actually export JSON data from our our analytical report!
[![](/images/kj4j6dhemn8gnw.png)](/images/kj4j6dhemn8gnw.png)
[![](/images/cdtkjlfstqeua.png)](/images/cdtkjlfstqeua.png)

So now we have a list of IP addresses. Okay, but what do a bunch of little numbers tell us about who is reading the report? Now comes in the fun `nslookup` command. It allows us to query a DNS server and see if we can get a hostname for the IP.
[![](/images/8pcdba4yu816a.png)](/images/8pcdba4yu816a.png)

Hah, turns out that all of the external OSU IP’s have a hostname. Perfect. 

Let’s write a little piece of code to iterate over the Clicky JSON export.

```
<?php

// Load JSON
$visitors = file_get_contents("visitors.json");

// Decode it
$json = json_decode($visitors, true);

// Parse the tree, we just want items
$items = $json[0]['dates'][0]['items'];

foreach($items as $item){
	$ip = $item['ip_address'];
	$host = gethostbyaddr($ip);

	// Filter out suddenlink and others, we only want OkState
	if(strpos($host, 'okstate') != false)
		echo $host ."\n";
}
```

What this effectively does is dumps all the `okstate` hostnames from the Clicky JSON export, and allows us to see exactly who was on the site. I then removed the duplicates (some people were tracked separately per browser.

```
su-bkst-pbenne.su.okstate.edu
rking.it.okstate.edu
materer1.dhcp.okstate.edu
pm201-pm108.pm.okstate.edu
jhighto-win8.it.okstate.edu
mike-cd2.it.okstate.edu
tirnanog.agh.okstate.edu
fim_si.su.okstate.edu
carries-imac.wh.okstate.edu
ssbc02j91sndrv9.bus.okstate.edu
csrv-jrday10.su.okstate.edu
ms108-54.itlabs.okstate.edu
911.clb.okstate.edu
comm-db8g5v1.wh.okstate.edu
caption-1.itle.okstate.edu
kerr-dip0.nat.okstate.edu
villagec-dip0.nat.okstate.edu
en323-software.ceat.okstate.edu
kerr-dip1.nat.okstate.edu
ia-9nqz0c1.cordell.okstate.edu
crc-196-1-760.colvin.okstate.edu
johneightv.it.okstate.edu
argus-newlaptop.it.okstate.edu
mathimage.ms-2345.okstate.edu
dsauer-pc.it.okstate.edu
mur445-sweet-p.smurraysouth.okstate.edu
c-ils-seth.library.okstate.edu
tyler-pc.it.okstate.edu
it-raymoks.it.okstate.edu
dbro.it.okstate.edu
vault-tec.it.okstate.edu
ps_dr.usda.okstate.edu
tdmeier.it.okstate.edu
ath-mxl2300xx3.ath.okstate.edu
admins-imac-2.su.okstate.edu
lcubed-two.it.okstate.edu
cvmvm-shen-win8.cvm.okstate.edu
bronsonit.agh.okstate.edu
fim_ah.su.okstate.edu
tdh-agh008j.agh.okstate.edu
floyd.it.okstate.edu
cynthia-pc.agh.okstate.edu
agh169-andrew.agh.okstate.edu
18-3-73-38-d8-94.it.okstate.edu
bennett-dip4.nat.okstate.edu
patchin-dip1.nat.okstate.edu
stout-dip0.nat.okstate.edu
bennett-dip0.nat.okstate.edu
kerr-dip2.nat.okstate.edu
villaged-dip0.nat.okstate.edu
eve.residential.okstate.edu
davis-dip1.nat.okstate.edu
ece-reftas-10.ceat.okstate.edu
vanilla.ceat.okstate.edu
lse004-shartson-p.lse.okstate.edu
iso-1.citd.okstate.edu
ieo-kathy-1.citd.okstate.edu
```

**So what does it all mean?**

`.it.` is the IT department, as is `.itlabs.`

`.wh.` is Whitehurst - home of the IT department

`.su.` is the Student Union

`.nat.` is most likely a dorm

There are others, but it follows the pattern of `computer name` . `computer location`. For example: `rking.it.okstate.edu` could very well be Ron King in the IT department. Remember though - an IP cannot legally correlate with a person! Maybe we should revisit how we name our computers though.

Thanks for reading OkState IT department! 