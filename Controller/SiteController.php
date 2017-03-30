<?php

namespace Controller;


use Library\Controller;
use Library\Request;
use Model\Form\ContactForm;
use Model\Feedback;
use Library\Router;
use Library\Session;
use Model\Books;


class SiteController extends Controller
{
    public function indexAction(Request $request)
    {
        $repo = $this->container->get('repository_manager')->getRepository('Book');
        $first = $repo->findNumb('1', '5');
        $second = $repo->findNumb('2', '5');
        
        $args = ['first' => $first, 'second' => $second];

        return $this->render('index.phtml',  $args);
    }
    
    public function contactAction(Request $request)
    {
        $form = new ContactForm($request);
        $repo = $this->container->get('repository_manager')->getRepository('Feedback');
        
        if ($request->isPost()) {
            if ($form->isValid()) {
                $feedback = (new Feedback())
                    ->setName($form->username)
                    ->setEmail($form->email)
                    ->setMessage($form->message)
                    ->setIpAddress($request->getIpAddress())
                ;
                
                $repo->save($feedback);
                Session::setFlash('Feedback saved.<br> But we dont care about it :)<br> Have a good day :3');
                $this->container->get('router')->redirect('/contact-us');
            }
            
            Session::setFlash('Fill the fields');
        }
        
        
        return $this->render('contact.phtml', ['form' => $form]);
    }

    public function infoAction()
    {
        return $this->render('info.phtml');
    }

   
}