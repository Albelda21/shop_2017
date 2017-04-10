<?php

namespace Model\Repository;

use Model\Book;
use Library\EntityRepository;
use Library\Session;

class BookRepository extends EntityRepository
{

    public function findNumb($style, $limit)
    {
        $sth = $this->pdo->query("Select * from books where style_id = $style ORDER BY created limit $limit");
        while ($row = $sth->fetch(\PDO::FETCH_ASSOC)) {
            $book = (new Book())
                ->setId($row['id'])
                ->setTitle($row['title'])
                ->setDescription($row['description'])
                ->setPrice($row['price'])
                ->setSale($row['sale'])
                ;
            $books[] = $book;
        }
        return $books;
    }

    public function findByIdArray(array $ids)
    {
        if (!$ids) {
            return [];
        }
        
        $params = [];
        
        foreach ($ids as $id) {
           $params[] = '?'; 
        }
        
        $params = implode(',', $params);
        $sth = $this->pdo->prepare("SELECT * FROM books WHERE id IN ({$params})"); // in (?,?,?,?)
        $sth->execute($ids);
        $books = [];
        
        while ($row = $sth->fetch(\PDO::FETCH_ASSOC)) {
            // new Style()
            
            $book = (new Book())
                ->setId($row['id'])
                ->setTitle($row['title'])
                ->setDescription($row['description'])
                ->setPrice($row['price'])                
                ->setStyle($row['style_id'])
                ->setSale($row['sale'])
            ;
            
            $books[] = $book;
        }

        return $books;
    }
    
    
    public function findActiveByPage($page, $perPage, $type)
    {
        $offset = ($page - 1) * $perPage;
        $sql = "SELECT * FROM books WHERE style_id = {$type} ORDER BY id LIMIT {$offset}, {$perPage}";
        $sth = $this->pdo->query($sql);
        
        $books = [];
        
        while ($row = $sth->fetch(\PDO::FETCH_ASSOC)) {
            
            $book = (new Book())
                ->setId($row['id'])
                ->setTitle($row['title'])
                ->setDescription($row['description'])
                ->setPrice($row['price'])                
                ->setStyle($row['style_id'])
            ;
            
            $books[] = $book;
        }

        return $books;
    }
    
    public function count($type, $active = true )
    {
        $sql = "SELECT count(*) FROM books where style_id = {$type}";        
        $sth = $this->pdo->query($sql);
        return (int)$sth->fetchColumn();
    }
    
    
    public function findAll()
    {
        $sth = $this->pdo->query('select * from books');
        $books = [];
        
        while ($row = $sth->fetch(\PDO::FETCH_ASSOC)) {
                        
            $book = (new Book())
                ->setId($row['id'])
                ->setTitle($row['title'])
                ->setDescription($row['description'])
                ->setPrice($row['price'])                
                ->setSale($row['sale'])
                ->setStyle($row['style_id'])
            ;
            
            
            $books[] = $book;
        }

        return $books;
    }
    
    public function find($id)
    {
        $sth = $this->pdo->prepare('select * from books where id = :id');
        $sth->execute(compact('id'));
        $data = $sth->fetch(\PDO::FETCH_ASSOC);
        
        if (!$data) {
            throw new \Exception('not found');
        }
        
        return (new Book())
            ->setId($data['id'])
            ->setTitle($data['title'])
            ->setPrice($data['price'])            
            ->setDescription($data['description'])
            ->setSale($data['sale'])
            ->setStyle($data['style_id'])
            ;
    }
    
    public function save(Book $book)
    {
        // if id === null - insert, else - update where id = 4324
        $sql = " UPDATE books SET title = :title, description = :description, price = :price, sale = :sale, style_id = :style_id   WHERE id = :id";
        $sth = $this->pdo->prepare($sql);
        $sth->execute(array(
            'id' => $book->getId(),
            'title' => $book->getTitle(),
            'description' => $book->getDescription(),
            'price' => $book->getPrice(),
            'sale' => $book->getSale(),
            'style_id' => $book->getStyle()
            ));
    }

    public function topComments()
    {
        $sth = $this->pdo->query('SELECt title, books_id, COUNT(comment) FROM comment JOIN books On comment.books_id=books.id GROUP BY books_id ORDER BY sum(comment) desc limit 2');
        $topcomments = [];
        
        while ($row = $sth->fetch(\PDO::FETCH_ASSOC)) {
                        
            $top = (new Comment())
                ->setTitle((new Book)->getTitle)
                ->setBookId($row['books_id'])
                ->setComment($row['comment'])
               
            ;
            
            
            $topcomments[] = $top;
        }

        return $topcomments;

    }

    public function add($object, $table = null)
    {
        $class = explode('\\', get_class($object)); // Model\Feedback
        $class = end($class);
        $table = strtolower($class);
        
        $sql = 'insert into books (title, description, price, sale, style_id) values (:title, :description, :price, :sale, :style_id)';
        $sth = $this->pdo->prepare($sql);
        $sth->execute(array(
            'title' => $object->getTitle(),
            'description' => $object->getDescription(),
            'price' => $object->getPrice(),
            'sale' => $object->getSale(),
            'style_id' => $object->getStyle()
           
        ));
    }

     public function removeById($id){
         $this->pdo->query("DELETE FROM books WHERE id = {$id}");
     }


    // SELECt title, books_id, COUNT(comment) FROM comment JOIN books On comment.books_id=books.id GROUP BY books_id ORDER BY sum(comment) desc limit 2
}

