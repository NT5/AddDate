<?php

namespace AddDate;

/**
 * 
 */
class Twig {

    /**
     *
     * @var string 
     */
    private $Template_File;

    /**
     *
     * @var string 
     */
    private $Twig_Template_Folder;

    /**
     *
     * @var array 
     */
    private $Twig_Vars;

    /**
     *
     * @var \Twig_Loader_Filesystem 
     */
    private $Twig_Loader_Filesystem;

    /**
     *
     * @var \Twig_Environment 
     */
    private $Twig_Environment;

    /**
     * 
     */
    public function __construct() {
        $this->Twig_Template_Folder = \AddDate\Util\Functions::parseDir(array(__DIR__, "..", "..", "twig"));
        $this->Template_File = "base.twig";
        $this->Twig_Vars = [];

        $this->Twig_Loader_Filesystem = new \Twig_Loader_Filesystem($this->Twig_Template_Folder);
        $this->Twig_Environment = new \Twig_Environment($this->Twig_Loader_Filesystem, array(
            'cache' => \AddDate\Util\Functions::parseDir(array(__DIR__, "..", "..", "..", 'compilation_cache')),
            'output_encoding' => 'UTF-8',
            'auto_reload' => true
        ));

        $this->Twig_Environment->addExtension(new \Twig_Extensions_Extension_Intl());
    }

    /**
     * 
     * @param string $template
     */
    public function setTemplate($template) {
        $this->Template_File = $template;
    }

    /**
     * 
     * @return string
     */
    public function getTemplate() {
        return $this->Template_File;
    }

    /**
     * 
     * @param string $filter_name
     * @param string $filter_function
     */
    public function addFilter($filter_name, $filter_function) {
        $this->Twig_Environment->addFilter($filter_name, new \Twig_Filter_Function($filter_function));
    }

    /**
     * 
     * @param string $name
     * @param string $value
     */
    public function setVar($name, $value) {
        $this->Twig_Vars[$name] = $value;
    }

    /**
     * 
     * @param array $vars
     */
    public function setVars($vars) {
        foreach ($vars as $k => $v) {
            $this->Twig_Vars[$k] = $v;
        }
    }

    /**
     * 
     * @return array
     */
    public function getVars() {
        return $this->Twig_Vars;
    }

    /**
     * 
     * @param string $var
     */
    public function getVar($var) {
        if (array_key_exists($var, $this->getVars())) {
            return $this->Twig_Vars[$var];
        }
        return "";
    }

    /**
     * 
     * @return string
     */
    public function getRender() {
        return $this->Twig_Environment->render($this->Template_File, $this->Twig_Vars);
    }

}
