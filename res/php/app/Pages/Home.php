<?php

namespace AddDate\Pages;

/**
 * 
 */
class Home extends \AddDate\Pages\Page {

    /**
     * 
     * @param \AddDate\Factory\AddDateComponents $AddDateComponents
     */
    public function __construct(\AddDate\Factory\AddDateComponents $AddDateComponents = NULL) {
        parent::__construct($AddDateComponents);

        if (filter_input(INPUT_GET, 'c')) {
            $this->setTemplate("pages/home/calendar.twig");
            $this->setVar('calendar_data', $this->getCalendars()->getCalendar(filter_input(INPUT_GET, 'c')));
        } else {
            $this->setTemplate("pages/home/home.twig");
            $this->setVar('page_title', ' - Inicio');
            if (filter_input(INPUT_GET, 's')) {
                $calendar_list = $this->getCalendars()->getCalendarsFromCareer(filter_input(INPUT_GET, 's'));
                if (count($calendar_list) <= 0) {
                    $calendar_list = $this->getCalendars()->getCalendars();
                }
            } else {
                $calendar_list = $this->getCalendars()->getCalendars();
            }

            $this->setVars([
                'careers_list' => $this->getCareers()->getCareers(),
                'calendars_list' => $calendar_list
            ]);
        }
    }

}
