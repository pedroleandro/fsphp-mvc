<article class="blog_article">
    <a title="<?= $post->getTitle(); ?>" href="<?= url("/blog/{$post->geturi()}") ?>">
        <img title="<?= $post->getTitle(); ?>" alt="<?= $post->getTitle(); ?>"
             src="<?= url("/storage/{$post->getCover()}"); ?>"/>
    </a>
    <header>
        <p class="meta"><?= $post->category()->getTitle(); ?> &bull;
            Por <?= $post->author()->getFirstName() . " " . $post->author()->getLastName(); ?>
            &bull; <?= $post->getPostAt(); ?></p>
        <h2><a title="<?= $post->getTitle(); ?>"
               href="<?= url("/blog/{$post->getUri()}"); ?>"><?= $post->getTitle(); ?></a></h2>
        <p><a title="<?= $post->getTitle(); ?>"
              href="<?= url("/blog/{$post->getUri()}"); ?>"><?= str_limit_chars($post->getSubTitle(), 100, "<b>...leia mais</b>") ?></a></p>
    </header>
</article>