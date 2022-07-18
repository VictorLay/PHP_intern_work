<?php

require_once "./controller/command/CreatePageCommand.php";
require_once "./controller/command/error/PageNotFoundCommand.php";
require_once "./controller/command/UpdateUserCommand.php";
require_once "./controller/command/home/user_id/users/user/DeleteUserByIdPageCommand.php";
require_once "./controller/command/CreateAdminCommand.php";
require_once "./controller/command/home/SignInPageCommand.php";
require_once "./controller/command/home/HomePageCommand.php";
require_once "./controller/command/home/user_id/SignOutPageCommand.php";
require_once "./controller/command/home/user_id/profile/ProfilePageCommand.php";
require_once "./controller/command/home/user_id/users/ShowAllUsersPageCommand.php";
require_once "./controller/command/home/user_id/users/user/ShowUserProfileCommand.php";
require_once "./controller/command/home/user_id/users/user/UserUpdatePageCommand.php";
require_once "./controller/command/home/user_id/profile/UpdateSignedUserPageCommand.php";

class CommandProvider
{

    private static array $command_array = array();
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

        self::$command_array["new-admin"] = ["command" => new CreateAdminCommand()];

        self::$command_array[HOME_URI] =
            [
            "command" => new HomePageCommand(),
            USER_NICKNAME_URI => [
                "command" => 5,
                PROFILE_URI => [
                    "command" => new ProfilePageCommand(),
                    UPDATE_URI => [
                        "command" => new UpdateSignedUserPageCommand()
                    ]
                ],
                USERS_URI => [
                    "command" => new ShowAllUsersPageCommand(),
                    USER_URI => [
                        DELETE_URI => [
                            "command" => new DeleteUserByIdPageCommand()
                        ],
                        "command" => new ShowUserProfileCommand(),
                        UPDATE_URI =>[
                            "command" => new UserUpdatePageCommand()
                        ]
                    ]
                ],
                CREATE_URI => [
                    "command"=> new CreatePageCommand()
                ],
                LOGOUT_URI => [
                    "command" => new SignOutPageCommand()
                ]
            ],
            LOGIN_URI => [
                "command" => new SignInPageCommand()
            ]

        ];

        self::$command_array["profile"] = ["command" => new ProfilePageCommand()];

    }

    public static function getCommand($uri): Command
    {
        if (self::$notInit) {
            self::init();
        }
        $parseUri = explode('/', $uri);
        $parseUri[] = "command";


        $command = self::readNeedl($parseUri, self::$command_array);
        self::$logger->log($command::class, DEBUG_LEVEL);
        return $command;

    }


    public static function readNeedl(array $ur, array $commandArray, int $i = 1): Command
    {
        $name = $ur[$i];
        //если введён ид то проверяем, что пользователь залогинен иначе 404
        //добавить в проверку урл которые не должны быть доступны только у пользователя && $name != "login"
        if ($i == 2 && count($ur) != 3 && $name != "login") {
            $userId = $name;
            if (key_exists('user', $_SESSION)) {
                /** @var User $userFromSession */
                $userFromSession = $_SESSION['user'];
                if ($userId == $userFromSession->getId()) {
                    echo $userFromSession->getId() . "=ses\n";
                    // проверка случая когда кроме ид далее ничего не следует 4= если после вик лэй указан только мэил и ошибчный урл на 2 урай
                    if (($i + 2) == count($ur) /*&& array_key_exists($i+1, $ur)*/) {
                        Router::redirect(PROFILE_PAGE);
                    }

                    $i++;
                    $name = $ur[$i];
                    $commandArray = $commandArray['user'];
                    echo "$i\n";
                } else {
                    return new PageNotFoundCommand();
                }

            } else {
                return new PageNotFoundCommand();
            }
        }
        // проверка на валидность вводимую ид пользователя пройдена
        //если ключа вводимого урла не существует, то

        if (!array_key_exists($name, $commandArray)) {
            return new PageNotFoundCommand();
        }
        // +1 из-за смещения индекса массива +1 из-за добавления "команд"
        if (count($ur) > ($i + 1)) {
            return self::readNeedl($ur, $commandArray[$name], ++$i);
        }
        return $commandArray[$name];

    }


}