<?php

namespace AddDate;

/**
 * 
 */
class Careers extends \AddDate\Factory\ExtendedComponents {

    /**
     *
     * @var \AddDate\Users 
     */
    private $UsersClass;

    /**
     * 
     * @param \AddDate\Factory\ExtendedComponents $ExtendedComponents
     * @param \AddDate\Users $Users
     */
    public function __construct(\AddDate\Factory\ExtendedComponents $ExtendedComponents = NULL, \AddDate\Users $Users = NULL) {
        if (!$ExtendedComponents) {
            $ExtendedComponents = new \AddDate\Factory\ExtendedComponents();
        }
        parent::__construct($ExtendedComponents->getDatabase(), $ExtendedComponents->getPageConfig(), $ExtendedComponents->getCookies(), $ExtendedComponents);

        $this->UsersClass = ($Users) ? : new \AddDate\Users($this);

        $this->setLog(\AddDate\Util\Logger\Areas::CAREERS, "Nueva instancia de carreras creada");
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
     * @return \AddDate\Careers\Career
     */
    public function getCareer($id) {
        $career_id = NULL;
        $career_name = NULL;
        $create_by = NULL;
        $create_at = NULL;

        $stmt = $this->getDatabase()->prepare("SELECT Career_Id, Career_Name, Create_by, Create_at FROM Careers WHERE Career_Id = ?");

        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->bind_result($career_id, $career_name, $create_by, $create_at);
        $stmt->store_result();
        $stmt->fetch();
        $stmt->free_result();
        $stmt->close();

        if ($career_id !== NULL && $career_name !== NULL && $create_by !== NULL && $create_at !== NULL) {
            $user = $this->getUsersClass()->getUser($create_by);
            if ($user === NULL) {
                $user = new \AddDate\Users\User();
            }
            return new \AddDate\Careers\Career($career_id, $career_name, $create_at, $user);
        }

        return NULL;
    }

    /**
     * @return array
     */
    public function getCareers() {
        $career_id = NULL;
        $careers = [];

        $stmt = $this->getDatabase()->prepare("SELECT Career_Id FROM Careers");

        $stmt->execute();
        $stmt->bind_result($career_id);
        $stmt->store_result();

        while ($stmt->fetch()) {
            $careers[] = $this->getCareer($career_id);
        }

        $stmt->free_result();
        $stmt->close();

        return $careers;
    }

    /**
     * 
     * @param string $name
     * @param \AddDate\Users\User $create_by
     */
    public function insertCareer($name, \AddDate\Users\User $create_by) {
        $stmt = $this->getDatabase()->prepare("INSERT INTO Careers (Career_Name, Create_by) VALUES (?, ?)");

        $stmt->bind_param('si', $name, $create_by->getId());
        $stmt->execute();
        $stmt->close();
    }

    /**
     * 
     * @param int $id
     */
    public function deleteCareer($id) {
        $stmt = $this->getDatabase()->prepare("DELETE FROM Careers WHERE Career_Id = ?");

        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();
    }

}
