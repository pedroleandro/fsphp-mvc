<?php

namespace Source\Core;

class Controller
{
    protected View $view;

    protected Message $message;

    public function __construct(?string $pathToViwes = null)
    {
        $this->view = new View($pathToViwes);
        $this->message = new Message();
    }
}