<?php

namespace MVC;

use \MVC\errors\RuntimeException;

/**
 * Description of View
 * 
 * @author Ramón Serrano <ramon.calle.88@gmail.com>
 * @package MVC
 */
class View {

    /**
     * App root
     * @var string $root 
     */
    public $root;
    /**
     * Path folder templates
     * @var string $templates_path
     */
    public $templates_path;

    /**
     *  Display the content of template
     *
     *  @param string $file    The file to be rendered.
     *  @param mixed $vars     The variables to be substituted in the view.
     *  @access public
     *  @return void
     */
    public function display($file, $vars = null) {
        echo $this->render($file, $vars);
    }

    /**
     *  Escapes a value for output in an HTML context.
     *
     *  @param mixed $value
     *  @access public
     *  @return mixed
     */
    public function escape($value) {
        return nl2br(htmlspecialchars($value, ENT_QUOTES, "UTF-8"));
    }

    /**
     *  Renders a given file with the supplied variables.
     *
     *  @param string $file    The file to be rendered.
     *  @param mixed $vars     The variables to be substituted in the view.
     *  @access public
     *  @return string
     */
    public function render($file, $vars = null) {
        $__template__ = "$this->root/$this->templates_path/{$file}";
        
        if(!file_exists($__template__)){
           RuntimeException::run("View '$__template__' don´t exists.");
        }
        
        if (is_array($vars)) {
            extract($vars);
            foreach ($vars as $key => $value) {
                $key = $value;
            }
        }        
        
        ob_start();
        require $__template__;
        return ob_get_clean();
    }

}            
        