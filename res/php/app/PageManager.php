<?php

namespace AddDate;

/**
 * 
 */
class PageManager extends \AddDate\Factory\AddDateComponents {

    /**
     *
     * @var int 
     */
    private $Listen_Type;

    /**
     *
     * @var string 
     */
    private $Listen_Url;

    /**
     *
     * @var \AddDate\Pages\Page
     */
    private $Page;

    /**
     *
     * @var type 
     */
    private $User;

    /**
     * 
     * @param int $ListenType
     * @param string $ListenUrl
     * @param \AddDate\Factory\ExtendedComponents $ExtendedComponents
     */
    public function __construct($ListenType = NULL, $ListenUrl = NULL, \AddDate\Factory\ExtendedComponents $ExtendedComponents = NULL) {
        if (!$ExtendedComponents) {
            $ExtendedComponents = new \AddDate\Factory\ExtendedComponents();
        }
        parent::__construct(NULL, NULL, NULL, NULL, $ExtendedComponents);

        $this->Listen_Type = ($ListenType) ? : INPUT_GET;
        $this->Listen_Url = ($ListenUrl) ? : 'p';

        $this->setLog(\AddDate\Util\Logger\Areas::PAGE_MANAGER, "Nueva instancia controladora de página creada");
    }

    /**
     * 
     * @return int
     */
    public function getListenType() {
        return $this->Listen_Type;
    }

    /**
     * 
     * @return string
     */
    public function getListenUrl() {
        return $this->Listen_Url;
    }

    /**
     * 
     * @return \AddDate\Pages\Page
     */
    public function getPage() {
        return $this->Page;
    }

    /**
     * 
     * @param \AddDate\Pages\Page $page
     */
    private function setPage(\AddDate\Pages\Page $page) {
        $this->Page = $page;
    }

    /**
     * 
     * @return \AddDate\Twig
     */
    public function getTwig() {
        if ($this->getPage()) {
            return $this->getPage()->getTwig();
        }
    }

    /**
     * 
     */
    public function display() {
        if ($this->getPage()) {
            echo $this->getPage()->display();
        }
    }

    /**
     * 
     */
    public function initPage() {
        if (
                $this->checkFirstRun() === FALSE &&
                $this->checkWarnings() === FALSE &&
                $this->checkErrors() === FALSE &&
                $this->checkUserCount() === FALSE
        ) {

            $url_page = filter_input($this->getListenType(), $this->getListenUrl());

            switch ($url_page) {
                case "about":
                    $this->Page = new \AddDate\Pages\About($this);
                    break;
                case "search":
                    $this->Page = new \AddDate\Pages\Search($this);
                    break;
                case "admin":
                    $this->Page = new \AddDate\Pages\Admin($this);
                    break;
                case "home":
                default:
                    $this->Page = new \AddDate\Pages\Home($this);
                    break;
            }
            $this->setUpUser();
        }
    }

    public function setUpUser() {
        $cookie_session = $this->getCookies()->getCookie('session');
        if ($cookie_session) {
            $user = $this->getUsers()->getUserSessionClass()->getUser($cookie_session);
            if ($user) {
                $this->User = $user;
                $this->getTwig()->setVar('user_data', $this->User);
            }
        }
    }

    public function getUser() {
        return $this->User;
    }

    /**
     * 
     * @return boolean
     */
    private function checkFirstRun() {
        if ($this->getPageConfig()->getFirstRun()) {
            $page = new \AddDate\Pages\FirstRun($this, 1);

            $this->setPage($page);
            return TRUE;
        }
        return FALSE;
    }

    /**
     * 
     * @return boolean
     */
    private function checkUserCount() {
        $users = $this->getUsers()->getCountUsers();

        if ($users <= 0) {
            $page = new \AddDate\Pages\FirstRun($this, 2);

            $this->setPage($page);
            return TRUE;
        }

        return FALSE;
    }

    /**
     * 
     * @return boolean
     */
    private function checkErrors() {
        foreach ($this->getErrors() as $error) {

            switch ($error->getErrorCode()) {
                case \AddDate\Error\Errors::CANT_CREATE_DATABASE_CONTROLLER:
                case \AddDate\Error\Errors::CANT_CREATE_DATABASE_CONNECTION:
                case \AddDate\Error\Errors::CANT_CREATE_DATABASE_CONFIG:
                case \AddDate\Error\Errors::CANT_CONNECT_MYSQLI_LINK:
                    $this->setPage(new \AddDate\Pages\Errors($this, $error->getErrorCode()));
                    return TRUE;
            }
        }

        return FALSE;
    }

    /**
     * 
     * @return boolean
     */
    private function checkWarnings() {
        foreach ($this->getWarnings() as $warning) {

            switch ($warning->getWarningCode()) {
                case \AddDate\Warning\Warnings::DEFAULT_PAGE_CONFIGURATION:
                    $this->setPage(new \AddDate\Pages\FirstRun($this, 1));
                    return TRUE;
            }
        }
        return FALSE;
    }

}
