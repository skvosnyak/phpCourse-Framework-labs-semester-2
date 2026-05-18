<?php
use MyProject\Controllers\MainController;

return [
    '#^/$#' => [
        'controller' => MainController::class,
        'action' => 'main'
    ],
    '#^/hello/(.+)$#' => [
        'controller' => MainController::class,
        'action' => 'sayHello'
    ],
    '#^/bye/(.+)$#' => [
        'controller' => MainController::class,
        'action' => 'sayBye'
    ],
];