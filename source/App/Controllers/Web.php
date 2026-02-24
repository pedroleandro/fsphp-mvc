<?php

namespace Source\App\Controllers;

use Source\Core\Connect;
use Source\Core\Controller;
use Source\Models\Category;
use Source\Models\Faq\Channel;
use Source\Models\Faq\Question;
use Source\Models\Post;
use Source\Models\User;
use Source\Support\Pager;
use stdClass;

class Web extends Controller
{
    public function __construct()
    {
//        redirect("/error/manutencao");

        Connect::getInstance();

        parent::__construct(__DIR__ . "/../../../themes/" . CONFIG_VIEW_THEME . "/");
    }

    public function home(): void
    {

        $posts = (new Post())->find()->order("post_at DESC")->limit(6)->fetch(true);

        echo $this->view->render("home", [
            "title" => "Home | CafeControl",
            "posts" => $posts
        ]);
    }

    public function about(): void
    {
        $channel = (new Channel())->findById(1);
        $questions = $channel->questions();

        echo $this->view->render("about", [
            "title" => "Sobre | CafeControl",
            "questions" => $questions,
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
        $posts = (new Post())->find();

        $pager = new Pager(url('/blog/pagina/'));
        $pager->pager($posts->count(), 9, ($data['page'] ?? 1));

        echo $this->view->render("blog", [
            "title" => "Blog | CafeControl",
            "paginator" => $pager->render(),
            "posts" => $posts->limit($pager->limit())->offset($pager->offset())->fetch(true),
            "search" => $data['search'] ?? "TESTE",
        ]);
    }

    public function blogPost(array $data): void
    {
        $post = (new Post())->findByUri($data['uri'])->fetch();

        if (!$post) {
            redirect("error/404");
        }

        $posts = (new Post())->find()->order("rand()")->limit(3)->fetch(true);

        echo $this->view->render("blog-post", [
            "title" => "{$post->getTitle()}| CafeControl",
            "post" => $post,
            "posts" => $posts
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

        $error = new stdClass();

        switch ($data["errorCode"]) {
            case "problemas":
                $error->code = "OPS";
                $error->title = "Ooops. Estamos enfrentando problemas!";
                $error->message = "Parece que o nosso conteúdo não está disponível no momento. Já estamos vendo isso, mas caso precise envie um e-mail";
                $error->linkTitle = "Enviar e-mail";
                $error->link = "mailto:" . CONFIG_EMAIL_FROM_EMAIL;
                break;
            case "manutencao":
                $error->code = "OPS";
                $error->title = "Ooops. Estamos em manutenção";
                $error->message = "Voltamos logo! Por hora estamos trabalhando para melhorar nosso conteúdo para você controlar melhor as suas contas!";
                $error->linkTitle = null;
                $error->link = null;
                break;
            default:
                $error->code = $data["errorCode"];
                $error->title = "Ooops. Essa página não existe";
                $error->message = "Sentimos muito, mas o conteúdo que você tentou acessar não existe, está indisponível ou foi removido";
                $error->linkTitle = "Continue navegando";
                $error->link = url();
                break;
        }

        echo $this->view->render("error", [
            "title" => "Erro {$data['errorCode']} | CafeControl!",
            "error" => $error
        ]);
    }
}