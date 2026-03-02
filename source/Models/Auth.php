<?php

namespace Source\Models;

use Source\Core\Email;
use Source\Core\Model;
use Source\Core\View;

class Auth extends Model
{

    public function __construct()
    {
        parent::__construct("users", ["id"], ["email", "password"]);
    }

    public function register(User $user): bool
    {
        if (!$user->save()) {
            $this->message = $user->message;
            return false;
        }

        $view = new View(__DIR__ . "/../../assets/views/email");

        $message = $view->render("confirm", [
            "first_name" => $user->getFirstName(),
            "confirm_link" => url("/obrigado/" . base64_encode($user->getEmail())),
        ]);

        (new Email())->bootstrap(
            "Ative sua conta no " . CONF_SITE_NAME,
            $message,
            $user->getEmail(),
            "{$user->getFirstName()} {$user->getLastName()}",
        )->send();

        return true;
    }

    protected function data()
    {
        // TODO: Implement data() method.
    }
}