<?php

namespace App\Controllers;

use App\Models\Impl\UserSessionInformation;
use App\Services\UserSessionInformationService;

class UserSessionInformationController extends BaseController
{
    private UserSessionInformation $userSessionInformation;
    private UserSessionInformationService $userSessionInformationService;

    public function __construct()
    {
        parent::__construct();
        $this->userSessionInformation = new UserSessionInformation();
        $this->userSessionInformationService = new UserSessionInformationService();
    }

    public function block(): void
    {
        $ip = $_SERVER['REMOTE_ADDR'];

        $userSessionInformation = $this->userSessionInformation->getByIp($ip);

        if ($userSessionInformation) {
            $blockTimeAndAttempts = $this->userSessionInformationService->findBlockTimeAndAttempts($userSessionInformation);

            if ($blockTimeAndAttempts['blockTime'] != 0) {
                $this->session->setValidationError('authenticateError', 'q');
            }

            $this->userSessionInformation->update(['ip' => $ip, 'attempts' => $blockTimeAndAttempts['attempts'],
                'blockTime' => $blockTimeAndAttempts['blockTime'], 'id' => $userSessionInformation->getId()]);
        } else {
            $this->userSessionInformation->store(['ip' => $ip, 'attempts' => 1, 'blockTime' => 0]);
        }

        $this->response->sendResponse(403, "/login");
        $this->response->redirect("/login");
    }
}