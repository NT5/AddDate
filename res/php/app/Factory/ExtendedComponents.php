<?php

namespace AddDate\Factory;

class ExtendedComponents extends \AddDate\Factory\BaseComponents {

    /**
     * Objeto con métodos usados en el control de la base de datos
     * @var \AddDate\Database 
     */
    private $Database;

    /**
     * Objeto con métodos usados en la configuracion de la pagina
     * @var \AddDate\Config 
     */
    private $PageConfig;

    /**
     *s
     * @var \AddDate\Cookies 
     */
    private $Cookies;

    /**
     * 
     * @param \AddDate\Database $Database
     * @param \AddDate\Config $PageConfig
     * @param \AddDate\Cookies $Cookies
     * @param \AddDate\Factory\BaseComponents $BaseComponents
     */
    public function __construct(\AddDate\Database $Database = NULL, \AddDate\Config $PageConfig = NULL, \AddDate\Cookies $Cookies = NULL, \AddDate\Factory\BaseComponents $BaseComponents = NULL) {
        if (!$BaseComponents) {
            $BaseComponents = new \AddDate\Factory\BaseComponents();
        }
        parent::__construct($BaseComponents->getLogger(), $BaseComponents->getErrorSet(), $BaseComponents->getWarningSet());

        $this->Database = ($Database) ? : new \AddDate\Database(NULL, $this);
        $this->PageConfig = ($PageConfig) ? : new \AddDate\Config(NULL, NULL, $this);
        $this->Cookies = ($Cookies) ? : new \AddDate\Cookies();
    }

    /**
     * 
     * @return \AddDate\Database
     */
    public function getDatabase() {
        return $this->Database;
    }

    /**
     * 
     * @return \AddDate\Config
     */
    public function getPageConfig() {
        return $this->PageConfig;
    }

    /**
     * 
     * @return \AddDate\Cookies
     */
    public function getCookies() {
        return $this->Cookies;
    }

}
