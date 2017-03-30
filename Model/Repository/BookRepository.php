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
            ;
    }
    
    public function save(Book $book)
    {
        // if id === null - insert, else - update where id = 4324
        $sql = " UPDATE books SET title = :title, description = :description, price = :price, sale = :sale   WHERE id = :id";
        $sth = $this->pdo->prepare($sql);
        $sth->execute(array(
            'id' => $book->getId(),
            'title' => $book->getTitle(),
            'description' => $book->getDescription(),
            'price' => $book->getPrice(),
            'sale' => $book->getSale()
            ));
    }

    public function removeById()
    {
        echo 'Yes we did it!';
    }
}

