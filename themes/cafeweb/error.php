<?php $this->layout("_theme", [
        "title" => $title
]); ?>

<article class="not_found">
    <div class="container content">
        <header class="not_found_header">
            <p class="error">&bull;<?= $error->code ?? "404"; ?>&bull;</p>
            <h1><?= $error->title ?? "Ooops. Essa página não existe"; ?></h1>
            <p><?= $error->message ?? "Sentimos muito, mas o conteúdo que você tentou acessar não existe, está indisponível ou foi removido"; ?></p>
            <?php if($error->link): ?>
                <a class="not_found_btn gradient gradient-green gradient-hover transition radius"
                   title="<?= $error->linkTitle ?? "Continue navegando"; ?>" href="<?= $error->link ?? url(); ?>"><?= $error->linkTitle ?? "Continue navegando"; ?></a>
            <?php endif; ?>
        </header>
    </div>
</article>