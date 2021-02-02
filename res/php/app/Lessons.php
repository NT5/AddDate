<?php

namespace AddDate;

/**
 * 
 */
class Lessons extends \AddDate\Factory\ExtendedComponents {

    /**
     *
     * @var \AddDate\Users 
     */
    private $UsersClass;

    /**
     * @param \AddDate\Factory\ExtendedComponents $ExtendedComponents
     * @param \AddDate\Users $Users
     */
    public function __construct(\AddDate\Factory\ExtendedComponents $ExtendedComponents = NULL, \AddDate\Users $Users = NULL) {
        if (!$ExtendedComponents) {
            $ExtendedComponents = new \AddDate\Factory\ExtendedComponents();
        }
        parent::__construct($ExtendedComponents->getDatabase(), $ExtendedComponents->getPageConfig(), $ExtendedComponents->getCookies(), $ExtendedComponents);

        $this->UsersClass = ($Users) ? : new \AddDate\Users($this);

        $this->setLog(\AddDate\Util\Logger\Areas::LESSONS, "Nueva instancia de clases creada");
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
     * @param int $id
     * @return \AddDate\Lessons\Lesson
     */
    public function getLesson($id) {
        $lesson_id = NULL;
        $lesson_name = NULL;
        $create_by = NULL;
        $create_at = NULL;

        $stmt = $this->getDatabase()->prepare("SELECT Lesson_Id, Lesson_Name, Create_by, Create_at FROM Lessons WHERE Lesson_Id = ?");

        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->bind_result($lesson_id, $lesson_name, $create_by, $create_at);
        $stmt->store_result();
        $stmt->fetch();
        $stmt->free_result();
        $stmt->close();

        if ($lesson_id !== NULL && $lesson_name !== NULL && $create_by !== NULL && $create_at !== NULL) {
            $user = $this->getUsersClass()->getUser($create_by);
            if ($user === NULL) {
                $user = new \AddDate\Users\User();
            }

            return new \AddDate\Lessons\Lesson($lesson_id, $lesson_name, $create_at, $user);
        }

        return NULL;
    }

    /**
     * @return array
     */
    public function getLessons() {
        $lesson_id = NULL;
        $lessons = [];

        $stmt = $this->getDatabase()->prepare("SELECT Lesson_Id FROM Lessons");

        $stmt->execute();
        $stmt->bind_result($lesson_id);
        $stmt->store_result();

        while ($stmt->fetch()) {
            $lessons[] = $this->getLesson($lesson_id);
        }

        $stmt->free_result();
        $stmt->close();

        return $lessons;
    }

    /**
     * 
     * @param string $name
     * @param \AddDate\Users\User $create_by
     */
    public function insertLesson($name, \AddDate\Users\User $create_by) {
        $stmt = $this->getDatabase()->prepare("INSERT INTO Lessons (Lesson_Name, Create_by) VALUES (?, ?)");

        $stmt->bind_param('si', $name, $create_by->getId());
        $stmt->execute();
        $stmt->close();
    }

    /**
     * 
     * @param int $id
     */
    public function deleteLesson($id) {
        $stmt = $this->getDatabase()->prepare("DELETE FROM Lessons WHERE Lesson_Id = ?");

        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();
    }

}
