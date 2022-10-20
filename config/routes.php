<?php

return [
    'routes' => [
        '/' => ["UserController", "all", "auth"],
        '/user' => ["UserController", "all", "auth"],
        '/add' => ["UserController", "add"],
        '/delete/{id}' => ["UserController", "delete", "auth"],
        '/update/{id}' => ["UserController", "update", "auth"],
        '/updateForm/{id}' => ["UserController", "showUpdate", "auth"],
        '/file' => ["FileController", "all", "auth"],
        '/create' => ["FileController", "create", "auth"],
        '/register' => ["UserController", "showRegistration"],
        '/login' => ["UserController", "showLogin"],
        '/checkUser' => ["UserController", "checkUser"],
        '/welcome' => ["UserController", "showWelcome", "auth"],
        '/logout' => ["UserController", "logout", "auth"],
    ]
];