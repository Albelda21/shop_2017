<?php

namespace Controller\Admin;

use Library\Controller;
use Library\Session;

class DefaultController extends Controller
{
    public function indexAction()
    {
        if (!Session::has('user')) {
            $this->container->get('router')->redirect('/login');
        } 
        if (Session::get('user') !== 'admin@adminka.com') {
        	$this->container->get('router')->redirect('/');
        }
        
        return $this->render('index.phtml');
    }
}