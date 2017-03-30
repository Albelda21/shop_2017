<?php

namespace Library;

class MetaHelper
{
    private $title;
    private $description;
    
    public function __construct(Config $config)
    {
        // $this->title = $config->defaultTitle;
        $this->title = 'Some default title';
    }
    
    public function getTitle()
    {
        return $this->title;
    }
    
    public function setTitle($title)
    {
        $this->title = $title;
    }
    
    public function addToTitle($string)
    {
        $this->title .= " | {$string}";
    }
}