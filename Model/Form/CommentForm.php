<?php

namespace Model\Form;

use Library\Request;

class CommentForm
{
    public $email;
    public $comment;
    
   
    public function __construct(Request $request)
    {
        $this->comment = $request->post('comment');
        $this->email = $request->post('email');
    }
    
   
    function isValid()
    {
        $res = $this->comment !== '' && $this->email !== ''; 
        return $res;
    }
}