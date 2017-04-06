<?php

namespace Model\Form;

use Library\Request;

class CommentForm
{
    public $email;
    public $comment;
    public $good;
    
    
   
    public function __construct(Request $request)
    {
        $this->comment = $request->post('comment');
        $this->email = $request->post('email');
        $this->good = $request->post('good');
        
    }
    
   
    function isValid()
    {
        $res = $this->comment !== '' && $this->email !== ''; 
        return $res;
    }
}