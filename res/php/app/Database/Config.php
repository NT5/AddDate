<?php

namespace AddDate\Database;

/**
 * Instancia abstracta usada para almacenar y cargar
 * datos de configuración de la base de datos
 */
class Config extends \AddDate\Factory\BaseComponents {

    /**
     * @var string Dirección del servidor de la base de datos
     */
    private $server;

    /**
     * @var string Nombre de usuario de la base de datos 
     */
    private $username;

    /**
     * @var string Contraseña de conexion 
     */
    private $password;

    /**
     * @var string Base de datos que se usara
     */
    private $database;

    /**
     * Regresa instancia de configuración de la base de datos
     * @param string $server Dirección del servidor de la base de datos
     * @param string $username Nombre de usuario de la base de datos
     * @param string $password Contraseña de conexion
     * @param string $database Base de datos que se usara
     * @param \AddDate\Factory\BaseComponents $BaseComponents
     */
    public function __construct($server = NULL, $username = NULL, $password = NULL, $database = NULL, \AddDate\Factory\BaseComponents $BaseComponents = NULL) {
        if (!$BaseComponents) {
            $BaseComponents = new \AddDate\Factory\BaseComponents();
        }
        parent::__construct($BaseComponents->getLogger(), $BaseComponents->getErrorSet(), $BaseComponents->getWarningSet());

        $this->server = ($server) ? : "localhost";
        $this->username = ($username) ? : "default";
        $this->password = ($password) ? : "default";
        $this->database = ($database) ? : "adddate";

        $this->setLog(\AddDate\Util\Logger\Areas::DATABASE_CONFIG, "Nueva instancia de configuración de base de datos creada");
    }

    /**
     * 
     * @return string
     */
    public function getServer() {
        return $this->server;
    }

    /**
     * 
     * @return string
     */
    public function getUserName() {
        return $this->username;
    }

    /**
     * 
     * @return string
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * 
     * @return string
     */
    public function getDatabase() {
        return $this->database;
    }

    /**
     * 
     * @param string $server
     */
    public function setServer($server = 'localhost') {
        $this->server = $server;
    }

    /**
     * 
     * @param string $username
     */
    public function setUserName($username = 'default') {
        $this->username = $username;
    }

    /**
     * 
     * @param string $password
     */
    public function setPassword($password = 'default') {
        $this->password = $password;
    }

    /**
     * 
     * @param string $database
     */
    public function setDatabase($database = 'adddate') {
        $this->database = $database;
    }

    /**
     * Guarda la configuracion en un archivo .ini
     * @param string $inifile Ruta del archivo .ini en el servidor
     * @return boolean
     */
    public function saveToIni($inifile = 'config.ini') {

        $this->setLog(\AddDate\Util\Logger\Areas::DATABASE_CONFIG, "Intentando guardar configuración en el archivo $inifile...");

        $ini_area = "MySQL";
        $data = [
            "server" => $this->getServer(),
            "username" => $this->getUserName(),
            "password" => $this->getPassword(),
            "database" => $this->getDatabase()
        ];

        foreach ($data as $index => $value) {
            if (\AddDate\Util\Files::set_ini_file($inifile, $ini_area, $index, $value)) {
                $this->setLog(\AddDate\Util\Logger\Areas::DATABASE_CONFIG, "La variable %s fue guardada correctamente", $index);
                continue;
            } else {
                $this->setLog(\AddDate\Util\Logger\Areas::DATABASE_CONFIG_ERROR, "No se pudo guardar el archivo de configuración; operacion abortada");
                return FALSE;
            }
        }

        $this->setLog(\AddDate\Util\Logger\Areas::DATABASE_CONFIG, "El archivo $inifile fue guardado correctamente");
        return TRUE;
    }

    /**
     * Regresa instancia de configuración de la base de datos cargada desde un archivo .ini valido
     * @param string $inifile Ruta del archivo .ini en el servidor
     * @param \AddDate\Factory\BaseComponents $BaseComponents
     * @return \AddDate\Database\Config
     */
    public static function fromIniFile($inifile = NULL, \AddDate\Factory\BaseComponents $BaseComponents = NULL) {

        $BaseComponents = ($BaseComponents) ? : new \AddDate\Factory\BaseComponents();
        $inifile = ($inifile) ? : 'config.ini';

        $valid_structure = [
            "server",
            "username",
            "password",
            "database"
        ];
        $ini_area = "MySQL";

        $BaseComponents->setLog(\AddDate\Util\Logger\Areas::DATABASE_CONFIG, "Intentando crear configuración de base de datos con $inifile...");

        $ini = \AddDate\Util\Files::load_ini_file($inifile);

        if ($ini) {
            $BaseComponents->setLog(\AddDate\Util\Logger\Areas::DATABASE_CONFIG, "Comprobando estructura de $inifile...");

            if (\AddDate\Util\Functions::checkArray([$ini_area], $ini) && \AddDate\Util\Functions::checkArray($valid_structure, $ini[$ini_area])) {
                $instance = new self(
                        $ini[$ini_area]["server"], $ini[$ini_area]["username"], $ini[$ini_area]["password"], $ini[$ini_area]["database"], $BaseComponents
                );
                $BaseComponents->setLog(\AddDate\Util\Logger\Areas::DATABASE_CONFIG, "Instancia de configuración de base de datos creada correctamente con $inifile");

                return $instance;
            } else {
                $BaseComponents->addWarning(new \AddDate\Warning(\AddDate\Warning\Warnings::DATABASE_CONFIGURATION_INVALID_FORMAT));
                $BaseComponents->setLog(\AddDate\Util\Logger\Areas::DATABASE_CONFIG_ERROR, "El archivo $inifile tiene una estructura invalida");

                return new self(NULL, NULL, NULL, NULL, $BaseComponents);
            }
        } else {
            $BaseComponents->addWarning(new \AddDate\Warning(\AddDate\Warning\Warnings::CANT_LOAD_DATABASE_CONFIGURATION_FILE));
            $BaseComponents->setLog(\AddDate\Util\Logger\Areas::DATABASE_CONFIG_ERROR, "El archivo $inifile no pudo ser cargado");

            return new self(NULL, NULL, NULL, NULL, $BaseComponents);
        }
    }

}
