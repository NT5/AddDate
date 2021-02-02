<?php

namespace AddDate;

/**
 * Clase <b>Warning</b> con métodos usados en el manejo de advertencias
 */
class Warning {

    /**
     * 
     * @var int 
     */
    private $Warning_Code;

    /**
     *
     * @var string 
     */
    private $Warning_Class;

    /**
     *
     * @var int 
     */
    private $Warning_Time;

    /**
     *
     * @var int 
     */
    private $TraceSteps = 3;

    /**
     * Regresa instancia de advertencias de la pagina web
     * @param int $warning
     */
    public function __construct($warning) {
        $trace_arr = debug_backtrace(FALSE, $this->TraceSteps);
        $trace = end($trace_arr);

        $this->Warning_Class = $trace['class'];
        $this->Warning_Code = $warning;
        $this->Warning_Time = microtime(true);
    }

    /**
     * @return int
     */
    public function getWarningCode() {
        return $this->Warning_Code;
    }

    /**
     * 
     * @return string
     */
    public function getWarningClass() {
        return $this->Warning_Class;
    }

    /**
     * 
     * @return int
     */
    public function getWarningTime() {
        return $this->Warning_Time;
    }

}
