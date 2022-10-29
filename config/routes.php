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
        '/api/v1/users' => [App\Controllers\Api\V1\UserApiController::class, "getAll"],
        '/api/v1/users/{id}' => [App\Controllers\Api\V1\UserApiController::class, "get"],
        '/delete/{id}' => [App\Controllers\UserController::class, "delete", [App\Middleware\CheckAuthUserMiddleware::class]],
        '/products' => [App\Controllers\ProductController::class, "showAll", [App\Middleware\CheckAuthUserMiddleware::class]],
        '/products/{id}' => [App\Controllers\ProductController::class, "show", [App\Middleware\CheckAuthUserMiddleware::class]],
        '/cart' => [App\Controllers\CartController::class, "showAll", [App\Middleware\CheckAuthUserMiddleware::class]],
        '/cart/checkout' => [App\Controllers\CheckoutController::class, "showCheckout", [App\Middleware\CheckAuthUserMiddleware::class]],
    ],

    'POST' => [
        '/register' => [App\Controllers\UserController::class, "add"],
        '/create' => [App\Controllers\FileController::class, "add", [App\Middleware\CheckAuthUserMiddleware::class]],
        '/add' => [App\Controllers\UserController::class, "add", [App\Middleware\CheckAuthUserMiddleware::class]],
        '/update/{id}' => [App\Controllers\UserController::class, "update", [App\Middleware\CheckAuthUserMiddleware::class]],
        '/api/v1/users' => [App\Controllers\Api\V1\UserApiController::class, "post"],
        '/checkUser' => [App\Controllers\AuthorizationController::class, "checkUser"],
        '/products/{id}/services/{id}' => [App\Controllers\ServiceController::class, "add", [App\Middleware\CheckAuthUserMiddleware::class]],
        '/products/{id}/services/delete/{id}' => [App\Controllers\ServiceController::class, "delete", [App\Middleware\CheckAuthUserMiddleware::class]],
        '/products/{id}/addToCart' => [App\Controllers\CartController::class, "addToCart", [App\Middleware\CheckAuthUserMiddleware::class]],
        '/cart/{id}/deleteFromCart' => [App\Controllers\CartController::class, "deleteFromCart", [App\Middleware\CheckAuthUserMiddleware::class]],
    ],

    'DELETE' => [
        '/api/v1/users/{id}' => [App\Controllers\Api\V1\UserApiController::class, "delete"],
    ],

    'PUT' => [
        '/api/v1/users/{id}' => [App\Controllers\Api\V1\UserApiController::class, "put"],
    ]
];
