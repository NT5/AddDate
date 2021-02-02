<?php

namespace AddDate\Database;

/**
 * Clase <b>Util</b> que contiene métodos utilizados en las consultas con la base de datos
 */
class Util {

    /**
     * Función que carga un archivo de syntax SQL
     * @param type $file Directorio del fichero SQL
     * @return array Arreglo con todos los comandos cargados o <b>NULL</b> si es
     * un fichero invalido
     */
    public static function sqlFromFile($file) {
        if (realpath($file)) {
            $result = array();
            $Fcommands = @file_get_contents($file);
            $sql_lines = explode("\n", $Fcommands);
            $commands = '';
            foreach ($sql_lines as $sql_line) {
                $line = trim($sql_line);
                if ($line && !\AddDate\Util\Functions::startsWith($sql_line, '--')) {
                    $commands .= $sql_line . "\n";
                }
            }
            $commands = explode(";", $commands);
            foreach ($commands as $command) {
                if (trim($command)) {
                    array_push($result, $command);
                }
            }
            return $result;
        } else {
            return NULL;
        }
    }

}
