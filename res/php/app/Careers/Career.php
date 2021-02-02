<?php

namespace AddDate\Careers;

/**
 * 
 */
class Career {

    /**
     *
     * @var int 
     */
    private $Id;

    /**
     *
     * @var string 
     */
    private $Name;

    /**
     *
     * @var string 
     */
    private $CreateAt;

    /**
     *
     * @var \AddDate\Users\User 
     */
    private $CreateBy;

    /**
     * 
     * @param int $id
     * @param string $name
     * @param string $createat
     * @param \AddDate\Users\User $createby
     */
    public function __construct($id = 0, $name = "Default", $createat = 0, \AddDate\Users\User $createby = NULL) {
        $this->Id = $id;
        $this->Name = $name;
        $this->CreateAt = $createat;
        $this->CreateBy = $createby;
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
     * @return string
     */
    public function getName() {
        return $this->Name;
    }

    /**
     * 
     * @return string
     */
    public function getCreateAt() {
        return $this->CreateAt;
    }

    /**
     * 
     * @return \AddDate\Users\User
     */
    public function getCreateBy() {
        return $this->CreateBy;
    }

}
