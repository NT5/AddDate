<?php

namespace AddDate\Users;

/**
 * 
 */
class User {

    /**
     * 
     * @var int 
     */
    private $User_Id;

    /**
     *
     * @var string 
     */
    private $User_FullName;

    /**
     *
     * @var string 
     */
    private $User_Token;

    /**
     *
     * @var int 
     */
    private $User_Type;

    /**
     *
     * @var string 
     */
    private $User_Email;

    /**
     *
     * @var string 
     */
    private $User_Createat;

    /**
     *
     * @var int 
     */
    private $User_Createby;

    /**
     * 
     * @param int $user_id
     * @param string $user_token
     * @param int $user_type
     * @param string $user_fullname
     * @param string $user_email
     * @param string $user_createat
     * @param int $user_createby
     */
    public function __construct($user_id = 0, $user_token = 0, $user_type = 0, $user_fullname = "Default", $user_email = "default@adddate", $user_createat = 0, $user_createby = 0) {
        $this->User_Id = $user_id;
        $this->User_Token = $user_token;
        $this->User_Type = $user_type;
        $this->User_FullName = $user_fullname;
        $this->User_Email = $user_email;
        $this->User_Createby = $user_createby;
        $this->User_Createat = $user_createat;
    }

    /**
     * 
     * @return int
     */
    public function getId() {
        return $this->User_Id;
    }

    /**
     * 
     * @return int
     */
    public function getType() {
        return $this->User_Type;
    }

    /**
     * 
     * @return string
     */
    public function getToken() {
        return $this->User_Token;
    }

    /**
     * 
     * @return string
     */
    public function getFullName() {
        return $this->User_FullName;
    }

    /**
     * 
     * @return string
     */
    public function getEmail() {
        return $this->User_Email;
    }

    /**
     * 
     * @return int
     */
    public function getCreateBy() {
        return $this->User_Createby;
    }

    /**
     * 
     * @return string
     */
    public function getCreateAt() {
        return $this->User_Createat;
    }

    /**
     * 
     * @param string $name
     */
    public function setName($name) {
        $this->User_FullName = $name;
    }

    /**
     * 
     * @param string $email
     */
    public function setEmail($email) {
        $this->User_Email = $email;
    }

    /**
     * 
     * @param int $type
     */
    public function setType($type) {
        $this->User_Type = $type;
    }

}
