<?php
$_SERVER['DOCUMENT_ROOT'] = dirname(__FILE__, 2);

return [
    'db' => [
        'host' => 'mysql:host=mysql_container;port=3306;dbname=innowise',
        'user' => 'root',
        'password' => 'root0root',
    ]
];