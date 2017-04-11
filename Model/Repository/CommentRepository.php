<?php

namespace Model\Repository;

use Library\EntityRepository;
use Model\Comment;
use Library\Session;

class CommentRepository extends EntityRepository
{
    public function save($object, $table = null)
    {
        $class = explode('\\', get_class($object)); // Model\Feedback
        $class = end($class);
        $table = strtolower($class);
        
        $sql = 'insert into comment (books_id, email, comment, active) values (:books_id, :email, :comment, :active)';
        $sth = $this->pdo->prepare($sql);
        $sth->execute(array(
            'books_id' => $object->getBookId(),
            'email' => $object->getEmail(),
            'comment' => $object->getComment(),
            'active' => $object->getActive()
           
        ));
    }

      public function findComment($id)
    {
        $sth = $this->pdo->prepare("SELECT comment FROM comment WHERE books_id = '" . $_GET['id'] . "'");
        $sth->execute(compact('id'));
        $data = $sth->fetch(\PDO::FETCH_ASSOC);
        
        if (!$data) {
            throw new \Exception('not found');
        }
        
        return (new Comment()) 
                     
            ->setComment($data['comment'])
            ;
    }

     public function findAllComment()
    {
        $sth = $this->pdo->query('select comment from comment where books_id = :id');
        $comment = [];
        
        while ($row = $sth->fetch(\PDO::FETCH_ASSOC)) {
                        
            $comment = (new Comment())
                ->setId($row['id'])
                ->setBookId($_GET['id'])
                ->setEmail($row['email'])
                ->setComment($row['comment'])
           ;

            $comment[] = $comment;
        }

        return $comment;
    }

     public function findAll()
    {
        $sth = $this->pdo->query('select * from comment');
        $comments = [];
        
        while ($row = $sth->fetch(\PDO::FETCH_ASSOC)) {
                        
            $comment = (new Comment())
                ->setId($row['id'])
                ->setBookId($row['books_id'])
                ->setEmail($row['email'])
                ->setComment($row['comment'])  
                ->setActive($row['active'])              
            ;
            
            
            $comments[] = $comment;
        }

        return $comments;
    }

    public function find($id)
    {
        $sth = $this->pdo->prepare('select * from comment where id = :id');
        $sth->execute(compact('id'));
        $data = $sth->fetch(\PDO::FETCH_ASSOC);
        
        if (!$data) {
            throw new \Exception('not found');
        }
        
        return (new Comment())
            ->setId($data['id'])
            ->setComment($data['comment'])
            ->setActive($data['active'])
            ;
    }

    public function saveComment(Comment $comment)
    {
        // if id === null - insert, else - update where id = 4324
        $sql = " UPDATE comment SET comment = :comment, active = :active WHERE id = :id";
        $sth = $this->pdo->prepare($sql);
        $sth->execute(array(
            'id' => $comment->getId(),
            'comment' => $comment->getComment(),
            'active' => $comment->getActive()
            
            ));
    }

     public function removeById($id)
     {
         $this->pdo->query("DELETE FROM comment WHERE id = {$id}");
     }

     public function findNotActive()
    {
        $sth = $this->pdo->query('select * from comment where active=0');
        $comments = [];
        
        while ($row = $sth->fetch(\PDO::FETCH_ASSOC)) {
                        
            $comment = (new Comment())
                ->setId($row['id'])
                ->setBookId($row['books_id'])
                ->setEmail($row['email'])
                ->setComment($row['comment'])  
                ->setActive($row['active'])              
            ;
            
            
            $comments[] = $comment;
        }

        return $comments;
    }
}