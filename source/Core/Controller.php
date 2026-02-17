<?php

namespace Source\Core;

class Controller
{
    protected $view;

    public function __construct(?string $pathToViwes = null)
    {
        $this->view = new View($pathToViwes);
    }
}