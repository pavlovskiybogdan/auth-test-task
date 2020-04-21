<?php

namespace App\src\Controllers;

use App\src\Entities\User;
use App\src\Services\AuthService;
use Framework\Application;
use Framework\View\View;
use Framework\Helpers\Session;
use Framework\Controller\Controller;
use Framework\Localization\Localization;
use Framework\Exceptions\QueryException;

class HomeController extends Controller
{
    /**
     * @return mixed
     */
    public function renderRegisterPage()
    {
        if (AuthService::isUserLoggedIn()) {
            $this->redirect('/profile');
        }

        return View::make('auth/register');
    }

    /**
     * @return mixed
     */
    public function renderLoginPage()
    {
        if (AuthService::isUserLoggedIn()) {
            $this->redirect('/profile');
        }

        return View::make('auth/login');
    }

    /**
     * @return mixed
     * @throws QueryException
     */
    public function renderProfilePage()
    {
        $model = new User();

        if (Session::get('email')) {
            $user = $model->findByEmail(Session::get('email'));
        }

        if (AuthService::isUserLoggedIn() && !empty($user)) {
            View::make('auth/profile', ['user' => $user]);
            return Session::delete('success_login');
        }

        return $this->redirect('/register');
    }

    /**
     * @return mixed
     * @throws QueryException
     */
    public function renderChangePasswordPage()
    {
        if (AuthService::isUserLoggedIn()) {
            $this->redirect('/profile');
        }

        $token = Application::$app->request->partialUrl[2];
        $user = User::table('users')->findByToken($token);

        if (empty($user)) {
            $this->redirect('/login');
        }

        return View::make('auth/change-password');
    }

    /**
     * @return mixed
     */
    public function renderResetPasswordPage()
    {
        return View::make('auth/forgot-password');
    }

    /**
     * Change interface language by post 'lang' parameter
     * @return mixed
     */
    public function changeLanguage()
    {
        $localization = new Localization();

        if (Application::$app->request->isPost) {
            $localization->setLanguage(Application::$app->request->bodyParams->lang);
        }

        return View::render404();
    }
}