<?php

namespace Model\Form;

use Library\Request;

class OrderForm
{
    public $name;
    public $surname;
    public $email;
    public $phone;
    
    /**
     * ContactForm constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->name = $request->post('name');
        $this->surname = $request->post('surname');
        $this->email = $request->post('email');
        $this->phone = $request->post('phone');
    }
    
    /**
     * @return bool
     */
    function isValid()
    {
        $res = $this->name !== '' && $this->email !== '' && $this->surname !== '' && $this->phone !== '';
        return $res;
    }
}

