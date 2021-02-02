<?php

namespace AddDate\Util;

/**
 * Instancia que proporciona métodos para llevar un registro de ejecución
 */
class Logger {

    /**
     * Alamacena todos los registros
     * @var array 
     */
    private $Logs;

    /**
     *
     * @var int 
     */
    private $TraceSteps = 3;

    /**
     * Inicialización de la instancia
     * @param type $Logger
     */
    public function __contruct(self $Logger = NULL) {
        $this->Logs = [];
        if ($Logger !== NULL) {
            foreach ($Logger->getLogs() as $key => $value) {
                $this->setLog($key, $value);
            }
        }
    }

    /** Metodo que guarda un nuevo registro en la instacia
     * @param string $area Lugar donde se guardara el registro
     * @param string $string Texto que se guarda (puede incluir formato) <b>Ejm: Hola %s!</b>
     * @param string $format Lista de valores que se usaran si el texto posee un formato
     */
    public function setLog($area, $string, ...$format) {
        $trace_arr = debug_backtrace(FALSE, $this->TraceSteps);
        $trace = end($trace_arr);
        $this->Logs[$area][] = new \AddDate\Util\Logger\Log(
                $trace['class'], $trace['function'], microtime(true), date('m/d/Y h:i:sa', time()), sprintf($string, ...$format)
        );
    }

    /**
     * Regresa un arreglo con todos los registros que posee la instancia
     * @return array Lista de registros
     */
    public function getLogs() {
        return $this->Logs;
    }

    /**
     * Regresa los registros del area espeficiada
     * @param string $area Lugar donde se guardo el registro
     * @return array|FALSE Arreglo con todos los registros del area espeficificada
     * o <b>FALSE</b> si el area no existe en los registros
     */
    public function getLog($area) {
        if (array_key_exists($area, $this->getLogs())) {
            return $this->Logs[$area];
        } else {
            return FALSE;
        }
    }

    /**
     * 
     * @param int $steps
     */
    public function setTraceSteps($steps) {
        $this->TraceSteps = $steps;
    }

    /**
     * 
     * @return int
     */
    public function getTraceStepts() {
        return $this->TraceSteps;
    }

}
