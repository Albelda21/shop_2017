<?php 

namespace Controller\Admin;

use Library\Controller;
use Library\Request;
use Library\Session;
use Model\Form\CommentForm;
use Model\Comment;
use Library\Router;

class CommentController extends Controller 
{
	public function indexAction(Request $request)
    {
        if (!Session::has('user')) {
            $this->container->get('router')->redirect('/login');
        }
        if (Session::get('user') !== 'admin@adminka.com') {
            $this->container->get('router')->redirect('/');
        }
        
        $repo = $this->container->get('repository_manager')->getRepository('Comment');
        // todo: findActive();
        $comments = $repo->findAll();
        
        $args = ['comments' => $comments];
        
        return $this->render('index.phtml', $args);
    }

    public function negativeAction(Request $request)
    {
        $id = $request->get('id');
        return $this->render('negative.phtml');
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
		$comment = $this->container->get('repository_manager')->getRepository('Comment')->find($id);
        $repo = $this->container->get('repository_manager')->getRepository('Comment');
        $form = new CommentForm($request);
        
         if ($request->isPost()) {
            if ($form->isValid()) {
                $comment = (new Comment())
                    ->setId($id)            		
            		->setComment($form->comment)
                    ->setActive($form->good)
                    ;
                  
                                
            $repo->saveComment($comment);
            Session::setFlash('<b> Comment edit succes!</b> ');
            }
        }

		

    return $this->render('edit_comment.phtml', 
        [
        'comment' => $comment, 
        'request' => $request, 
        'form' =>$form
        ]

        );
	}

    public function deleteAction(Request $request)
    {
        $id = $request->get('id');
        $comment = $this->container->get('repository_manager')->getRepository('Comment')->find($id);
        $this->container->get('repository_manager')->getRepository('Comment')->removeById($id);
        Session::setFlash('Comment have been deleted!');
        Router::redirect('/admin/comment');  
    }

}





 ?>