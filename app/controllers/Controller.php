<?php

namespace app\controllers;

use League\Plates\Engine;

abstract class Controller
{
    public function view(string $view, array $data = [])
    {
        $pathViews = dirname(__FILE__, 3).DIRECTORY_SEPARATOR."public".DIRECTORY_SEPARATOR."views";
        $templates = new Engine($pathViews);

        echo $templates->render($view, $data);
    }
}
