<?php
return [
    '~^$~' => [\MyProject\Controllers\MainController::class, 'main'],
    '~^hello/(.*)$~' => [\MyProject\Controllers\MainController::class, 'sayHello'],
    '~^bye/(.*)$~' => [\MyProject\Controllers\MainController::class, 'sayBye'],
    '~^articles/(\d+)$~' => [\MyProject\Controllers\ArticlesController::class, 'view'],
    '~^articles/(\d+)/edit$~' => [\MyProject\Controllers\ArticlesController::class, 'edit'],
    '~^articles/add$~' => [\MyProject\Controllers\ArticlesController::class, 'add'],
    '~^articles/(\d+)/save$~' => [\MyProject\Controllers\ArticlesController::class, 'save'],
    '~^articles/(\d+)/comments$~' => [\MyProject\Controllers\ArticlesController::class, 'comments'],
    '~^articles/(\d+)/addComment$~' => [\MyProject\Controllers\ArticlesController::class, 'addComment'],
    '~^comments/(\d+)/edit$~' => [\MyProject\Controllers\CommentsController::class, 'edit'],
];