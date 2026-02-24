<?php $this->layout("_theme", [
        "title" => $title,
]); ?>

    <article class="post_page">
        <header class="post_page_header">
            <div class="post_page_hero">
                <h1><?= $post->getTitle(); ?></h1>
                <img class="post_page_cover" alt="" title="" src="<?= url("/storage/{$post->getCover()}"); ?>"/>
                <div class="post_page_meta">
                    <div class="author">
                        <div><img src="<?= theme("/assets/images/avatar.jpg"); ?>"/></div>
                        <div class="name">Por: <?= $post->author()->getFirstName() . " " . $post->author()->getLastName(); ?></div>
                    </div>
                    <div class="date">Dia <?= $post->getPostAt(); ?></div>
                </div>
            </div>
        </header>

        <div class="post_page_content">
            <div class="htmlchars">
                <h2><?= $post->getSubTitle(); ?></h2>

                <?= $post->getContent(); ?>
            </div>

        <div class="post_page_related content">
            <section>
                <header class="post_page_related_header">
                    <h4>Veja também:</h4>
                    <p>Confira mais artigos relacionados e obtenha ainda mais dicas de controle para suas contas.</p>
                </header>

                <div class="blog_articles">
                    <?php foreach ($posts as $post): ?>
                        <?php $this->insert("blog-list", ["post" => $post]); ?>
                    <?php endforeach; ?>
                </div>
            </section>
        </div>
    </article>


<?php //$this->start("scripts"); ?>
<!--<div id="fb-root"></div>-->
<!--<script>(function (d, s, id) {-->
<!--        var js, fjs = d.getElementsByTagName(s)[0];-->
<!--        if (d.getElementById(id)) return;-->
<!--        js = d.createElement(s);-->
<!--        js.id = id;-->
<!--        js.src = 'https://connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v3.1&appId=267654637306249&autoLogAppEvents=1';-->
<!--        fjs.parentNode.insertBefore(js, fjs);-->
<!--    }(document, 'script', 'facebook-jssdk'));</script>-->
<!---->
<!--<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>-->
<?php //$this->end(); ?>