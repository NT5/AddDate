<?php

namespace AddDate\Users;

/**
 * 
 */
class Sessions extends \AddDate\Factory\ExtendedComponents {

    /**
     *
     * @var \AddDate\Users
     */
    private $Users;

    /**
     *
     * @var int 
     */
    private $token_Length = 32;

    /**
     * 
     * @param \AddDate\Users $Users
     * @param \AddDate\Factory\ExtendedComponents $ExtendedComponents
     */
    public function __construct(\AddDate\Users $Users = NULL, \AddDate\Factory\ExtendedComponents $ExtendedComponents = NULL) {
        if (!$ExtendedComponents) {
            $ExtendedComponents = new \AddDate\Factory\ExtendedComponents();
        }
        parent::__construct($ExtendedComponents->getDatabase(), $ExtendedComponents->getPageConfig(), $ExtendedComponents->getCookies(), $ExtendedComponents);

        $this->Users = ($Users) ? : new \AddDate\Users($ExtendedComponents, NULL, $this);

        $this->setLog(\AddDate\Util\Logger\Areas::USERS_SESSIONS, "Nueva instancia de Usuarios de sesión creada");
    }

    /**
     * 
     * @return \AddDate\Users
     */
    public function getUsersClass() {
        return $this->Users;
    }

    /**
     * 
     * @return string
     */
    public function generateToken() {
        $generator = new \AddDate\Util\Token();
        $token = $generator->generate($this->token_Length);
        return $token;
    }

    /**
     * 
     * @param int $user_id
     * @param string $token
     */
    public function insertToken($user_id, $token) {
        if ($this->getUsersClass()->getUser($user_id) !== NULL) {

            $stmt = $this->getDatabase()->prepare("INSERT INTO User_Sessions (User_Id, Session_Token) VALUES(?, ?)");

            $stmt->bind_param('is', $user_id, $token);
            $stmt->execute();
            $stmt->close();

            return TRUE;
        }
        return NULL;
    }

    /**
     * 
     * @param string $token
     * @return bool
     */
    public function getUser($token) {
        $user_id = NULL;

        $stmt = $this->getDatabase()->prepare("SELECT User_Id FROM User_Sessions WHERE Session_Token = ?");

        $stmt->bind_param('s', $token);
        $stmt->execute();
        $stmt->bind_result($user_id);
        $stmt->store_result();
        $stmt->fetch();
        $stmt->free_result();
        $stmt->close();

        if ($user_id !== NULL) {
            $user = $this->getUsersClass()->getUser($user_id);
            return ($user ? $user : FALSE);
        }
        return NULL;
    }

    /**
     * 
     * @param int $token
     * @return void
     */
    public function deleteToken($token) {
        $stmt = $this->getDatabase()->prepare("DELETE FROM User_Sessions WHERE Session_Token = ?");
        $stmt->bind_param('s', $token);
        $stmt->execute();
        $stmt->close();
    }

}
