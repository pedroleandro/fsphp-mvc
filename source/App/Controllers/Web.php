<?php

namespace Source\App\Controllers;

use Source\Core\Controller;

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