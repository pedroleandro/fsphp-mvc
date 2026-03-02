<?php

namespace Source\App\Controllers;

use Source\Core\Connect;
use Source\Core\Controller;
use Source\Models\Auth;
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
        $search = $data['search'] ?? null;
        $page = $data['page'] ?? 1;

        $page = filter_var($page, FILTER_VALIDATE_INT);
        $page = ($page >= 1 ? $page : 1);

        if ($search) {
            $posts = (new Post())->find(
                "title LIKE :s",
                "s=%{$search}%"
            );
        } else {
            $posts = (new Post())->find();
        }

        $pager = new Pager(url("/blog/{$search}/"));
        $pager->pager($posts->count(), 9, $page);

        echo $this->view->render("blog", [
            "title" => "Blog | CafeControl",
            "paginator" => $pager->render(),
            "posts" => $posts
                ->limit($pager->limit())
                ->offset($pager->offset())
                ->fetch(true),
            "search" => $search
        ]);
    }

    public function blogSearch(?array $data): void
    {
        header('Content-Type: application/json; charset=utf-8');

        $search = trim($data['s'] ?? '');

        if (empty($search)) {
            echo json_encode([
                "message" => "<p class='form_error'>Digite algo para pesquisar.</p>"
            ]);
            return;
        }

        $search = str_slug($search);

        echo json_encode([
            "redirect" => url("/blog/{$search}/1")
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

    public function register(?array $data): void
    {
        if (!empty($data)) {
            header('Content-Type: application/json; charset=utf-8');
            $json = [];

            if (!csrf_verify($data)) {
                $json["message"] = message()
                    ->error("Erro ao enviar dados. Use o formulário!")
                    ->render();

                echo json_encode($json);
                return;
            }

            if (in_array("", $data)) {
                $json["message"] = $this->message->info("Informe seus dados para criar sua conta!")->render();
                echo json_encode($json);
                return;
            }

            $auth = new Auth();
            $user = new User();

            $user->bootstrap(
                $data["first_name"],
                $data["last_name"],
                $data["email"],
                $data["password"]
            );

            if ($auth->register($user)) {
                $json["redirect"] = url("/confirma");

            } else {
                $json['message'] = $auth->getMessage()->render();
            }

            echo json_encode($json);
            return;
        }

        echo $this->view->render("auth-register", [
            "title" => "Cadastrar | CafeControl"
        ]);
        return;
    }

    public function confirm()
    {
        echo $this->view->render("optin", [
            "title" => "Confirma | CafeControl",
            "data" => (object)[
                "title" => "Falta pouco! Confirme seu cadastro.",
                "description" => "Enviamos um link de confirmação para seu e-mail. Acesse e siga as instruções para concluir seu cadastro e comece a controlar com o CaféControl",
                "image" => theme("/assets/images/optin-confirm.jpg")
            ],
        ]);
    }

    public function success(array $data)
    {
        $email = base64_decode($data['email']);
        $user = (new User())->findByEmail($email);

        if ($user && $user->getStatus() == "registered") {
            $user->confirm();
        }

        echo $this->view->render("optin", [
            "title" => "Obrigado | CafeControl",
            "data" => (object)[
                "title" => "Tudo pronto. Você já pode controlar :)",
                "description" => "Bem-vindo(a) ao seu controle de contas, vamos tomar um café?",
                "image" => theme("/assets/images/optin-success.jpg"),
                "link" => url("/entrar"),
                "linkTitle" => "Entrar"
            ]
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