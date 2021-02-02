<?php

namespace AddDate;

/**
 * Clase principal que controla y proporciona todos los métodos de la base de datos
 */
class Database extends \AddDate\Factory\BaseComponents {

    /**
     * @var \AddDate\Database\Connection Instancia de <b>\AddDate\Database\Connection</b> 
     */
    private $Connection;

    /**
     * @param \AddDate\Database\Connection $Connection Instancia de <b>\AddDate\Database\Connection</b>
     * @param \AddDate\Factory\BaseComponents $BaseComponents
     */
    public function __construct(\AddDate\Database\Connection $Connection = NULL, \AddDate\Factory\BaseComponents $BaseComponents = NULL) {
        if (!$BaseComponents) {
            $BaseComponents = new \AddDate\Factory\BaseComponents();
        }
        parent::__construct($BaseComponents->getLogger(), $BaseComponents->getErrorSet(), $BaseComponents->getWarningSet());

        $this->Connection = ($Connection) ? : new \AddDate\Database\Connection(NULL, $this);

        $this->setLog(\AddDate\Util\Logger\Areas::DATABASE_METHODS, "Nueva instancia de base de datos creada");
    }

    /**
     * Método que cierra la conexión MySQLi
     */
    public function close() {
        if ($this->getConnection()) {
            $this->getConnection()->getMySQLi()->close();
            $this->setLog(\AddDate\Util\Logger\Areas::DATABASE_METHODS, "Conexión MySQLi cerrada");
        } else {
            $this->setLog(\AddDate\Util\Logger\Areas::DATABASE_METHODS_ERROR, "Llamada del método 'close' sin establecer una conexión validad a la base de datos");
        }
    }

    /**
     * 
     * @param string $charset
     */
    public function charset($charset) {
        if ($this->getConnection()) {
            mysqli_set_charset($this->getConnection()->getMySQLi(), $charset);
            $this->setLog(\AddDate\Util\Logger\Areas::DATABASE_METHODS, "Charset de la base de datos cambiado a %s", $charset);
        }
    }

    /**
     * Ejecuta un <b>mysqli_query</b> a la base de datos
     * @param string $sql Cadena de texto con comando SQL
     * @return mysqli_result Regresa objecto <b>mysqli_result</b> o <b>NULL</b>
     * si la instancia no esta conectada a la base de datos
     */
    public function query($sql) {
        if ($this->getConnection()) {
            return $this->getConnection()->getMySQLi()->query($sql);
        } else {
            $this->setLog(\AddDate\Util\Logger\Areas::DATABASE_METHODS_ERROR, "Llamada del método 'query' sin establecer una conexión validad a la base de datos");
        }
        return NULL;
    }

    /**
     * Ejecuta un <b>mysqli_stmt</b> a la base de datos
     * @param string $statement Cadena de texto con comando SQL
     * @return mysqli_stmt Regresa objecto <b>mysqli_stmt</b> o <b>NULL</b>
     * si la instancia no esta conectada a la base de datos
     */
    public function prepare($statement) {
        if ($this->getConnection()) {
            return $this->getConnection()->getMySQLi()->prepare($statement);
        } else {
            $this->setLog(\AddDate\Util\Logger\Areas::DATABASE_METHODS_ERROR, "Llamada del método 'prepare' sin establecer una conexión validad a la base de datos");
        }
        return NULL;
    }

    /**
     * Regresa Objecto MySQLi
     * @return \AddDate\Database\Connection|NULL Instancia <b>\AddDate\Database\Connection</b> proporcionada por
     * la clase de conexión
     */
    public function getConnection() {
        return ($this->Connection ? $this->Connection : NULL);
    }

    /**
     * Regresa una cadena de texto con la descripción del ultimo error
     * @return string Una cadena de texto que describe el error o una cadena de texto
     * vacia si no existe ninguno
     */
    public function getError() {
        return ($this->getConnection() ? mysqli_error($this->getConnection()->getMySQLi()) : "Instancia controladora MySQLi no conectada");
    }

    /**
     * 
     * @return int
     */
    public function getLastId() {
        return ($this->getConnection() ? $this->getConnection()->getMySQLi()->insert_id : 0);
    }

}
