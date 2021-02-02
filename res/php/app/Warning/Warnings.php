<?php

namespace AddDate\Warning;

/**
 * Clase <b>ENUM</b> con las advertencias validas
 */
abstract class Warnings {

    /**
     * @var int Advertencia desconocida
     */
    const UNKNOWN = 0;

    /**
     * @var int Se cargo la configuracion por defecto de la pagina
     */
    const DEFAULT_PAGE_CONFIGURATION = 1;

    /**
     * @var int No existe la conexión a la base de datos para realizar cierre
     */
    const NO_DATABASE_CONNECTION_TO_CLOSE = 2;

    /**
     * @var int No existe una instalacion en la base de datos
     */
    const NO_TABLES_INSTALLATION = 3;

    /**
     * @var int No se pudo ejecutar un comando de instalación de tablas en la base de datos
     */
    const CANT_EXECUTE_INSTALLATION_TABLE_COMMAND = 4;

    /**
     * @var int No se pudo cargar el archivo de configuración de la base de datos 
     */
    const CANT_LOAD_DATABASE_CONFIGURATION_FILE = 5;

    /**
     * @var int El archivo de configuración de la base de datos tiene un formato invalido
     */
    const DATABASE_CONFIGURATION_INVALID_FORMAT = 6;

    /**
     * @var int No se puede guardar el archivo de configuracion para la pagina web
     */
    const CANT_SAVE_PAGE_CONFIG_FILE = 7;

    /**
     * @var int No se pudo cargar el archivo de configuración para la página 
     */
    const CANT_LOAD_PAGE_CONFIGURATION_FILE = 8;

    /**
     * @var int El archivo de configuración de la página tiene un formato invalido
     */
    const PAGE_CONFIGURATION_INVALID_FORMAT = 9;

    /**
     * @var int No se puede guardar el archivo de configuracion para la base de datos
     */
    const CANT_SAVE_DATABASE_CONFIG_FILE = 10;

}
