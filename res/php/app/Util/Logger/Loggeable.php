<?php

namespace AddDate\Util\Logger;

/**
 * 
 */
interface Loggeable {

    /**
     * 
     * @return \AddDate\Util\Logger
     */
    public function getLogger();

    /**
     * 
     * @param string $area
     * @param string $string
     * @param string $format
     */
    public function setLog($area, $string, ...$format);
}
