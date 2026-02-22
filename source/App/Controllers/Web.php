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

    public function error(array $data): void
    {
        echo $this->view->render("error", [
            "title" => "Erro {$data['errorCode']} | CafeControl!",
        ]);
    }
}