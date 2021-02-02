<?php

namespace AddDate\Pages;

/**
 * 
 */
class About extends \AddDate\Pages\Page {

    /**
     *
     * @var int 
     */
    protected $Area;

    /**
     * 
     * @param \AddDate\Factory\AddDateComponents $AddDateComponents
     */
    public function __construct(\AddDate\Factory\AddDateComponents $AddDateComponents = NULL) {
        parent::__construct($AddDateComponents);

        $this->Area = filter_input(INPUT_GET, 's');
        switch ($this->Area) {
            case 'faq':
                $this->setTemplate('pages/about/faq.twig');
                $this->setVar("page_title", " - FAQ's");
                break;
            default:
                $this->setTemplate('pages/about/about.twig');
                $this->setVar("page_title", " - Acerca de");
                break;
        }
    }

}
