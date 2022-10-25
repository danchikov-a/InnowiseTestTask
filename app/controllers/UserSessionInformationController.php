<?php

namespace App\Controllers;

use App\Models\Impl\BlockingInformationLogger;
use App\Models\Impl\UserSessionInformation;

class UserSessionInformationController extends BaseController
{
    private const LOGIN_ATTEMPTS = 3;
    private const BLOCK_DURATION = 10;

    private UserSessionInformation $userSessionInformation;

    public function __construct()
    {
        parent::__construct();
        $this->userSessionInformation = new UserSessionInformation();
    }

    public function block(): void
    {
        $ip = $_SERVER['REMOTE_ADDR'];

        $userSessionInformation = $this->userSessionInformation->getByIp($ip);

        if ($userSessionInformation) {
            $attempts = $userSessionInformation->getAttempts();

            if ($attempts == self::LOGIN_ATTEMPTS - 1) {
                $this->session->setValidationError('authenticateError', 'q');
                $blockTime = time();

                $userSessionInformation->setBlockTime($blockTime);

                $logMessage = sprintf("%s %s %s", $ip, date('m/d/Y H:i:s', $blockTime),
                    date('m/d/Y H:i:s', self::BLOCK_DURATION + $blockTime));

                BlockingInformationLogger::writeLog($logMessage);
            } else {
                $attempts++;
                $blockTime = 0;
            }

            $this->userSessionInformation->update(['ip' => $ip, 'attempts' => $attempts, 'blockTime' => $blockTime, 'id' => $userSessionInformation->getId()]);
        } else {
            $this->userSessionInformation->store(['ip' => $ip, 'attempts' => 1, 'blockTime' => 0]);
        }

        $this->response->sendResponse(403, "/login");
        $this->response->redirect("/login");
    }
}