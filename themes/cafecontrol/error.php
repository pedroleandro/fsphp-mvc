<?php $this->layout("_theme", [
        "title" => $title
]); ?>

<article class="not_found">
    <div class="container content">
        <header class="not_found_header">
            <p class="error">&bull;<?= $error->code ?? null; ?>&bull;</p>
            <h1><?= $error->title ?? null; ?></h1>
            <p><?= $error->message ?? null; ?></p>
            <a class="not_found_btn gradient gradient-green gradient-hover transition radius"
               title="<?= $error->linkTitle ?? null; ?>" href="<?= $error->link ?? null; ?>"><?= $error->linkTitle ?? null; ?></a>
        </header>
    </div>
</article>