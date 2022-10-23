<?php

return [
    'get' => [
        '/' => [App\Controllers\UserController::class, "all"],
        '/users' => [App\Controllers\UserController::class, "all"],
        '/file' => ["FileController", "all"],
        '/updateForm/{id}' => [App\Controllers\UserController::class, "showUpdate"],
        '/registration' => [App\Controllers\UserController::class, "showRegistration"],
        '/login' => [App\Controllers\UserController::class, "showLogin"],
        '/checkUser' => [App\Controllers\UserController::class, "checkUser"],
        '/welcome' => [App\Controllers\UserController::class, "showWelcome"],
        '/logout' => [App\Controllers\UserController::class, "logout"],
        '/block' => ["UserSessionInformationController", "block"],
        '/api/v1/users' => [App\Controllers\Api\V1\Impl\UserApi::class, "all"],
    ],

    'post' => [
        '/register' => [App\Controllers\UserController::class, "add"],
        '/create' => ["FileController", "create"],
        '/add' => [App\Controllers\UserController::class, "add"],
    ],

    'delete' => [
        '/delete/{id}' => [App\Controllers\UserController::class, "delete"],
    ],

    'put' => [
        '/update/{id}' => [App\Controllers\UserController::class, "update"],
    ]
];
