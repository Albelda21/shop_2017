<?php

namespace Controller\Admin;

use Library\Controller;
use Library\Request;
use Library\Session;
use Model\Form\BookForm;
use Model\Book;
use Library\Router;

class BookController extends Controller
{
    public function indexAction(Request $request)
    {
        if (!Session::has('user')) {
            $this->container->get('router')->redirect('/login');
        }
        if (Session::get('user') !== 'admin@adminka.com') {
            $this->container->get('router')->redirect('/');
        }
        
        $repo = $this->container->get('repository_manager')->getRepository('Book');
        // todo: findActive();
        $books = $repo->findAll();
        
        $args = ['books' => $books];
        
        return $this->render('index.phtml', $args);
    }
    
    public function editAction(Request $request)
    {
        if (!Session::has('user')) {
            $this->container->get('router')->redirect('/login');
        }
        if (Session::get('user') !== 'admin@adminka.com') {
            $this->container->get('router')->redirect('/');
        }
        
        $id = $request->get('id');
        $book = $this->container->get('repository_manager')->getRepository('Book')->find($id);
        $repo = $this->container->get('repository_manager')->getRepository('Book');
        $form = new BookForm($request); // todo

        if ($request->isPost()) {
            if ($form->isValid()) {
                $book = (new Book())
                    ->setId($request->get('id'))
                    ->setTitle($form->title)
                    ->setDescription($form->description)
                    ->setPrice($form->price)
                    ->setSale($form->sale)
                ;
                              
                $repo->save($book);
                Session::setFlash('<b> Book edit succes!</b> ');
            }
        }
        return $this->render('edit.phtml', ['request' => $request, 'form' => $form, 'book' => $book]);
    }
    
    public function addAction(Request $request)
    {
        $form = new BookForm($request);
        $repo = $this->container->get('repository_manager')->getRepository('Book');
        
        if ($request->isPost()) {
            if ($form->isValid()) {
                $book = (new Book())
                    ->setTitle($form->title)
                    ->setDescription($form->description)
                    ->setPrice($form->price)
                    ->setSale($form->sale)
                    ->setStyle($form->style)
                ;
                
                $repo->add($book);
                Session::setFlash('Book has been added');
                $this->container->get('router')->redirect('/admin/add');
            }
            
            Session::setFlash('Fill the fields');
        }
        
        
        return $this->render('add.phtml', ['form' => $form]);
    }
    
    public function deleteAction(Request $request)
    {
        $id = $request->get('id');
        $book = $this->container->get('repository_manager')->getRepository('Book')->find($id);
        $this->container->get('repository_manager')->getRepository('Book')->removeById($id);
        Session::setFlash('Book have been deleted!');
        Router::redirect('/admin/books');  
    }

    
}