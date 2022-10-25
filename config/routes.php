<?php

return [
    'GET' => [
        '/' => [App\Controllers\UserController::class, "all", [App\Middleware\CheckAuthUserMiddleware::class]],
        '/users' => [App\Controllers\UserController::class, "all", [App\Middleware\CheckAuthUserMiddleware::class]],
        '/file' => [App\Controllers\FileController::class, "all", [App\Middleware\CheckAuthUserMiddleware::class]],
        '/updateForm/{id}' => [App\Controllers\UserController::class, "showUpdate", [App\Middleware\CheckAuthUserMiddleware::class]],
        '/registration' => [App\Controllers\UserController::class, "showRegistration"],
        '/login' => [App\Controllers\UserController::class, "showLogin"],
        '/welcome' => [App\Controllers\UserController::class, "showWelcome", [App\Middleware\CheckAuthUserMiddleware::class]],
        '/logout' => [App\Controllers\AuthorizationController::class, "logout", [App\Middleware\CheckAuthUserMiddleware::class]],
        '/block' => [App\Controllers\UserSessionInformationController::class, "block"],
        '/api/v1/users' => [App\Controllers\Api\V1\Impl\UserApi::class, "getAll"],
        '/api/v1/users/{id}' => [App\Controllers\Api\V1\Impl\UserApi::class, "get"],
        '/delete/{id}' => [App\Controllers\UserController::class, "delete", [App\Middleware\CheckAuthUserMiddleware::class]],
    ],

    'POST' => [
        '/register' => [App\Controllers\UserController::class, "add"],
        '/create' => [App\Controllers\FileController::class, "add", [App\Middleware\CheckAuthUserMiddleware::class]],
        '/add' => [App\Controllers\UserController::class, "add", [App\Middleware\CheckAuthUserMiddleware::class]],
        '/update/{id}' => [App\Controllers\UserController::class, "update", [App\Middleware\CheckAuthUserMiddleware::class]],
        '/api/v1/users' => [App\Controllers\Api\V1\Impl\UserApi::class, "post"],
        '/checkUser' => [App\Controllers\AuthorizationController::class, "checkUser"],
    ],

    'DELETE' => [
        '/api/v1/users/{id}' => [App\Controllers\Api\V1\Impl\UserApi::class, "delete"],
    ],

    'PUT' => [
        '/api/v1/users/{id}' => [App\Controllers\Api\V1\Impl\UserApi::class, "put"],
    ]
];
