<?php

namespace Library;

use Exception\ParameterNotFoundException;

class Config
{
    public function __construct()
    {
        // todo: for all xml files in conf dir - private function(file)
        $file = CONFIG_DIR . 'db.xml';
        $xmlObject = simplexml_load_file($file, 'SimpleXMLElement', LIBXML_NOWARNING);
        
        if (!$xmlObject) {
            throw new \Exception('Config file not found');
        }
        
        foreach ($xmlObject as  $key => $value) {
            $this->$key = (string)$value;
        }
    }
    
    public function __get($name)
    {
        throw new ParameterNotFoundException();
    }
}
