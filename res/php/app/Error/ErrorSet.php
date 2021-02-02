<?php

namespace AddDate\Error;

/**
 * 
 */
class ErrorSet {

    /**
     *
     * @var array 
     */
    private $Errors;

    /**
     * 
     * @param self $Errors
     */
    public function __construct(self $Errors = NULL) {
        $this->Errors = [];

        if ($Errors !== NULL) {
            foreach ($Errors->getErrors() as $value) {
                $this->addError($value);
            }
        }
    }

    /**
     * 
     * @param \AddDate\Error $Error
     */
    public function addError(\AddDate\Error $Error) {
        $this->Errors[] = $Error;
    }

    /**
     * 
     * @return array
     */
    public function getErrors() {
        return $this->Errors;
    }

}
