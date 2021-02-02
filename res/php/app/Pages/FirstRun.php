<?php

namespace AddDate\Pages;

/**
 * 
 */
class FirstRun extends \AddDate\Pages\Page {

    /**
     *
     * @var int
     */
    private $Step;

    /**
     * 
     * @param \AddDate\Factory\AddDateComponents $AddDateComponents
     * @param int $Step
     */
    public function __construct(\AddDate\Factory\AddDateComponents $AddDateComponents, $Step) {
        parent::__construct($AddDateComponents);

        $this->Step = $Step;

        switch ($this->Step) {
            case 1:
                $this->initFirstRun();
                break;
            case 2:
                $this->initFirstRunNoUsers();
                break;
        }
    }

    /**
     * 
     */
    private function initFirstRun() {
        switch ($this->CheckPost($this->Step)) {
            case TRUE:
                $this->setTemplate("pages/firts_run/firts_run_done.twig");
                break;
            case FALSE:
            case NULL:
                $this->setTemplate("pages/firts_run/firts_run.twig");
                $this->setVar("page_title", " - Primera ejecucion");
                break;
        }
    }

    /**
     * 
     */
    private function initFirstRunNoUsers() {
        switch ($this->CheckPost($this->Step)) {
            case TRUE:
                $this->setTemplate("pages/firts_run/no_users/done.twig");
                break;
            case FALSE:
            CASE NULL:
                $this->setTemplate("pages/firts_run/no_users/template.twig");
                break;
        }
    }

    /**
     * 
     * @param int $section
     * @return boolean
     */
    private function CheckPost($section) {
        $POST = filter_input_array(INPUT_POST);
        if ($POST) {
            switch ($section) {
                case 1:
                    return $this->CheckPostNoConfig($POST);
                case 2:
                    return $this->CheckPostNoUsers($POST);
            }
        }
        return NULL;
    }

    /**
     * 
     * @param array $POST
     * @return boolean
     */
    private function CheckPostNoConfig($POST) {
        $require = [
            "server",
            "user",
            "password",
            "database"
        ];

        if (\AddDate\Util\Functions::checkArray($require, $POST)) {
            $db_config = $this->getDatabase()->getConnection()->getConfig();

            $db_config->setServer($POST['server']);
            $db_config->setUserName($POST['user']);
            $db_config->setPassword($POST['password']);
            $db_config->setDatabase($POST['database']);

            $this->getPageConfig()->setFirstRun(FALSE);

            return TRUE;
        }
        return FALSE;
    }

    /**
     * 
     * @param array $POST
     * @return boolean
     */
    private function CheckPostNoUsers($POST) {
        $require = [
            "username",
            "email"
        ];

        if (\AddDate\Util\Functions::checkArray($require, $POST)) {

            $user = $this->getUsers()->insertUser($POST['username'], $POST['email'], 0, 1);

            if ($user !== FALSE) {
                $this->setVar("token", $user->getToken());
            }

            return TRUE;
        }
        return FALSE;
    }

}
