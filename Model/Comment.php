<?php

namespace Model;

class Comment
{
	private $id;
	private $books_id;
	private $email;
	private $comment;
	private $created;
    private $active;

	 /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        
        return $this;
    }

     /**
     * @return mixed
     */
    public function getBookId()
    {
        return $this->books_id;
    }

    /**
     * @param mixed $id
     * @return $this
     */
    public function setBookId($books_id)
    {
        $this->books_id = $books_id;
        
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;
        
        return $this;
    }

     /**
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param mixed $id
     * @return $this
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
        
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param mixed $created
     * @return $this
     */
    public function setCreated($created)
    {
        $this->created = $created;
        
        return $this;
    }

     /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param mixed $id
     * @return $this
     */
    public function setActive($active)
    {
        $this->active = $active;
        
        return $this;
    }

}