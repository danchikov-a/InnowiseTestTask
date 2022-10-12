<?php
$_SERVER['DOCUMENT_ROOT'] = dirname(__FILE__, 2);

return [
    'routes' => [
        '/' => ["UserController", "all"],
        '/user' => ["UserController", "all"],
        '/add' => ["UserController", "add"],
        '/delete' => ["UserController", "delete"],
        '/update' => ["UserController", "update"],
        '/updateForm' => ["UserController", "showUpdate"],
        '/file' => ["FileController", "all"],
        '/create' => ["FileController", "create"],
        '/register' => ["UserController", "showRegistration"],
        '/login' => ["UserController", "showLogin"],
        '/checkUser' => ["UserController", "checkUser"],
        '/welcome' => ["UserController", "showWelcome"],
    ]
];