<?php

namespace AddDate\Calendars;

/**
 * 
 */
class CalendarData {

    /**
     *
     * @var type 
     */
    private $CalendarId;

    /**
     *
     * @var type 
     */
    private $Lesson;

    /**
     *
     * @var type 
     */
    private $Block_Id;

    /**
     *
     * @var type 
     */
    private $Do_Date;

    /**
     *
     * @var type 
     */
    private $Reprogramming_Date;

    /**
     *
     * @var type 
     */
    private $Special_Date;

    /**
     *
     * @var type 
     */
    private $Create_at;

    /**
     * 
     */
    public function __construct($CalendarId, $Lesson, $Block_Id, $Do_Date, $Reprogramming_Date, $Special_Date, $Create_at) {
        $this->CalendarId = $CalendarId;
        $this->Lesson = $Lesson;
        $this->Block_Id = $Block_Id;
        $this->Do_Date = $Do_Date;
        $this->Reprogramming_Date = $Reprogramming_Date;
        $this->Special_Date = $Special_Date;
        $this->Create_at = $Create_at;
    }

    /**
     * 
     * @return type
     */
    public function getCalendarId() {
        return $this->CalendarId;
    }

    /**
     * 
     * @return \AddDate\Lessons\Lesson
     */
    public function getLesson() {
        return $this->Lesson;
    }

    /**
     * 
     * @return type
     */
    public function getBlockId() {
        return $this->Block_Id;
    }

    /**
     * 
     * @return type
     */
    public function getDoDate() {
        return $this->Do_Date;
    }

    /**
     * 
     * @return type
     */
    public function getReprogrammingDate() {
        return $this->Reprogramming_Date;
    }

    /**
     * 
     * @return type
     */
    public function getSpecialDate() {
        return $this->Special_Date;
    }

    /**
     * 
     * @return type
     */
    public function getCreateAt() {
        return $this->Create_at;
    }

}
