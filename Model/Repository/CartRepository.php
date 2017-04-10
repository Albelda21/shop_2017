<?php

namespace Model\Repository;

use Library\EntityRepository;

class CartRepository extends EntityRepository
{
    public function save($object, $table = null)
    {
        $class = explode('\\', get_class($object)); // Model\Feedback
        $class = end($class);
        $table = strtolower($class);
        
        $sql = 'insert into ordder (name, surname, email, phone) values (:name, :surname, :email, :phone)';
        $sth = $this->pdo->prepare($sql);
        $sth->execute(array(
            'name' => $object->getName(),
            'surname' => $object->getSurname(),
            'email' => $object->getEmail(),
            'phone' => $object->getPhone()
        ));
    }
}