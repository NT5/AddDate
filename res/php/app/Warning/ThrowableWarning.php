<?php

namespace AddDate\Warning;

/**
 * 
 */
interface ThrowableWarning {

    /**
     * 
     * @return \AddDate\Warning\WarningSet
     */
    public function getWarningSet();

    /**
     * 
     * @param type $Warning
     */
    public function addWarning($Warning);

    /**
     * 
     * @return type
     */
    public function getWarnings();
}
