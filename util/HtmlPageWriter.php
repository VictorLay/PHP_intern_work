<?php
require_once "./bean/User.php";
require_once "./resources/conf_const.php";

class HtmlPageWriter
{

    public static function writeUserInfo(User $user): void
    {
        $userName = $user->getName();
        $country = $user->getCountry();
        $role = $user->getRole();
        echo "  <div>
                    <h2>Hello $userName from $country</h2>
                    <h4>You have $role permission</h4>
                </div>
        ";
    }


    public static function writeAllUsersForAdmin(array $users, int $pageQuantity, User $userFromSession): void
    {

        $HOME_PAGE = HOME_PAGE;
        $FIRST_PAGE = 1;
        $page = key_exists('page', $_GET) ? $_GET['page'] : $FIRST_PAGE;
        $usersWrite = self::prepareUserRowsForAdminTable($users, $userFromSession);

        echo
        "<head>
                <style>
                    table {
                      font-family: arial, sans-serif;
                      border-collapse: collapse;
                      width: 100%;
                    }
                    
                    td, th {
                      border: 1px solid #dddddd;
                      text-align: left;
                      padding: 8px;
                    }
                    
                    tr:nth-child(even) {
                      background-color: #dddddd;
                    }
                </style>
            </head>
            <body>
                <h2>HTML Table</h2>
                <table>
                  <tr>
                    <th>avatar</th>
                    <th>id</th>
                    <th>email</th>
                    <th>country</th>
                    <th>name</th>
                    <th>role</th>
                    <th>update</th>
                    <th>delete</th>
                  </tr>
                  $usersWrite
                </table>
                <form action='$HOME_PAGE' method='get'>
                    <a href='$HOME_PAGE?page=1'>1</a> ...
                    <a href='$HOME_PAGE?page=$pageQuantity'>$pageQuantity</a>
                    <input type='text' name='page' placeholder='$page'/>
                    <input type='submit' value='перейти'/>
                </form>
            </body>";
    }

    public static function writeAllUsersForUser(array $users, int $pageQuantity): void
    {
        $usersWrite = "";
        /** @var User $userInfo */
        foreach ($users as $userInfo) {
            $usersWrite .= "<tr>";
//                <td><img src='" . $userInfo->getAvatarPath() . "' width=30 height=30 ></td>";
            $usersWrite .= $userInfo . "</tr>";
        }

        echo "<head>
                
                <!-- table -->
                <style>
                table {
                  font-family: arial, sans-serif;
                  border-collapse: collapse;
                  width: 100%;
                }
                
                td, th {
                  border: 1px solid #dddddd;
                  text-align: left;
                  padding: 8px;
                }
                
                tr:nth-child(even) {
                  background-color: #dddddd;
                }
                </style>
                </head>
                <body>
                
                    <h2>HTML Table</h2>
                    
                    <table>
                      <tr>
                       
                        <th>avatar</th>
                        <th>id</th>
                        <th>email</th>
                        <th>country</th>
                        <th>name</th>
                        <th>role</th>
                      </tr>" . $usersWrite . "
                    </table>
                
                </body>
                </html>";


//        echo "<div>";
//        for ($i = 1; $i <= $pageQuantity; $i++)
//            echo "<a href='/?page=$i'>$i</a> ";
//        echo "</div>";

        if (!key_exists('page', $_GET)) {
            $_GET['page'] = 1;
        }

        echo "<form action='" . HOME_PAGE . "' method='get'>";

        echo "
<a href='" . HOME_PAGE . "?page=1'>1</a> ...
<a href='" . HOME_PAGE . "?page=" . $pageQuantity . "'>" . $pageQuantity . "</a>";

        echo "
            <input type='text' name='page' placeholder='" . $_GET['page'] . "'/>
            <input type='submit' value='перейти'/>
</form>
</body>";


    }

    public static function writeCreateUserHtmlForm(): void
    {

        if (key_exists("not_valid_user_data", $_SESSION)) {
            /** @var User $notValidUser */
            $notValidUser = $_SESSION["not_valid_user_data"];
            echo "<div>" . $_SESSION['validator_response'] . "</div>
       <form action='" . CREATE_USER . "' method='post'><br/>
            <input type='text' name='user_email' value='" . $notValidUser->getEmail() . "'/><br/>
            <input type='text' name='user_country' value='" . $notValidUser->getCountry() . "'/><br/>
            <input type='text' name='user_name' value='" . $notValidUser->getName() . "'/><br/>
            <input type='submit' value='create new User'/><br/><br/>
            
            <input type='hidden' name='command' value='create'/>
        </form>
        ";
        } else {
            echo "
       <form action='" . CREATE_USER . "' method='post'><br/>
            <input type='text' name='user_email' placeholder='email'/><br/>
            <input type='text' name='user_country' placeholder='country'/><br/>
            <input type='text' name='user_name' placeholder='name'/><br/>
            <input type='submit' value='create new User'/><br/><br/>
            
            <input type='hidden' name='command' value='create'/>
        </form>";
        }

        echo "<br><form action='" . HOME_PAGE . "' method='post'><input type='submit' value='cancel'></form>";

    }

    public static function writeUpdateUserHtmlForm(User $user, User $userFromSession): void
    {
        $UPDATE_USER_PAGE = UPDATE_USER_PAGE;
        $HOME_PAGE = HOME_PAGE;

        $userName = $user->getName();
        $userCountry = $user->getCountry();
        $userEmail = $user->getEmail();
        $userAvatarPath = $user->getAvatarPath();
        $userId = $user->getId();
        $roleRadioSelector = '';
        $imageInput = '';


        if ($userFromSession->getRole() == ADMIN) {
            switch ($user->getRole()) {
                case ADMIN:
                    $roleRadioSelector .= "
                        <input type='radio' name='user_role' value='admin' checked/>admin<br/>
                        <input type='radio' name='user_role'  value='user'  />user<br/>";
                    break;
                case USER:
                    $roleRadioSelector .= "  
                        <input type='radio' name='user_role' value='admin' />admin<br/>
                        <input type='radio' name='user_role'  value='user' checked/>user<br/>";
                    break;
            }
        }
        if ($userId == $userFromSession->getId()) {
            $imageInput = "<input type='file' name='picture' accept='image/*'/>";
        }


        echo "
                <form action='$UPDATE_USER_PAGE' method='post' enctype='multipart/form-data'><br/>
                    <input type='text' name='user_email' value='$userEmail'/><br/>
                    <input type='text' name='user_country' value='$userCountry'/><br/>
                    <input type='text' name='user_name' value='$userName'/><br/>
                    <input type='hidden' name='user_id' value='$userId'/><br/>

                    $roleRadioSelector
                    <img src='$userAvatarPath' width=70 height=70/>
                    $imageInput
                    <input type='submit' value='update write'/><br/>
                </form><br/>
                <form action='$HOME_PAGE' method='post'>
                    <input type='submit' value='cancel'/>
                </form>";


    }

    public static function writeUpdateUserHtmlFormWithWarning(User $user, User $userFromSession): void
    {

        if (key_exists("not_valid_user_data", $_SESSION)) {
            /** @var User $notValidUser */
            echo "<div>" . $_SESSION['validator_response'] . "</div>";
        }
        self::writeUpdateUserHtmlForm($user, $userFromSession);
    }

    public static function writeDeleteUserHtmlForm(int $id): void
    {
        $DELETE_USER = DELETE_USER;
        $HOME_PAGE = HOME_PAGE;
        echo "<h2>Do you want to delete user with id $id</h2>
       <form action='$DELETE_USER' method='post'><br/>
            <input type='hidden' name='user_id_for_deleting' value='$id'/><br/>
            <input type='submit' value='delete user'/><br/><br/>      
       </form>
       <form action='$HOME_PAGE' method='post'><br/>
            <input type='submit' value='cancel'/><br/><br/>
       </form>";
    }

    public static function writeSignInButton(): void
    {
        echo "
       <form action='" . LOGIN_PAGE . "' method='post'><br/>
            <input type='submit' value='sign user'/><br/><br/>
        </form>";
    }

    public static function writeCreateUserButton(): void
    {
        echo "
        <form action='" . CREATE_USER_PAGE . "' method='post'>
        
        <input type='hidden' name='command' value='create_page'/>
        <input type='submit' value='create User'/>
        
</form>
        ";
    }

    public static function writeSignInForm(?string $userEmail): void
    {
        $loginWarning = is_null($userEmail) ? '' : "<div>Incorrect login or password</div>";
        echo "
        $loginWarning
        <form action='" . LOGIN_PAGE . "' method='post'><br/>
            <input type='text' name='mail' placeholder='mail' value='$userEmail'/><br/>
            <input type='text' name='password' placeholder='password'/><br/>
            <input type='submit' value='sign user'/><br/><br/>
            <input type='hidden' name='command' value='sign_in'/>
        </form>";
    }

    public static function writeSignOutUserForm(): void
    {
        echo "
       <form action='" . LOGOUT_PAGE . "' method='post'><br/>
            <input type='submit' value='sign out user'/><br/><br/>
            <input type='hidden' name='command' value='sign_out_page'/>
        </form>";
    }

    public static function writeSignOutWarning(): void
    {
        /** @var User $user */
        $user = $_SESSION['user'];
        echo "
        <h3> You try to sign out. <br>" . $user->getName() . ", are you sure ?</h3><br/>
        your role is {" . $user->getRole() . "}
        <br/><br/>
        <form action='" . LOGOUT . "' method='post'>
        <input type='hidden' name='command' value='sign_out'><br/>
        <input type='submit' value='YES' >
        </form>
        <form action='" . HOME_PAGE . "' method='post'>
        <input type='hidden' name='command' value='default'><br/><br/>
        <input type='submit' value='NO' >
        </form>
        ";
    }

    public static function writeSignInFormWithAuthorizationWarning(): void
    {
        echo "<h3>Incorrect login or password</h3>";
        self::writeSignInForm();

    }

    public static function writeAccessDeniedHTML(): void
    {
        echo "<h1>Access was denied!<br><a href='/home'>HOME</a></h1>";
    }

    public static function write404ErrorPage(): void
    {
        echo '<head>
    <meta name="robots" content="noindex,nofollow">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>404 Page Not Found</title>
    <link href="/templates/Default/css/styles.css" rel="stylesheet">
    <style>
        body {align-items: center;background-color: #f5f5f5;display: flex;height: 100vh;justify-content: center;margin: 0;}
        .container {text-align: center;}
        .container h1 {font-size: 8rem;letter-spacing: 10px;margin: 0;}
        .container h4 {font-size: 1.25rem;font-weight: 300;}
    </style>
</head>
<body>
<div class="container">
    <h1>404</h1>
    <h2>Мы не можем найти страницу, которую вы ищете.</h2>
    <h4>Страница, которую вы запросили, не найдена в базе данных.<br> Скорее всего вы попали на битую ссылку или опечатались при вводе URL</h4>
    <p class="box_in"><a href="/home">Перейти на главную страницу</a></p>
 -->   <img src="http://localhost/resources/404.jpg" width=1080 height=500>
    <p>please don\'t fire the developer. © 2022</p>
</div>
</body>';
    }


    public static function writeUserProfile(User $user): void
    {
        $HOME_PAGE = HOME_PAGE;
        $UPDATE_USER_PAGE = UPDATE_USER_PAGE;
        $userId = $user->getId();

        $userWrite = strval($user);
        $userWrite .= "<td>
                         <form action='$UPDATE_USER_PAGE' method='post'>
                           <input type='hidden' value='$userId' name='user_id'>
                           <input type='submit' value='update'>
                         </form>
                       </td>";
        echo "<head>
                
                <style>
                table {
                  font-family: arial, sans-serif;
                  border-collapse: collapse;
                  width: 100%;
                }
                
                td, th {
                  border: 1px solid #dddddd;
                  text-align: left;
                  padding: 8px;
                }
                
                tr:nth-child(even) {
                  background-color: #dddddd;
                }
                </style>
                </head>
                <body>
                
                    <h2>Profile</h2>
                    <a href='$HOME_PAGE'>HOME</a>
                    <table>
                      <tr>
                        <th>avatar</th>
                        <th>id</th>
                        <th>email</th>
                        <th>country</th>
                        <th>name</th>
                        <th>role</th>
                        <th>Update</th>
                      </tr>
                      <tr>
                        $userWrite 
                      </tr>  
                    </table>
                </body>";
    }

    public static function writeProfileButton(): void
    {
        echo "<h2><a href='" . PROFILE_PAGE . "'>Your profile</a></h2>";
    }


    private static function prepareUserRowsForAdminTable(array $users, User $userFromSession): string
    {
        $UPDATE_USER_PAGE = UPDATE_USER_PAGE;
        $DELETE_USER_PAGE = DELETE_USER_PAGE;
        $usersWrite = "";
        /** @var User $user */
        foreach ($users as $user) {
            $userRole = $user->getRole();
            $userId = $user->getId();
            $userAvatarPath = $user->getAvatarPath();
            $usersWrite .= $user;
            if ($userRole != ADMIN || $userFromSession->getId() == $userId) {
                $usersWrite .= "<td>
                                    <form action='$UPDATE_USER_PAGE' method='post'>
                                        <input type='hidden' value='$userId' name='user_id'>
                                        <input type='hidden' value='$userAvatarPath' name='user_path'>
                                        <input type='submit' value='update'>
                                    </form>
                                </td>";
            } else {
                $usersWrite .= "<td></td>";
            }

            if ($userId != $userFromSession->getId() && $userRole != ADMIN) {
                $usersWrite .= "<td>
                                        <form action='$DELETE_USER_PAGE' method='post'>
                                            <input type='hidden' value='$userId' name='user_id'>
                                            <input type='submit' value='delete'>
                                        </form>
                                    </td>
                                </tr>";
            } else {
                $usersWrite .= "<td></td></tr>";
            }
        }
        return $usersWrite;
    }
}