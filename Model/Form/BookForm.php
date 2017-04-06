<?php

namespace Model\Form;

use Library\Request;

class BookForm
{
    public $id;
    public $title;
    public $description;
    public $price;
    public $sale;
    public $style;
    
    
    public function __construct(Request $request)
    {
        $this->id = $request->post('id');
        $this->title = $request->post('title');
        $this->description = $request->post('description');
        $this->price = $request->post('price');
        $this->sale = $request->post('sale');
        $this->style = $request->post('style');
    }
    
    /**
     * @return bool
     */
    function isValid()
    {
        $res = $this->id !== '' && $this->title !== '' && $this->description !== ''; 
        return $res;
    }
}