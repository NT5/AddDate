<?php

namespace AddDate;

/**
 * 
 */
class Users extends \AddDate\Factory\ExtendedComponents {

    /**
     *
     * @var \AddDate\Users\Token
     */
    private $UserToken;

    /**
     *
     * @var \AddDate\Users\Sessions 
     */
    private $UserSession;

    /**
     * 
     * @param \AddDate\Factory\ExtendedComponents $ExtendedComponents
     * @param \AddDate\Users\Token $UserToken
     * @param \AddDate\Users\Sessions $UserSession
     */
    public function __construct(\AddDate\Factory\ExtendedComponents $ExtendedComponents = NULL, \AddDate\Users\Token $UserToken = NULL, \AddDate\Users\Sessions $UserSession = NULL) {
        if (!$ExtendedComponents) {
            $ExtendedComponents = new \AddDate\Factory\ExtendedComponents();
        }
        parent::__construct($ExtendedComponents->getDatabase(), $ExtendedComponents->getPageConfig(), $ExtendedComponents->getCookies(), $ExtendedComponents);

        $this->UserToken = ($UserToken) ? : new \AddDate\Users\Token($this, $ExtendedComponents);
        $this->UserSession = ($UserSession) ? : new \AddDate\Users\Sessions($this, $ExtendedComponents);

        $this->setLog(\AddDate\Util\Logger\Areas::USERS, "Nueva instancia de Usuarios creada");
    }

    /**
     * 
     * @return \AddDate\Users\Token
     */
    public function getUserTokenClass() {
        return $this->UserToken;
    }

    /**
     * 
     * @return \AddDate\Users\Sessions
     */
    public function getUserSessionClass() {
        return $this->UserSession;
    }

    /**
     * 
     * @param int $id
     * @return \AddDate\Users\User
     */
    public function getUser($id) {

        $user_id = NULL;
        $user_type = NULL;
        $user_fullname = NULL;
        $user_email = NULL;
        $user_createby = NULL;
        $user_createat = NULL;

        $stmt = $this->getDatabase()->prepare("SELECT User_Id, User_Type, User_FullName, User_Email, Create_by, Create_at FROM User_Data WHERE User_Id = ?");

        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->bind_result($user_id, $user_type, $user_fullname, $user_email, $user_createby, $user_createat);
        $stmt->store_result();
        $stmt->fetch();
        $stmt->free_result();
        $stmt->close();

        if ($user_id !== NULL &&
                $user_type !== NULL &&
                $user_fullname !== NULL &&
                $user_email !== NULL &&
                $user_createby !== NULL &&
                $user_createat !== NULL) {
            $user_token = $this->getUserTokenClass()->getToken($user_id);

            return new \AddDate\Users\User($user_id, $user_token, $user_type, $user_fullname, $user_email, $user_createat, $user_createby);
        }

        return NULL;
    }

    /**
     * 
     * @return array
     */
    public function getUsers() {
        $user_id = NULL;
        $users = [];

        $stmt = $this->getDatabase()->prepare("SELECT User_Id FROM User_Data");

        $stmt->execute();
        $stmt->bind_result($user_id);
        $stmt->store_result();

        while ($stmt->fetch()) {
            $users[] = $this->getUser($user_id);
        }

        $stmt->free_result();
        $stmt->close();

        return $users;
    }

    /**
     * 
     * @param \AddDate\Users\User $user
     * @return boolean
     */
    public function updateUser(\AddDate\Users\User $user) {
        if ($this->getUser($user->getId()) !== NULL) {

            $stmt = $this->getDatabase()->prepare("UPDATE User_Data SET User_FullName = ?, User_Email = ?, User_Type = ? WHERE User_Id = ?");

            $stmt->bind_param('ssii', $user->getFullName(), $user->getEmail(), $user->getType(), $user->getId());
            $stmt->execute();
            $stmt->close();

            $this->getUserTokenClass()->updateToken($user->getId(), $user->getToken());
            return TRUE;
        }
        return NULL;
    }

    /**
     * 
     * @param string $user_name
     * @param string $user_email
     * @param int $user_type
     * @param int $create_by
     * @return \AddDate\Users\User|boolean
     */
    public function insertUser($user_name, $user_email, $user_type, $create_by) {

        $stmt = $this->getDatabase()->prepare("INSERT INTO User_Data (User_FullName, User_Email, User_Type, Create_by) VALUES(?, ?, ?, ?)");

        $stmt->bind_param('ssii', $user_name, $user_email, $user_type, $create_by);
        $stmt->execute();

        if (!$stmt->error) {
            $user_id = $this->getDatabase()->getLastId();
            $this->getUserTokenClass()->insertToken($user_id, $this->getUserTokenClass()->generateToken());
            $stmt->close();

            return $this->getUser($user_id);
        }

        $stmt->close();
        return FALSE;
    }

    /**
     * 
     * @param int $id
     */
    public function deleteUser($id) {
        $stmt = $this->getDatabase()->prepare("DELETE FROM User_Data WHERE User_Id = ?");

        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();
    }

    /**
     * 
     * @return int
     */
    public function getCountUsers() {
        $user_count = 0;

        $stmt = $this->getDatabase()->prepare("SELECT COUNT(*) FROM User_Token");

        $stmt->execute();
        $stmt->bind_result($user_count);
        $stmt->store_result();
        $stmt->fetch();
        $stmt->free_result();
        $stmt->close();

        return $user_count;
    }

}
