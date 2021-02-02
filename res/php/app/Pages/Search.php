<?php

namespace AddDate\Pages;

/**
 * 
 */
class Search extends \AddDate\Pages\Page {

    /**
     * 
     * @param \AddDate\Factory\AddDateComponents $AddDateComponents
     */
    public function __construct(\AddDate\Factory\AddDateComponents $AddDateComponents = NULL) {
        parent::__construct($AddDateComponents);

        $this->setTemplate("pages/search/search.twig");
        $search_q = filter_input(INPUT_POST, 'search_q');

        $search_res = ( $search_q ? $this->getCalendars()->getCalendarsFromObservations("%$search_q%") : NULL);

        $this->setVars([
            "page_title" => " - Busqueda",
            "search_term" => $search_q,
            "search_res" => $search_res
        ]);
    }

}
