<?php

return [
    'get' => [
        '/' => [App\Controllers\UserController::class, "all", [App\Middleware\CheckAuthUserMiddleware::class]],
        '/users' => [App\Controllers\UserController::class, "all", [App\Middleware\CheckAuthUserMiddleware::class]],
        '/file' => [App\Controllers\FileController::class, "all", [App\Middleware\CheckAuthUserMiddleware::class]],
        '/updateForm/{id}' => [App\Controllers\UserController::class, "showUpdate", [App\Middleware\CheckAuthUserMiddleware::class]],
        '/registration' => [App\Controllers\UserController::class, "showRegistration"],
        '/login' => [App\Controllers\UserController::class, "showLogin"],
        '/checkUser' => [App\Controllers\AuthorizationController::class, "checkUser"],
        '/welcome' => [App\Controllers\UserController::class, "showWelcome", [App\Middleware\CheckAuthUserMiddleware::class]],
        '/logout' => [App\Controllers\AuthorizationController::class, "logout", [App\Middleware\CheckAuthUserMiddleware::class]],
        '/block' => [App\Controllers\UserSessionInformationController::class, "block"],
        '/api/v1/users' => [App\Controllers\Api\V1\Impl\UserApi::class, "all"],
    ],

    'post' => [
        '/register' => [App\Controllers\UserController::class, "add"],
        '/create' => [App\Controllers\FileController::class, "create", [App\Middleware\CheckAuthUserMiddleware::class]],
        '/add' => [App\Controllers\UserController::class, "add", [App\Middleware\CheckAuthUserMiddleware::class]],
    ],

    'delete' => [
        '/delete/{id}' => [App\Controllers\UserController::class, "delete", [App\Middleware\CheckAuthUserMiddleware::class]],
    ],

    'put' => [
        '/update/{id}' => [App\Controllers\UserController::class, "update", [App\Middleware\CheckAuthUserMiddleware::class]],
    ]
];
