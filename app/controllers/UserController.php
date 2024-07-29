<?php

namespace app\controllers;

class UserController extends Controller
{
    public function indexLogin()
    {
        self::view('login');
    }

    public function indexRegister()
    {
        self::view('register');
    }
    
    public function authenticate()
    {

    }
}