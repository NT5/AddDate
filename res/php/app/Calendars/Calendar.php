<?php

namespace AddDate\Calendars;

/**
 * 
 */
class Calendar {

    /**
     *
     * @var int 
     */
    private $Id;

    /**
     *
     * @var \AddDate\Users\User 
     */
    private $Create_by;

    /**
     *
     * @var \AddDate\Careers\Career 
     */
    private $Career;

    /**
     *
     * @var string 
     */
    private $Create_at;

    /**
     *
     * @var string 
     */
    private $Observations;

    /**
     *
     * @var array
     */
    private $Calendar_Data;

    /**
     * 
     * @param int $id
     * @param \AddDate\Users\User $Create_by
     * @param \AddDate\Careers\Career $Career
     * @param string $Create_at
     * @param string $Observations
     * @param array $Calendar_Data
     */
    public function __construct($id = 0, \AddDate\Users\User $Create_by = NULL, \AddDate\Careers\Career $Career = NULL, $Create_at = 0, $Observations = "None", $Calendar_Data = []) {
        $this->Id = $id;
        $this->Create_by = $Create_by;
        $this->Career = $Career;
        $this->Create_at = $Create_at;
        $this->Observations = $Observations;
        $this->Calendar_Data = $Calendar_Data;
    }

    /**
     * 
     * @return int
     */
    public function getId() {
        return $this->Id;
    }

    /**
     * 
     * @return \AddDate\Users\User
     */
    public function getCreateBy() {
        return $this->Create_by;
    }

    /**
     * 
     * @return string
     */
    public function getCreateAt() {
        return $this->Create_at;
    }

    /**
     * 
     * @return \AddDate\Careers\Career
     */
    public function getCareer() {
        return $this->Career;
    }

    /**
     * 
     * @return string
     */
    public function getObservations() {
        return $this->Observations;
    }

    /**
     * 
     * @return array
     */
    public function getCalendarData() {
        return $this->Calendar_Data;
    }

}
