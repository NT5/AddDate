<?php

namespace AddDate\Factory;

/**
 * 
 */
class AddDateComponents extends \AddDate\Factory\ExtendedComponents {

    /**
     *
     * @var \AddDate\Calendars 
     */
    private $Calendars;

    /**
     * @var \AddDate\Careers
     */
    private $Careers;

    /**
     * @var \AddDate\Lessons
     */
    private $Lessons;

    /**
     *
     * @var \AddDate\Users
     */
    private $Users;

    /**
     * @param \AddDate\Calendars $Calendars
     * @param \AddDate\Careers $Careers
     * @param \AddDate\Lessons $Lessons
     * @param \AddDate\Users $Users
     * @param \AddDate\Factory\ExtendedComponents $ExtendedComponents
     */
    public function __construct(\AddDate\Calendars $Calendars = NULL, \AddDate\Careers $Careers = NULL, \AddDate\Lessons $Lessons = NULL, \AddDate\Users $Users = NULL, \AddDate\Factory\ExtendedComponents $ExtendedComponents = NULL) {
        if (!$ExtendedComponents) {
            $ExtendedComponents = new \AddDate\Factory\ExtendedComponents();
        }
        parent::__construct($ExtendedComponents->getDatabase(), $ExtendedComponents->getPageConfig(), $ExtendedComponents->getCookies(), $ExtendedComponents);

        $this->Users = ($Users) ? : new \AddDate\Users($this);
        $this->Lessons = ($Lessons) ? : new \AddDate\Lessons($this, $this->getUsers());
        $this->Careers = ($Careers) ? : new \AddDate\Careers($this, $this->getUsers());
        $this->Calendars = ($Calendars) ? : new \AddDate\Calendars($this, $this->getUsers(), $this->getCareers(), $this->getLessons());
    }

    /**
     * 
     * @return \AddDate\Users
     */
    public function getUsers() {
        return $this->Users;
    }

    /**
     * 
     * @return \AddDate\Lessons
     */
    public function getLessons() {
        return $this->Lessons;
    }

    /**
     * 
     * @return \AddDate\Careers
     */
    public function getCareers() {
        return $this->Careers;
    }

    /**
     * 
     * @return \AddDate\Calendars
     */
    public function getCalendars() {
        return $this->Calendars;
    }

}
