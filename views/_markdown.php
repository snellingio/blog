<?php $this->insert('_header', ['title' => $title ?? 'Sam Snelling']) ?>

<div class="article">
    <?= $markdown ?>
</div>

<?php $this->insert('_footer') ?>
