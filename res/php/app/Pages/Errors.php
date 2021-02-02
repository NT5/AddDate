<?php

namespace AddDate\Pages;

/**
 * 
 */
class Errors extends \AddDate\Pages\Page {

    /**
     * 
     * @param \AddDate\Factory\AddDateComponents $AddDateComponents
     * @param int $error_code
     */
    public function __construct(\AddDate\Factory\AddDateComponents $AddDateComponents = NULL, $error_code = 0) {
        parent::__construct($AddDateComponents);

        $this->setTemplate("pages/errors/error.twig");
        $this->setVars([
            "page_title" => " - Error Critico",
            "error_code" => $error_code
        ]);
    }

}
