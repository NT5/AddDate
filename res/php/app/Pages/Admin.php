<?php

namespace AddDate\Pages;

/**
 * 
 */
class Admin extends \AddDate\Pages\Page {

    /**
     *
     * @var type 
     */
    protected $Area;

    /**
     * 
     * @param \AddDate\Factory\AddDateComponents $AddDateComponents
     */
    public function __construct(\AddDate\Factory\AddDateComponents $AddDateComponents = NULL) {
        parent::__construct($AddDateComponents);

        $this->Area = filter_input(INPUT_GET, 's');
        switch ($this->Area) {
            case 'login':
                switch ($this->checkPostLogin()) {
                    case TRUE:
                        $this->setTemplate('pages/admin/login/done.twig');
                        $this->setVar('page_title', ' - Sesión iniciada');
                        break;
                    case NULL:
                    case FALSE:
                        $this->setTemplate('pages/admin/login/login.twig');
                        $this->setVar('page_title', ' - Iniciar sesión');
                        break;
                }
                break;
            case 'logout':
                $this->setTemplate('pages/admin/logout/logout.twig');
                $this->setVar('page_title', ' - Sesión cerrada');
                if ($this->getCookies()->getCookie("session")) {
                    $this->setVar('is_logged', true);
                    $this->getUsers()->getUserSessionClass()->deleteToken($this->getCookies()->getCookie("session"));
                    $this->getCookies()->delCookie("session");
                }
                break;
            default:
                $user = $this->getUsers()->getUserSessionClass()->getUser($this->getCookies()->getCookie('session'));
                if ($user) {
                    $this->checkPostAdmin($user);
                    $this->setTemplate('pages/admin/admin.twig');
                    $this->setVar('page_title', ' - Área de administración');
                    $this->setVars([
                        'area' => $this->Area,
                        'calendars_list' => $this->getCalendars()->getCalendars(),
                        'careers_list' => $this->getCareers()->getCareers(),
                        'lessons_list' => $this->getLessons()->getLessons(),
                        'users_list' => $this->getUsers()->getUsers()
                    ]);
                } else {
                    $this->setTemplate('pages/admin/login/login.twig');
                    $this->setVar('page_title', ' - Iniciar sesión');
                }
                break;
        }
    }

    /**
     *
     */
    private function checkPostAdmin($user) {
        $POST = filter_input_array(INPUT_POST);
        if ($POST) {
            $this->checkPostCalendar($POST, $user);

            $this->checkPostCareer($POST, $user);

            $this->checkPostLesson($POST, $user);

            $this->checkPostUser($POST, $user);
        }
    }

    /**
     * 
     * @param type $post
     * @param type $user
     */
    private function checkPostCalendar($post, $user) {
        $require = [
            "calendar_block",
            "calendar_lesson",
            "calendar_dodate",
            "calendar_reprogrammingdate",
            "calendar_specialdate",
            "calendar_careerId",
            "calendar_observations"
        ];
        if (\AddDate\Util\Functions::checkArray($require, $post)) {
            $data = [];
            $max = count($post['calendar_block']);
            for ($i = 0; $i < $max; $i++) {
                $data[] = [
                    "lesson_id" => $post['calendar_lesson'][$i],
                    "block_id" => $post['calendar_block'][$i],
                    "do_date" => $post['calendar_dodate'][$i],
                    "reprogramming_date" => $post['calendar_reprogrammingdate'][$i],
                    "special_date" => $post['calendar_specialdate'][$i]
                ];
            }
            $this->getCalendars()->insertCalendar($user, $post['calendar_careerId'], $post['calendar_observations'], $data);
        }

        $require_delete = ["delete_calendar"];
        if (\AddDate\Util\Functions::checkArray($require_delete, $post)) {
            $this->getCalendars()->deleteCalendar($post["delete_calendar"]);
        }
    }

    /**
     * 
     * @param type $post
     * @param type $user
     */
    private function checkPostCareer($post, $user) {
        $require = ["career_name"];
        if (\AddDate\Util\Functions::checkArray($require, $post)) {
            $this->getCareers()->insertCareer($post["career_name"], $user);
        }

        $require_delete = ["delete_career"];
        if (\AddDate\Util\Functions::checkArray($require_delete, $post)) {
            $this->getCareers()->deleteCareer($post["delete_career"]);
        }
    }

    /**
     * 
     * @param type $post
     * @param type $user
     */
    private function checkPostLesson($post, $user) {
        $require = ["lesson_name"];
        if (\AddDate\Util\Functions::checkArray($require, $post)) {
            $this->getLessons()->insertLesson($post["lesson_name"], $user);
        }

        $require_delete = ["delete_lesson"];
        if (\AddDate\Util\Functions::checkArray($require_delete, $post)) {
            $this->getLessons()->deleteLesson($post["delete_lesson"]);
        }
    }

    /**
     * 
     * @param type $post
     * @param type $user
     */
    private function checkPostUser($post, $user) {
        $require = [
            "user_name",
            "user_email"
        ];
        if (\AddDate\Util\Functions::checkArray($require, $post)) {
            $this->getUsers()->insertUser($post["user_name"], $post["user_email"], 0, $user->getId());
        }

        $require_delte = ["delete_user"];
        if (\AddDate\Util\Functions::checkArray($require_delte, $post)) {
            $this->getUsers()->deleteUser($post["delete_user"]);
        }
    }

    /**
     * 
     * @return boolean
     */
    private function checkPostLogin() {
        $POST = filter_input_array(INPUT_POST);
        if ($POST) {
            $_require = ["token"];
            if (\AddDate\Util\Functions::checkArray($_require, $POST)) {
                $user = $this->getUsers()->getUserTokenClass()->getUser($POST['token']);
                if ($user) {
                    $token = $this->getUsers()->getUserSessionClass()->generateToken();
                    $this->getUsers()->getUserSessionClass()->insertToken($user->getId(), $token);
                    $this->getCookies()->setCookie("session", $token);
                    return TRUE;
                }
                return FALSE;
            }
        }
        return NULL;
    }

}
