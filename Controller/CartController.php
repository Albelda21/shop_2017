<?php

namespace Controller;

use Library\Controller;
use Library\Request;
use Model\Cart;

class CartController extends Controller
{
    public function addAction(Request $request)
    {
        // repo - check if exists & active
        $id = $request->get('id');
        $cart = new Cart();
        $cart->addProduct($id);
        
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
    
    // maybe OrderController
    public function orderAction(Request $request)
    {
        /**
         * 1. Order table in DB  (id, user-data(?), email, order_item_id, created, status)
         * 2. OrderItem table (id, product_id, price)
         * 3. Form, Model
         * 
         * 
         * 
         **/ 
    }
}