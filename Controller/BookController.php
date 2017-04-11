<?php

namespace Controller;

use Library\Controller;
use Library\Request;
use Library\Pagination\Pagination;
use Model\Form\CommentForm;
use Library\Session;
use Model\Comment;

class BookController extends Controller
{
    const BOOKS_PER_PAGE = 5;
    
    /**
     * 
     * @param Request
     * @return string
     * 
     */
    public function indexAction(Request $request)
    {
        $repo = $this->container->get('repository_manager')->getRepository('Book');
        $page = (int) $request->get('page', 1);
        $count = $repo->count('1');
        // todo: findActive();
        $books = $repo->findActiveByPage($page, self::BOOKS_PER_PAGE, '2');
        
        if (!$books && $count) {
            $this->container->get('router')->redirect('/books');
        }
        
        $pagination = new Pagination(['itemsCount' => $count, 'itemsPerPage' => self::BOOKS_PER_PAGE, 'currentPage' => $page]);
        
        $args = [
            'books' => $books,
            'pagination' => $pagination
        ];
        
        return $this->render('index.phtml', $args);
    }
    
    /**
     * 
     * @param Request
     * @return string
     * 
     */
    public function showAction(Request $request)
    {
        $repo = $this->container->get('repository_manager')->getRepository('Book');
        $id = $request->get('id');
        $book = $repo->find($id);      
        

        $form = new CommentForm($request);
        $repo = $this->container->get('repository_manager')->getRepository('Comment');
        //$comment = $repo->findComment($id);

        if (\Library\Session::has('user')) {     
            if ($request->isPost()) {
                if ($form->isValid()) {
                    $comment = (new Comment())
                        ->setBookId($_GET['id'])
                        ->setEmail($form->email)
                        ->setComment($form->comment)     
                        ->setActive($form->good)

                    ;
                    
                    $repo->save($comment);
                    Session::setFlash('<div class="alert alert-success">
                                     <strong>Success!</strong> Comment saved!.
                                    </div>');
                    $this->container->get('router')->redirect("/horror-{$id}.html");
                }

                Session::setFlash('Fill the fields');
             }

        }
         
        return $this->render('show.phtml', compact('book', 'form', 'comment'));
    }

    public function horrorAction(Request $request)
        {
            $repo = $this->container->get('repository_manager')->getRepository('Book');
            $page = (int) $request->get('page', 1);
            $count = $repo->count('1');
            $horrors = $repo->findActiveByPage($page, self::BOOKS_PER_PAGE, '1');
            
            if (!$horrors && $count) {
                $this->container->get('router')->redirect('/horror');
            }
            
            $pagination = new Pagination(['itemsCount' => $count, 'itemsPerPage' => self::BOOKS_PER_PAGE, 'currentPage' => $page]);
            
            $args = [
                'horrors' => $horrors,
                'pagination' => $pagination
            ];
            
            return $this->render('horror.phtml', $args);
        }



}