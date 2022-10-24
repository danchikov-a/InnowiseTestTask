<?php

namespace App\Middleware;

class CheckAuthUserMiddleware extends BaseMiddleware
{
    private const USER_NAME_COOKIE = "userName";

    public function handle(string $requestUri): bool
    {
        $isAuth = isset($_COOKIE[self::USER_NAME_COOKIE]);

        if (!$isAuth) {
            $this->response->sendResponse(403, "/login");
            $this->response->redirect("/login");

            if ($requestUri != "/login") {
                $this->response->redirect("/login");
            }
        }

        return $isAuth;
    }
}