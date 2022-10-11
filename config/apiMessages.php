<?php
$_SERVER['DOCUMENT_ROOT'] = dirname(__FILE__, 2);

return [
    'api' => [
        'userDoesntExistMessage' => "There isn't user with such email",
        'userSavedMessage' => "User saved",
        'userExistsMessage' => "There is user with such email",
        'paramsNotSetMessage' => "Parameters not set",
        'notValidTwoPartsUriMessage' => "Uri have to consists of two parts",
        'userDeletedMessage' => "User deleted",
        'notValidThreePartsUriMessage' => 'Uri have to consists of three parts',
        'userUpdateMessage' => "User updated",
    ]
];