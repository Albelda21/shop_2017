<?php

namespace Controller;

use Library\Controller;
use Library\Request;
use Library\Session;
use Library\Router;
use Model\Cart;
use Model\Order;
use Library\Cookie;
use Model\Form\OrderForm;

class CartController extends Controller
{
    public function addAction(Request $request)
    {
        // repo - check if exists & active
        $id = $request->get('id');
        $cart = new Cart();
        $cart->addProduct($id);
        
        Session::setFlash('Book has been added');
        $this->container->get('router')->redirect("/book-{$id}.html");
    }
    
    public function showListAction(Request $request)
    {
        $cart = new Cart();
        $repo = $this->container->get('repository_manager')->getRepository('Book');
        $books = $repo->findByIdArray($cart->getProducts());
        
        return $this->render('show.phtml', ['books' => $books]);
    }
    
    public function removeItemAction(Request $request)
    {
        
    }
    
    public function clearAction(Request $request)
    {
        
    }

     public function deleteAction(Request $request)
    {
       Cookie::delete('books');
       Router::redirect('/cart');
    }
    
    // maybe OrderController
    public function orderAction(Request $request)
    {
        $form = new OrderForm($request);
        $repo = $this->container->get('repository_manager')->getRepository('Cart');

        if ($request->isPost()) {
            if ($form->isValid()) {
                $order = (new Order())
                    ->setName($form->name)
                    ->setSurname($form->surname)
                    ->setEmail($form->email)
                    ->setPhone($form->phone)                   
                    
                ;
                
                $repo->save($order);
                Session::setFlash('Gotcha! We will call you soon!');
                Cookie::delete('books');
                $this->container->get('router')->redirect('/');
            }
            
            Session::setFlash('Fill the fields');
        }


       return $this->render('order.phtml', ['form' => $form]);
    }
}