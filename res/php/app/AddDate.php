<?php

namespace AddDate;

/**
 * Clase principal de toda la pagina, aquí se juntan
 * las demás clases para funcionar y proporcionar los métodos en el
 * ambiente de desarrollo
 */
class AddDate extends \AddDate\Factory\ExtendedComponents {

    /**
     *
     * @var \self 
     */
    private static $Instance;

    /**
     *
     * @var \AddDate\PageManager 
     */
    private $PageManager;

    /**
     * @var float Guarda el tiempo de ejecución en milisegundos
     */
    private $ExecutionTime = 0;

    /**
     * Ruta del archivo .ini que contiene la configuración de la pagina
     * @var string
     */
    private $ConfigFile;

    /**
     * 
     * @return self
     */
    public static function getInstance() {
        if (!isset(self::$Instance)) {
            $c = __CLASS__;
            self::$Instance = new $c;
        }
        return self::$Instance;
    }

    /**
     * 
     */
    public function __construct() {

        $this->ExecutionTime = microtime(true);
        $this->ConfigFile = \AddDate\Util\Functions::parseDir(array(__DIR__, "..", "..", "..", "config.ini"));

        $BaseComponents = $this->initBaseComponents();
        $ExtendedComponents = $this->initExtendedComponents($BaseComponents);

        parent::__construct($ExtendedComponents->getDatabase(), $ExtendedComponents->getPageConfig(), $ExtendedComponents->getCookies(), $BaseComponents);

        $this->getLogger()->setLog(\AddDate\Util\Logger\Areas::CORE, "Nueva instancia %s creada", get_class());

        $this->run();
    }

    /**
     * 
     * @return \AddDate\PageManager
     */
    public function getPageManager() {
        return $this->PageManager;
    }

    /**
     * 
     * @return string
     */
    public function getConfigFile() {
        return $this->ConfigFile;
    }

    /**
     * 
     * @return float
     */
    public function getExecutionTime() {
        return $this->ExecutionTime;
    }

    /**
     * 
     * @return \AddDate\Factory\BaseComponents
     */
    private function initBaseComponents() {
        $Logger = new \AddDate\Util\Logger();
        $WarningSet = new \AddDate\Warning\WarningSet();
        $ErrorSet = new \AddDate\Error\ErrorSet();

        $BaseComponents = new \AddDate\Factory\BaseComponents($Logger, $ErrorSet, $WarningSet);

        return $BaseComponents;
    }

    /**
     * 
     * @param \AddDate\Factory\BaseComponents $BaseComponents
     * @return \AddDate\Factory\ExtendedComponents
     */
    private function initExtendedComponents(\AddDate\Factory\BaseComponents $BaseComponents) {
        $Cookies = $this->initCookies($BaseComponents);
        $PageConfig = $this->initPageConfig($BaseComponents);
        $Database = $this->initDatabase($BaseComponents);

        $ExtendedComponents = new \AddDate\Factory\ExtendedComponents($Database, $PageConfig, $Cookies, $BaseComponents);

        return $ExtendedComponents;
    }

    /**
     * 
     * @param \AddDate\Factory\BaseComponents $BaseComponents
     * @return \AddDate\Cookies
     */
    private function initCookies(\AddDate\Factory\BaseComponents $BaseComponents) {
        $Cookies = new \AddDate\Cookies("adddate");
        return $Cookies;
    }

    /**
     * 
     * @param \AddDate\Factory\BaseComponents $BaseComponents
     * @return \AddDate\Config
     */
    private function initPageConfig(\AddDate\Factory\BaseComponents $BaseComponents) {
        $BaseComponents->getLogger()->setLog(\AddDate\Util\Logger\Areas::CORE, "Intentando crear instancia de configuración para pagina...");
        $PageConfig = \AddDate\Config::fromIniFile($this->getConfigFile(), $BaseComponents);
        $BaseComponents->getLogger()->setLog(\AddDate\Util\Logger\Areas::CORE, "Instancia de configuración creada");

        return $PageConfig;
    }

    /**
     * 
     * @param \AddDate\Factory\BaseComponents $BaseComponents
     * @return \AddDate\Database
     */
    private function initDatabase(\AddDate\Factory\BaseComponents $BaseComponents) {
        $BaseComponents->getLogger()->setLog(\AddDate\Util\Logger\Areas::CORE, "Inicializando componentes de base de datos...");

        $mysqli_config = \AddDate\Database\Config::fromIniFile($this->getConfigFile(), $BaseComponents);
        $mysqli_connection = new \AddDate\Database\Connection($mysqli_config, $BaseComponents);

        $Database = new \AddDate\Database($mysqli_connection, $BaseComponents);

        $BaseComponents->getLogger()->setLog(\AddDate\Util\Logger\Areas::CORE, "Componentes de base de datos iniciados");

        return $Database;
    }

    /**
     * 
     */
    private function run() {

        $this->PageManager = new \AddDate\PageManager(INPUT_GET, "p", $this);

        $this->initInstall();

        $this->getPageManager()->initPage();

        $this->disposeObjects();

        $this->getPageManager()->getTwig()->setVars([
            'page_title' => $this->getPageConfig()->getPageTitle() . $this->getPageManager()->getTwig()->getVar('page_title'),
            'logs' => $this->getLogger()->getLogs()
        ]);

        $this->getPageManager()->display();
    }

    /**
     * <p>
     * Borra de forma segura todos objetos que la aplicación uso
     * </p>
     * <br/>
     * Se recomienda usar este método cuando se finalice la aplicación
     * o estes seguro de no usar ningun metodo de base de datos o de configuración
     */
    private function disposeObjects() {
        $this->getLogger()->setLog(\AddDate\Util\Logger\Areas::CORE, "Eliminando instancia %s...", get_class());

        $this->disposePageConfig();
        $this->disposeDatabase();

        $this->getLogger()->setLog(\AddDate\Util\Logger\Areas::CORE, "Instancia %s finalizada correctamente", get_class());
        $this->ExecutionTime = ( microtime(true) - self::getExecutionTime() );
        $this->getLogger()->setLog(\AddDate\Util\Logger\Areas::CORE, "%s generada en %sms", get_class(), $this->getExecutionTime());
    }

    /**
     *  
     */
    private function disposePageConfig() {
        if (!$this->getPageConfig()->saveToIni($this->getConfigFile())) {
            $this->addWarning(new \AddDate\Warning(\AddDate\Warning\Warnings::CANT_SAVE_PAGE_CONFIG_FILE));
        }
    }

    /**
     * 
     */
    private function disposeDatabase() {

        if (!$this->getDatabase()->getConnection()->getConfig()->saveToIni($this->getConfigFile())) {
            $this->addWarning(new \AddDate\Warning(\AddDate\Warning\Warnings::CANT_SAVE_DATABASE_CONFIG_FILE));
        }

        if ($this->getDatabase()->getConnection()->getMySQLi()) {
            $this->getDatabase()->close();
            $this->getLogger()->setLog(\AddDate\Util\Logger\Areas::CORE, "Base de datos desconectada");
        } else {
            $this->getWarningSet()->addWarning(new \AddDate\Warning(\AddDate\Warning\Warnings::NO_DATABASE_CONNECTION_TO_CLOSE));
            $this->getLogger()->setLog(\AddDate\Util\Logger\Areas::CORE, "No existía una base de datos conectada; ignorando cierre");
        }
    }

    /**
     * 
     */
    private function initInstall() {
        if ($this->getDatabase()->getConnection()->getMySQLi()) {
            $this->getDatabase()->charset('utf8');

            $Installer = new \AddDate\Util\Installer($this);
            $Installer->Install();
        }
    }

}
