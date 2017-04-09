<?php

namespace Library;

abstract class Controller
{
    protected $container;
    
    private static $layout = 'default_layout.phtml';
    
    public function setContainer(Container $container)
    {
        $this->container = $container;
        
        return $this;
    }
    
    public static function setAdminLayout()
    {
        self::$layout = 'admin_layout.phtml';
    }
    
    protected function render($view, array $args = array())
    {
        extract($args);
        $classname = str_replace(['Controller', '\\'], ['', DS], get_class($this));
        $classname = trim($classname, DS);
        $file = VIEW_DIR . $classname . DS . $view;
        if (!file_exists($file)) {
            throw new \Exception("Template {$file} not found");
        }
        ob_start();
        require VIEW_DIR . $classname . DS . $view;
        $content = ob_get_clean();
        
        ob_start();
        require VIEW_DIR . self::$layout;
        return ob_get_clean();
    }
    
    public static function renderError($message, $code)
    {
        ob_start();
        require VIEW_DIR . 'error.phtml';
        $content = ob_get_clean();
        
        ob_start();
        require VIEW_DIR . self::$layout;
        return ob_get_clean();
    }
    
    
    public function getCartCount()
    {
        // $cartService = $this->container->get('cart_service');
        // return $cartService->count();
       return count($_COOKIE);
    }
    
    public function getTitle()
    {
        return $this->container->get('meta_helper')->getTitle();
    }
}