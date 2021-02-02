<?php

namespace AddDate\Pages;

/**
 * 
 */
abstract class Page extends \AddDate\Factory\AddDateComponents {

    /**
     *
     * @var \AddDate\Twig 
     */
    private $Twig;

    /**
     * 
     * @param \AddDate\Factory\AddDateComponents $AddDateComponents
     */
    public function __construct(\AddDate\Factory\AddDateComponents $AddDateComponents = NULL) {
        if (!$AddDateComponents) {
            $AddDateComponents = new \AddDate\Factory\AddDateComponents();
        }
        parent::__construct($AddDateComponents->getCalendars(), $AddDateComponents->getCareers(), $AddDateComponents->getLessons(), $AddDateComponents->getUsers(), $AddDateComponents);

        $this->Twig = new \AddDate\Twig();
    }

    /**
     * 
     * @param string $vars
     */
    public function setVars($vars) {
        $this->getTwig()->setVars($vars);
    }

    /**
     * 
     * @param string $name
     * @param string $value
     */
    public function setVar($name, $value) {
        $this->getTwig()->setVar($name, $value);
    }

    /**
     * 
     * @param string $template
     */
    public function setTemplate($template) {
        $this->getTwig()->setTemplate($template);
    }

    /**
     * 
     * @return string
     */
    public function display() {
        return $this->getTwig()->getRender();
    }

    /**
     * 
     * @return \AddDate\Twig
     */
    public function getTwig() {
        return $this->Twig;
    }

}
