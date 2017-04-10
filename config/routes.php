<?php

use Library\Route;

return  array(
    // site routes
    'default' => new Route('/', 'Site', 'index'),
    'index' => new Route('/index.php', 'Site', 'index'),

    'horror' => new Route('/horror', 'Book', 'horror'),
    'art' => new Route('/art', 'Book', 'index'),
    'horror_page' => new Route('/horror-{id}\.html', 'Book', 'show', array('id' => '[0-9]+') ),
    'art_page' => new Route('/art-{id}\.html', 'Book', 'show', array('id' => '[0-9]+') ),

    'books_list' => new Route('/books', 'Book', 'index'),
    'book_page' => new Route('/book-{id}\.html', 'Book', 'show', array('id' => '[0-9]+') ),
    'contact_us' => new Route('/contact-us', 'Site', 'contact'),
    'login' => new Route('/login', 'Security', 'login'),
    'info' => new Route('/info', 'Site', 'info'),
    'register' => new Route('/register', 'Security', 'register'),
    'logout' => new Route('/logout', 'Security', 'logout'),
    'cart_list' => new Route('/cart', 'Cart', 'showList'),
    'cart_add' => new Route('/cart/add/{id}', 'Cart', 'add', array('id' => '[0-9]+')),
    'cart_delete' => new Route('/cart/delete/', 'Cart', 'delete'),
    'cart_order' => new Route('/cart/order', 'Cart', 'order'),

    

    
    
    // admin routes
    'admin_default' => new Route('/admin', 'Admin\\Default', 'index'),
    'admin_books' => new Route('/admin/books', 'Admin\\Book', 'index'),
    'admin_comment' => new Route('/admin/comment', 'Admin\\Comment', 'index'),
    'admin_negative' => new Route('/admin/negative', 'Admin\\Comment', 'negative'),
    'admin_comment_edit' => new Route('/admin/comment/edit/{id}', 'Admin\\Comment', 'edit', array('id' => '[0-9]+')),
    'admin_badcomment_edit' => new Route('/admin/badcomment/edit/{id}', 'Admin\\Comment', 'badedit', array('id' => '[0-9]+')),
    'admin_comment_delete' => new Route('/admin/comment/delete/{id}', 'Admin\\Comment', 'delete', array('id' => '[0-9]+')),
    'admin_badcomment_delete' => new Route('/admin/badcomment/delete/{id}', 'Admin\\Comment', 'baddelete', array('id' => '[0-9]+')),
    'admin_book_edit' => new Route('/admin/books/edit/{id}', 'Admin\\Book', 'edit', array('id' => '[0-9]+')),
    'admin_book_add' => new Route('/admin/add', 'Admin\\Book', 'add'),
    'admin_book_delete' => new Route('/admin/book/delete/{id}', 'Admin\\Book', 'delete', array('id' => '[0-9]+')),
    
);
