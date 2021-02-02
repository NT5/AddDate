<?php

namespace AddDate\Util;

/**
 * Instancia contenedora de métodos útiles para el correcto funcionamiento del
 * programa
 */
class Functions {

    /**
     * Regrea <b>TRUE</b> o <b>FALSE</b> Si una cadena de texto inicia con el
     * token asignado
     * @param string $haystack Cadena de texto que será analizada
     * @param string $needle Token que se comparara
     * @return boolean <b>TRUE</b> si el texto inicia con <b>$needle</b>
     * en otro caso regresara <b>FALSE</b>
     */
    public static function startsWith($haystack, $needle) {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }

    /**
     * Regresa una cadena de texto con el formato especificado
     * @param string $str Texto que será formateado
     * @param array $vars Arraglo con variablse usadas en el formateo
     * @param char $char Caracter de inicio que sera analizado (Por defecto '%')
     * @return string
     */
    public static function strFormat($str = '', $vars = array(), $char = '%') {
        if (!$str) {
            return '';
        }
        if (count($vars) > 0) {
            foreach ($vars as $k => $v) {
                $str = str_replace($char . $k, $v, $str);
            }
        }
        return $str;
    }

    /**
     * Regresa un directorio con el separador asignado del sistema y elimina los "<b>/../</b>" de la cadena de texto
     * @param array $dir_array Lista con los directorios y el archivo que sera formateado
     * @return string cadena de texto formateada
     */
    public static function parseDir($dir_array) {
        $formated = implode(DIRECTORY_SEPARATOR, $dir_array);
        return (realpath($formated) ? realpath($formated) : $formated);
    }

    /**
     * Compara dos arreglos para comprobar si contienen los mismos elementos
     * @param array $ar1
     * @param array $ar2
     * @return boolean <b>TRUE</b> Si los arreglos contienen los mismos elementos o
     * <b>FALSE</b> en caso contrario
     */
    public static function checkArray($ar1, $ar2) {
        foreach ($ar1 as $v) {
            if (array_key_exists($v, $ar2)) {
                continue;
            } else {
                return FALSE;
            }
        }
        return TRUE;
    }

}
