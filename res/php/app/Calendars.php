<?php

namespace AddDate;

/**
 * 
 */
class Calendars extends \AddDate\Factory\ExtendedComponents {

    /**
     *
     * @var \AddDate\Users 
     */
    private $UsersClass;

    /**
     *
     * @var \AddDate\Careers 
     */
    private $CareersClass;

    /**
     *
     * @var \AddDate\Lessons
     */
    private $LessonsClass;

    /**
     * 
     * @param \AddDate\Factory\ExtendedComponents $ExtendedComponents
     * @param \AddDate\Users $Users
     * @param \AddDate\Careers $Careers
     * @param \AddDate\Lessons $Lessons
     */
    public function __construct(\AddDate\Factory\ExtendedComponents $ExtendedComponents = NULL, \AddDate\Users $Users = NULL, \AddDate\Careers $Careers = NULL, \AddDate\Lessons $Lessons = NULL) {
        if (!$ExtendedComponents) {
            $ExtendedComponents = new \AddDate\Factory\ExtendedComponents();
        }
        parent::__construct($ExtendedComponents->getDatabase(), $ExtendedComponents->getPageConfig(), $ExtendedComponents->getCookies(), $ExtendedComponents);

        $this->UsersClass = ($Users) ? : new \AddDate\Users($this);
        $this->CareersClass = ($Careers) ? : new \AddDate\Careers($this, $this->getUsersClass());
        $this->LessonsClass = ($Lessons) ? : new \AddDate\Lessons($this, $this->getUsersClass());

        $this->setLog(\AddDate\Util\Logger\Areas::CALENDARS, "Nueva instancia de calendarios creada");
    }

    /**
     * 
     * @return \AddDate\Users
     */
    public function getUsersClass() {
        return $this->UsersClass;
    }

    /**
     * 
     * @return \AddDate\Careers
     */
    public function getCareersClass() {
        return $this->CareersClass;
    }

    /**
     * 
     * @return \AddDate\Lessons
     */
    public function getLessonsClass() {
        return $this->LessonsClass;
    }

    /**
     * 
     * @param int $Career_Id
     */
    public function getCalendarsFromCareer($Career_Id) {
        $calendar_id = NULL;
        $calendars = [];

        $stmt = $this->getDatabase()->prepare("SELECT Calendar_Id FROM Calendar WHERE Career_Id = ?");

        $stmt->bind_param('i', $Career_Id);
        $stmt->execute();
        $stmt->bind_result($calendar_id);
        $stmt->store_result();

        while ($stmt->fetch()) {
            $calendars[] = $this->getCalendar($calendar_id);
        }
        $stmt->free_result();
        $stmt->close();

        return $calendars;
    }

    /**
     * 
     * @param string $Observations
     * @return array
     */
    public function getCalendarsFromObservations($Observations) {
        $calendar_id = NULL;
        $calendars = [];

        $stmt = $this->getDatabase()->prepare("SELECT Calendar_Id FROM Calendar WHERE Observations LIKE ?");

        $stmt->bind_param('s', $Observations);
        $stmt->execute();
        $stmt->bind_result($calendar_id);
        $stmt->store_result();

        while ($stmt->fetch()) {
            $calendars[] = $this->getCalendar($calendar_id);
        }

        $stmt->free_result();
        $stmt->close();

        return $calendars;
    }

    /**
     * @return array
     */
    public function getCalendars() {
        $calendar_id = NULL;
        $calendars = [];

        $stmt = $this->getDatabase()->prepare("SELECT Calendar_Id FROM Calendar");

        $stmt->execute();
        $stmt->bind_result($calendar_id);
        $stmt->store_result();

        while ($stmt->fetch()) {
            $calendars[] = $this->getCalendar($calendar_id);
        }

        $stmt->free_result();
        $stmt->close();

        return $calendars;
    }

    /**
     * 
     * @param int $id
     * @return \AddDate\Calendars\Calendar
     */
    public function getCalendar($id) {
        $Calendar_Id = NULL;
        $Create_by = NULL;
        $Career_Id = NULL;
        $Create_at = NULL;
        $Observations = NULL;

        $stmt = $this->getDatabase()->prepare("SELECT Calendar_Id, Create_by, Career_Id, Create_at, Observations FROM Calendar WHERE Calendar_Id = ?");

        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->bind_result($Calendar_Id, $Create_by, $Career_Id, $Create_at, $Observations);
        $stmt->store_result();
        $stmt->fetch();
        $stmt->free_result();
        $stmt->close();

        if ($Calendar_Id !== NULL && $Create_by !== NULL && $Career_Id !== NULL && $Create_at !== NULL && $Observations !== NULL) {
            $Calendar_Data = $this->getCalendarData($Calendar_Id);
            $Career = $this->getCareersClass()->getCareer($Career_Id);
            $User = $this->getUsersClass()->getUser($Create_by);

            return new \AddDate\Calendars\Calendar($Calendar_Id, $User, $Career, $Create_at, $Observations, $Calendar_Data);
        }
        return NULL;
    }

    /**
     * 
     * @param int $id
     * @return array
     */
    public function getCalendarData($id) {
        $Calendar_Data = [];

        $Calendar_Id = NULL;
        $Lesson_Id = NULL;
        $Block_Id = NULL;
        $Do_Date = NULL;
        $Reprogramming_Date = NULL;
        $Special_Date = NULL;
        $Create_at = NULL;

        $stmt = $this->getDatabase()->prepare("SELECT Calendar_Id, Lesson_Id, Block_Id, Do_Date, Reprogramming_Date, Special_Date, Create_at FROM Calendar_Data WHERE Calendar_Id = ?");

        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->bind_result($Calendar_Id, $Lesson_Id, $Block_Id, $Do_Date, $Reprogramming_Date, $Special_Date, $Create_at);
        $stmt->store_result();

        while ($stmt->fetch()) {
            $Lesson = $this->getLessonsClass()->getLesson($Lesson_Id);
            $Calendar_Data[] = new \AddDate\Calendars\CalendarData($Calendar_Id, $Lesson, $Block_Id, $Do_Date, $Reprogramming_Date, $Special_Date, $Create_at);
        }

        $stmt->free_result();
        $stmt->close();

        return $Calendar_Data;
    }

    /**
     * 
     * @param \AddDate\Users\User $Create_by
     * @param int $Career_Id
     * @param string $Observations
     * @param array $Calendar_Data
     */
    public function insertCalendar(\AddDate\Users\User $Create_by, $Career_Id, $Observations, $Calendar_Data) {
        $stmt = $this->getDatabase()->prepare("INSERT INTO Calendar (Create_by, Career_Id, Observations) VALUES (?, ?, ?)");

        $stmt->bind_param('iis', $Create_by->getId(), $Career_Id, $Observations);
        $stmt->execute();
        $stmt->close();

        $calendar_id = $this->getDatabase()->getLastId();

        foreach ($Calendar_Data as $data) {
            $this->insertCalendarData($calendar_id, $data["lesson_id"], $data["block_id"], $data["do_date"], $data["reprogramming_date"], $data["special_date"]);
        }
    }

    /**
     * 
     * @param int $calendar_id
     * @param int $lesson_id
     * @param int $block_id
     * @param string $do_date
     * @param string $reprogramming_date
     * @param string $special_date
     */
    private function insertCalendarData($calendar_id, $lesson_id, $block_id, $do_date, $reprogramming_date, $special_date) {
        $stmt = $this->getDatabase()->prepare("INSERT INTO Calendar_Data (Calendar_Id, Lesson_Id, Block_Id, Do_Date, Reprogramming_Date, Special_Date) VALUES (?, ?, ?, ?, ?, ?)");

        $stmt->bind_param('iiisss', $calendar_id, $lesson_id, $block_id, $do_date, $reprogramming_date, $special_date);
        $stmt->execute();
        $stmt->close();
    }

    /**
     * 
     * @param int $id
     */
    public function deleteCalendar($id) {
        $stmt = $this->getDatabase()->prepare("DELETE FROM Calendar WHERE Calendar_Id = ?");

        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();
    }

}
