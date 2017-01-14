<div class="article">
    <hr>
    <div class="footer">
        <?php $datetime = new DateTime(date('Y-m-d H:i:s'), new DateTimeZone('America/Chicago')); ?>
        <p>Have a wonderful <?= date('l'); ?>!</p>
        <p><a href="mailto:sam@snelling.com">Email</a>, <a href="https://twitter.com/@snellingio">Twitter</a></p>
        <p>pgp: 38E0 0D78 326C F14B C7A1 BA06 3696 BFC7 1915 95E4</p>
        <p>&copy;&nbsp;&nbsp;2011-<?= date('Y') ?>&nbsp;&nbsp;Sam Snelling.&nbsp;&nbsp;All rights reserved.</p>
        <p>Proudly written in Oklahoma.</p>
    </div>
</div>