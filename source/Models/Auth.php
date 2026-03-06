<?php

namespace Source\Models;

use Source\Core\Email;
use Source\Core\Model;
use Source\Core\Session;
use Source\Core\View;

class Auth extends Model
{

    public function __construct()
    {
        parent::__construct("users", ["id"], ["email", "password"]);
    }

    public static function user(): ?User
    {
        $session = new Session();

        if (!$session->has("authUser")) {
            return null;
        }

        return (new User())->findById($session->authUser);
    }

    public static function logout(): void
    {
        $session = new Session();
        $session->unset("authUser");
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

    public function login(string $email, string $password, bool $save = false)
    {
        if (!is_email($email)) {
            $this->message->warning("O e-mail informado não é válido!");
            return false;
        }

        if ($save) {
            setcookie("authEmail", $email, time() + 604800, "/");
        } else {
            setcookie("authEmail", null, time() - 3600, "/");
        }

        if (!is_password($password)) {
            $this->message->warning("A senha informada não é válida!");
            return false;
        }

        $user = (new User())->findByEmail($email);
        if (!$user) {
            $this->message->error("Credenciais inválidas!");
            return false;
        }

        if (!password_verify($password, $user->getPassword())) {
            $this->message->error("Credenciais inválidas!");
            return false;
        }

        if (password_rehash($user->getPassword())) {
            $user->setPassword($password);
            $user->save();
        }

        (new Session())->set("authUser", $user->getId());
        $this->message->success("Login efetuado com sucesso!")->flash();
        return true;

    }

    public function forget(string $email): bool
    {
        $user = (new User())->findByEmail($email);

        if (!$user) {
            $this->message->warning("O email informado não está cadastrado!");
            return false;
        }

        $user->setForget(md5(uniqid(mt_rand(), true)));
        $user->save();

        $view = new View(__DIR__ . "/../../assets/views/email");
        $message = $view->render("forget", [
            "first_name" => $user->getFirstName(),
            "forget_link" => $user->getForget()
        ]);

        (new Email())->bootstrap(
            "Recupere sua senha no" . CONF_SITE_NAME,
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