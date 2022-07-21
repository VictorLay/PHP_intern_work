<?php

class RouterImpl implements Router
{

    private static array $controller_array = array();
    private static bool $notInit = true;
    private static Logger $logger;

    private function __construct()
    {
    }

    /** Данный массив инициализируется согласно правилу:
     * Второй элемент массива должен являть никнеймом пользователя
     * или исключением (прописывается в методе readNeedle)
     */

    private static function init(): void
    {
        self::$logger = Logger::getLogger("controller");

        self::$controller_array["new-admin"] = ["controller" => new CreateAdminController()];

        self::$controller_array[HOME_URI] =
            [
            "controller" => new HomePageController(),
            USER_NICKNAME_URI => [
                "controller" => 5,
                PROFILE_URI => [
                    "controller" => new ProfilePageController(),
                    UPDATE_URI => [
                        "controller" => new UpdateSignedUserPageController()
                    ]
                ],
                USERS_URI => [
                    "controller" => new ShowAllUsersPageController(),
                    USER_URI => [
                        DELETE_URI => [
                            "controller" => new DeleteUserByIdPageController()
                        ],
                        "controller" => new ShowUserProfileController(),
                        UPDATE_URI =>[
                            "controller" => new UserUpdatePageController()
                        ]
                    ]
                ],
                CREATE_URI => [
                    "controller"=> new CreatePageController()
                ],
                LOGOUT_URI => [
                    "controller" => new SignOutPageController()
                ]
            ],
            LOGIN_URI => [
                "controller" => new SignInPageController()
            ]
        ];

        self::$controller_array["profile"] = ["controller" => new ProfilePageController()];

    }

    public static function getController($uri): Controller
    {
        if (self::$notInit) {
            self::init();
        }
        $parseUri = explode('/', $uri);
        $parseUri[] = "controller";


        $controller = self::readNeedl($parseUri, self::$controller_array);
        self::$logger->log($controller::class, DEBUG_LEVEL);
        return $controller;

    }


    public static function readNeedl(array $ur, array $controllerArray, int $i = 1): Controller
    {
        $name = $ur[$i];
        self::$logger->log($name,DEBUG_LEVEL);
        //если введён ид то проверяем, что пользователь залогинен иначе 404
        //добавить в проверку урл которые не должны быть доступны только у пользователя && $name != "login"
        if ($i == 2 && count($ur) != 3 && $name != "login") {
            $userId = $name;
            if (key_exists('user', $_SESSION)) {
                /** @var User $userFromSession */
                $userFromSession = $_SESSION['user'];
                if ($userId == $userFromSession->getId()) {
                    // проверка случая когда кроме ид далее ничего не следует 4= если после вик лэй указан только мэил и ошибчный урл на 2 урай
                    if (($i + 2) == count($ur) /*&& array_key_exists($i+1, $ur)*/) {
                        Router::redirect(PROFILE_PAGE);
                    }

                    $i++;
                    $name = $ur[$i];
                    $controllerArray = $controllerArray['user'];
                    echo "$i\n";
                } else {
                    return new PageNotFoundController();
                }

            } else {
                return new PageNotFoundController();
            }
        }
        // проверка на валидность вводимую ид пользователя пройдена
        //если ключа вводимого урла не существует, то

        if (!array_key_exists($name, $controllerArray)) {
            return new PageNotFoundController();
        }
        // +1 из-за смещения индекса массива +1 из-за добавления "команд"
        if (count($ur) > ($i + 1)) {
            return self::readNeedl($ur, $controllerArray[$name], ++$i);
        }
        return $controllerArray[$name];

    }


}