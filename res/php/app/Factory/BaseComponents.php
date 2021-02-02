<?php

namespace AddDate\Factory;

/**
 * 
 */
class BaseComponents implements \AddDate\Util\Logger\Loggeable, \AddDate\Error\ThrowableError, \AddDate\Warning\ThrowableWarning {

    /**
     * Objeto con métodos usados en el registro de seguimiento
     * @var \AddDate\Util\Logger 
     */
    private $Logger;

    /**
     * Set con errores que puede generar la pagina
     * @var \AddDate\Error\ErrorSet 
     */
    private $ErrorSet;

    /**
     * Set con advertencias que puede generar la pagina
     * @var \AddDate\Warning\WarningSet
     */
    private $WarningSet;

    /**
     * 
     * @param \AddDate\Util\Logger $Logger
     * @param \AddDate\Error\ErrorSet $ErrorSet
     * @param \AddDate\Warning\WarningSet $WarningSet
     */
    public function __construct(\AddDate\Util\Logger $Logger = NULL, \AddDate\Error\ErrorSet $ErrorSet = NULL, \AddDate\Warning\WarningSet $WarningSet = NULL) {
        $this->Logger = ($Logger) ? : new \AddDate\Util\Logger();
        $this->ErrorSet = ($ErrorSet) ? : new \AddDate\Error\ErrorSet();
        $this->WarningSet = ($WarningSet) ? : new \AddDate\Warning\WarningSet();
    }

    /**
     * 
     * @return \AddDate\Util\Logger
     */
    public function getLogger() {
        return $this->Logger;
    }

    /**
     * @param string $area
     * @param string $string
     * @param string $format
     */
    public function setLog($area, $string, ...$format) {
        $this->getLogger()->setLog($area, $string, ...$format);
    }

    /**
     * 
     * @return \AddDate\Error\ErrorSet
     */
    public function getErrorSet() {
        return $this->ErrorSet;
    }

    /**
     * 
     * @param type $Error
     */
    public function addError($Error) {
        $this->getErrorSet()->addError($Error);
    }

    /**
     * 
     * @return array
     */
    public function getErrors() {
        return $this->getErrorSet()->getErrors();
    }

    /**
     * @return \AddDate\Warning\WarningSet
     */
    public function getWarningSet() {
        return $this->WarningSet;
    }

    /**
     * 
     * @param type $Warning
     */
    public function addWarning($Warning) {
        $this->getWarningSet()->addWarning($Warning);
    }

    /**
     * @return array
     */
    public function getWarnings() {
        return $this->getWarningSet()->getWarnings();
    }

}
