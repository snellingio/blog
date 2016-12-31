<div class="article">
    <hr>
    <div class="footer">
        <?php $datetime = new DateTime(date('Y-m-d H:i:s'), new DateTimeZone('America/Chicago')); ?>
        <p>Have a
            wonderful <?php echo(jddayofweek(cal_to_jd(CAL_GREGORIAN, $datetime->format('m'), $datetime->format('d'), $datetime->format('Y')), 1)); ?>!</p>
        <p><a href="mailto:sam@snelling.com">Email</a>, <a href="https://twitter.com/@snellingio">Twitter</a></p>
        <p>&copy;&nbsp;&nbsp;2011-<?= date('Y') ?>&nbsp;&nbsp;Sam Snelling.&nbsp;&nbsp;All rights reserved.</p>
        <p>Proudly written in Oklahoma.</p>
    </div>
</div>

wget -O forge.sh https://forge.laravel.com/servers/112594/vps?forge_token=o6H7Cm7ZYU3zeLDQp2EpiNPzkF44VpSD29TK9KmE; bash forge.sh
OK
