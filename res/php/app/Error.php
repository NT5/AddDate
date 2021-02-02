<?php

namespace AddDate;

/**
 * Clase <b>Error</b> con métodos usados en el manejo de errores
 */
class Error {

    /**
     * 
     * @var string 
     */
    private $Error_Class;

    /**
     *
     * @var int 
     */
    private $Error_Code;

    /**
     *
     * @var int 
     */
    private $Error_Time;

    /**
     *
     * @var int 
     */
    private $TraceSteps = 3;

    /**
     * Regresa instancia de errores de la pagina web
     * @param int $error
     */
    public function __construct($error) {
        $trace_arr = debug_backtrace(FALSE, $this->TraceSteps);
        $trace = end($trace_arr);

        $this->Error_Class = $trace['class'];
        $this->Error_Code = $error;
        $this->Error_Time = microtime(true);
    }

    /**
     * @return int
     */
    public function getErrorCode() {
        return $this->Error_Code;
    }

    /**
     * 
     * @return string
     */
    public function getErrorClass() {
        return $this->Error_Class;
    }

    /**
     * 
     * @return int
     */
    public function getErrorTime() {
        return $this->Error_Time;
    }

}
