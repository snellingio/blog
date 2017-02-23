<?php $this->insert('_header', ['path' => $path ?? '', 'title' => $title ?? 'Sam Snelling']) ?>

<div class="article">
    <?= $markdown ?>
</div>

<?php $this->insert('_footer', ['path' => $path ?? '']) ?>
