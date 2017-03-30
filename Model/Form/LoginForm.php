<?php

namespace Model\Form;

use Library\Request;

class LoginForm
{
    public $email;
    public $password;
    
    /**
     * ContactForm constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->password = $request->post('password');
        $this->email = $request->post('email');
    }
    
    /**
     * @return bool
     */
    function isValid()
    {
        $res = $this->password !== '' && $this->email !== ''; 
        return $res;
    }
}

