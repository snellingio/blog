<div class="article">
    <hr>
    <div class="footer">
        <?php if ($path !== '') : ?><p>You should go back to the <a href="/">Home Page</a> and read something else!</p><?php endif ?>
        <?php $datetime = new DateTime(date('Y-m-d H:i:s'), new DateTimeZone('America/Chicago')); ?>
        <p>Have a wonderful <?= date('l'); ?>!</p>
        <p><a href="mailto:sam@snelling.com">Email</a>, <a href="https://twitter.com/@snellingio">Twitter</a></p>
        <p>pgp: 38E0 0D78 326C F14B C7A1 BA06 3696 BFC7 1915 95E4</p>
        <p>&copy;&nbsp;&nbsp;2011-<?= date('Y') ?>&nbsp;&nbsp;Sam Snelling.&nbsp;&nbsp;All rights reserved.</p>
        <p>Proudly written in Oklahoma.</p>
    </div>
</div>

<script type="text/javascript">
    var clicky_site_ids = clicky_site_ids || [];
    clicky_site_ids.push(101023701);
    (function() {
        var s = document.createElement('script');
        s.type = 'text/javascript';
        s.async = true;
        s.src = '//static.getclicky.com/js';
        ( document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0] ).appendChild( s );
    })();
</script>
<noscript><p><img alt="Clicky" width="1" height="1" src="//in.getclicky.com/101023701ns.gif" /></p></noscript>