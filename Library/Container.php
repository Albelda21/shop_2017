<?php

namespace Library;

class Container 
{
    private $services = array();
    
    public function get($key)
    {
        // todo :exception if not found
        return isset($this->services[$key]) ? $this->services[$key] : null;
    }
    
    public function set($key, $object)
    {
        $this->services[$key] = $object;
    }
    
}