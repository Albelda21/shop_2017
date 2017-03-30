<?php

namespace Model\Repository;

use Model\User;
use Library\EntityRepository;

class UserRepository extends EntityRepository
{
    public function find($email, $password)
    {
        $sth = $this->pdo->prepare('select * from user where email = :email and password = :password');
        $sth->execute(compact('email', 'password'));
        $user = $sth->fetch(\PDO::FETCH_ASSOC);
        
        if ($user) {
            $user = (new User())->setEmail($user['email'])->setId($user['id']);
        }
        
        return $user;
    }

    public function save($object, $table = null)
    {
        $sql = 'insert into user(email, password) values(:email, :password)';
        $sth = $this->pdo->prepare($sql);
        $user = $sth->fetch(\PDO::FETCH_ASSOC);
        var_dump($user);
        $sth->execute(array(
            'email' => $object->getEmail(),
            'password' => $object->getPassword()
            ));
    }

    public function findByEmail($email)
    {
        $sth = $this->pdo->prepare('select * from user where email = :email');
        $sth->execute(compact('email'));
        $user = $sth->fetch(\PDO::FETCH_ASSOC);
        
        if ($user) {
            $user = (new User())->setEmail($user['email'])->setId($user['id']);
        }
        
        return $user;
    }
}

