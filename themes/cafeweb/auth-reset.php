<?php $this->layout("_theme", [
        "title" => $title
]); ?>

<article class="auth">
    <div class="auth_content container content">
        <header class="auth_header">
            <h1>Criar nova senha</h1>
            <p>Informe e repita a nova senha para recuperar o acesso.</p>
        </header>

        <form class="auth_form" action="<?= url('/recuperar/resetar'); ?>" method="post" enctype="multipart/form-data">

            <div class="search_message">
                <?= (new \Source\Core\Session())->flash(); ?>
            </div>

            <input type="hidden" name="code" value="<?= $code ?? "" ?>">

            <?= csrf_input(); ?>
            <label>
                <div class="unlock-alt">
                    <span class="icon-envelope">Nova Senha:</span>
                </div>
                <input type="password" name="password" placeholder="Informe sua nova senha:" required/>
            </label>

            <label>
                <div class="unlock-alt">
                    <span class="icon-envelope">Repita Nova Senha:</span>
                    <span><a title="Voltar e entrar" href="<?= url("/entrar"); ?>">Voltar e entrar!</a></span>
                </div>
                <input type="password" name="password-confirm" placeholder="Informe novamente sua nova senha:" required/>
            </label>

            <button class="auth_form_btn transition gradient gradient-green gradient-hover">Resetar</button>
        </form>
    </div>
</article>