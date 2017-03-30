<?php

namespace Model\Form;

use Library\Request;

class RegisterForm
{
    
    public $email;
    public $password;
    
    public function __construct(Request $request)
    {
        $this->password = $request->post('password');
        $this->email = $request->post('email');
        
    }
    
    public function isValid()
    {
       return $this->password != '' && $this->email != '' && $this->password === $this->password;
    }
    
    
}