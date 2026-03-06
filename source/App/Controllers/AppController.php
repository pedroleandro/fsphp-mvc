<?php

namespace Source\App\Controllers;

use Source\Core\Controller;
use Source\Core\Message;
use Source\Core\Session;
use Source\Models\Auth;

class AppController extends Controller
{
    public function __construct()
    {
        parent::__construct(__DIR__ . "/../../../themes/cafeapp");

        if (!Auth::user()) {
            $this->message->warning("Efetue login para acessar o sistema")->flash();
            redirect("/entrar");
        }

    }

    public function home()
    {
        echo (new Session())->flash();
        var_dump(Auth::user());
        echo "<a title='sair' href='" . url("app/sair") . "'>Sair</a>";
    }

    public function logout()
    {
        (new Message)->info("Volte logo, " . Auth::user()->getFirstName() . "!")->flash();
        Auth::logout();
        redirect("/entrar");
    }
}