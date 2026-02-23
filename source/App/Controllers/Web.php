<?php

namespace Source\App\Controllers;

use Source\Core\Controller;
use Source\Support\Pager;

class Web extends Controller
{
    public function __construct()
    {
        parent::__construct(__DIR__ . "/../../../themes/" . CONFIG_VIEW_THEME . "/");
    }

    public function home(): void
    {
        echo $this->view->render("home", [
            "title" => "Home | CafeControl",
        ]);
    }

    public function about(): void
    {
        echo $this->view->render("about", [
            "title" => "Sobre | CafeControl",
        ]);
    }

    public function terms(): void
    {
        echo $this->view->render("terms", [
            "title" => "Termos de Uso | CafeControl",
        ]);
    }

    public function blog(?array $data): void
    {
        $pager = new Pager(url('/blog/page/'));
        $pager->pager(100, 10, ($data['page'] ?? 1));

        echo $this->view->render("blog", [
            "title" => "Blog | CafeControl",
            "paginator" => $pager->render()
        ]);
    }

    public function blogPost(array $data): void
    {
        $postName = $data["postName"];

        echo $this->view->render("blog-post", [
            "title" => "{$postName} | CafeControl"
        ]);
    }

    public function login()
    {
        echo $this->view->render("auth-login", [
            "title" => "Entrar | CafeControl"
        ]);
    }

    public function forget()
    {
        echo $this->view->render("auth-forget", [
            "title" => "Recuperar | CafeControl"
        ]);
    }

    public function register()
    {
        echo $this->view->render("auth-register", [
            "title" => "Cadastrar | CafeControl"
        ]);
    }

    public function confirm()
    {
        echo $this->view->render("optin-confirm", [
            "title" => "Confirma | CafeControl"
        ]);
    }

    public function success()
    {
        echo $this->view->render("optin-success", [
            "title" => "Obrigado | CafeControl"
        ]);
    }

    public function error(array $data): void
    {
        echo $this->view->render("error", [
            "title" => "Erro {$data['errorCode']} | CafeControl!",
            "error" => (object)[
                "code" => $data['errorCode'],
                "title" => "Ooops. Essa página não existe",
                "message" => "Sentimos muito, mas o conteúdo que você tentou acessar não existe, está indisponível ou foi removido",
                "linkTitle" => "Continue navegando",
                "link" => url()
            ]
        ]);
    }
}