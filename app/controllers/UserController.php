<?php

namespace app\controllers;

class UserController extends Controller
{
    public function indexLogin()
    {
        $this->view('login');
    }

    public function indexRegister()
    {
        $this->view('register');
    }
    
    public function authenticate()
    {

    }
}