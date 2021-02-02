<?php

namespace AddDate\Error;

/**
 * 
 */
interface ThrowableError {

    /**
     * 
     * @return \AddDate\Error\ErrorSet
     */
    public function getErrorSet();

    /**
     * 
     * @param type $Error
     */
    public function addError($Error);

    /**
     * 
     * @return type
     */
    public function getErrors();
}
