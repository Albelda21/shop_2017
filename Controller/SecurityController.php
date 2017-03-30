<?php

namespace Controller;

use Library\Controller;
use Library\Request;
use Library\Session;
use Library\Password;
use Library\Router;
use Model\Form\LoginForm;
use Model\Form\RegisterForm;
use Model\User;

class SecurityController extends Controller
{
    public function loginAction(Request $request)
    {
        $form = new LoginForm($request);
        if ($request->isPost()) {
            if ($form->isValid()) {
                $password = new Password($form->password);
                $email = $form->email;
                
                $repo = $this->container->get('repository_manager')->getRepository('User');
                if ($user = $repo->find($email, $password)) {
                    Session::set('user', $user->getEmail());
                    Session::setFlash('Success. You are in');
                    
                    $this->container->get('router')->redirect('/');
                } 
                
                Session::setFlash('Fail. No user found');
                // todo: make helpers like $this->redirect('/blah'), $this->pageReload()
                $this->container->get('router')->redirect('/login');
            }
            
            Session::setFlash('Fill the fields');
        }
        
        return $this->render('login.phtml', ['form' => $form]);
    }
    
    public function logoutAction(Request $request)
    {
        Session::remove('user');
        Session::setFlash('Logout success');
        $this->container->get('router')->redirect('/');
    }
    
    public function registerAction(Request $request)
    {
        $form = new RegisterForm($request);
        if ($request->isPost()) {
            if ($form->isValid()) {
                
                $email = $form->email;
                $repo = $this->container->get('repository_manager')->getRepository('User');
                 if ($user = $repo->findByEmail($email)) {

                    Session::setFlash('User already exist!');
                    $this->container->get('router')->redirect('/register');
                }
                $password = new Password($form->password);      
                $user = (new User())
                    ->setEmail($form->email)
                    ->setPassword($password)
                ;
                Session::setFlash('Registration success');
                $this->container->get('repository_manager')->getRepository('User')->save($user);
                $this->container->get('router')->redirect('/login');
            }
        
            
            Session::setFlash('Bad data');
        }
        
        
        return $this->render('register.phtml', ['form' => $form]);
    }
}