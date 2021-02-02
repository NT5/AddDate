<?php

namespace AddDate\Warning;

/**
 * 
 */
class WarningSet {

    /**
     *
     * @var array 
     */
    private $Warnings;

    /**
     * 
     * @param self $Warning
     */
    public function __construct(self $Warning = NULL) {
        $this->Warnings = [];

        if ($Warning !== NULL) {
            foreach ($Warning->getWarnings() as $value) {
                $this->addWarning($value);
            }
        }
    }

    /**
     * 
     * @param \AddDate\Warning $Warning
     */
    public function addWarning(\AddDate\Warning $Warning) {
        $this->Warnings[] = $Warning;
    }

    /**
     * 
     * @return array
     */
    public function getWarnings() {
        return $this->Warnings;
    }

}
