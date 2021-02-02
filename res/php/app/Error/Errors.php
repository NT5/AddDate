<?php

namespace AddDate\Error;

/**
 * Clase <b>ENUM</b> con los errores validos
 */
abstract class Errors {

    /**
     * @var int Error desconocido
     */
    const UNKNOWN = 0;

    /**
     * @var int Archivo SQL de instalación de tablas no encontrado
     */
    const INSTALLATION_TABLE_FILE_NOT_FOUND = 1;

    /**
     * @var int Formato invalido
     */
    const INVALID_FORMAT = 2;

    /**
     * @var int No se puede crear el objeto controlador de la base de datos
     */
    const CANT_CREATE_DATABASE_CONTROLLER = 3;

    /**
     * @var int No se puede crear el objecto de conexión de la base de datos
     */
    const CANT_CREATE_DATABASE_CONNECTION = 4;

    /**
     * @var int No se puede crear el objecto de configuración de la base de datos
     */
    const CANT_CREATE_DATABASE_CONFIG = 5;

    /**
     * @var int
     */
    const CANT_CONNECT_MYSQLI_LINK = 6;

}
