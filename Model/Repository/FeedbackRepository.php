<?php

namespace Model\Repository;

use Library\EntityRepository;

class FeedbackRepository extends EntityRepository
{
    public function save($object, $table = null)
    {
        $class = explode('\\', get_class($object)); // Model\Feedback
        $class = end($class);
        $table = strtolower($class);
        
        $sql = 'insert into feedback (name, email, message, ip_address) values (:name, :email, :message, :ip_address)';
        $sth = $this->pdo->prepare($sql);
        $sth->execute(array(
            'name' => $object->getName(),
            'email' => $object->getEmail(),
            'message' => $object->getMessage(),
            'ip_address' => $object->getIpAddress()
        ));
    }
}