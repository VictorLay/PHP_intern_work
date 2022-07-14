<?php
require_once "./bean/User.php";
require_once "./resources/conf_const.php";

class HtmlPageWriter
{

    public static function writeUserInfo(User $user): void
    {
        echo "<div>
<h2>Hello " . $user->getName() . " from " . $user->getCountry() . "</h2>
<h4>You have " . $user->getRole() . " permission</h4>
</div>";
    }

    public static function writeAllUsers(array $users): void
    {
        $usersWrite = "";
        /** @var User $userInfo */
        foreach ($users as $userInfo) {
            $usersWrite .= "<tr>" . $userInfo . "</tr>";
        }
        echo
            "<!DOCTYPE html>
                <html>
                <head>
                
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
                        <th>id</th>
                        <th>email</th>
                        <th>country</th>
                        <th>name</th>
                        <th>role</th>
                      </tr>" . $usersWrite . "
                    </table>
                
                </body>
                </html>";
    }

    public static function writeAllUsersForAdmin(array $users, int $pageQuantity): void
    {


        $usersWrite = "";
        /** @var User $userInfo */
        foreach ($users as $userInfo) {
            $usersWrite .= "<tr><td><img src='" . $userInfo->getAvatarPath() . "' width=30 height=30 ></td>";
            $usersWrite .= $userInfo;
            $usersWrite .= "<td><form action='".UPDATE_USER_PAGE."' method='post'>
<input type='hidden' value='" . $userInfo->getName() . "' name='user_name'>
<input type='hidden' value='" . $userInfo->getEmail() . "' name='user_email'>
<input type='hidden' value='" . $userInfo->getCountry() . "' name='user_country'>
<input type='hidden' value='" . $userInfo->getRole() . "' name='user_role'>
<input type='hidden' value='" . $userInfo->getId() . "' name='user_id'>
<input type='hidden' value='update_user_by_id_page' name='command'>
<input type='hidden' value='" . $userInfo->getAvatarPath() . "' name='user_path'>
<input type='submit' value='update'>
</form></td>";

            if (key_exists("user", $_SESSION)) {
                /** @var User $signedUser */
                $signedUser = $_SESSION['user'];
                if ($userInfo->getId() != $signedUser->getId()) {
                    $usersWrite .= "<td><form action='".DELETE_USER_PAGE."' method='post'>
<input type='hidden' value='" . $userInfo->getId() . "' name='user_id'>
<input type='hidden' value='delete_user_by_id_page' name='command'>
<input type='submit' value='delete'>
</form></td></tr>";
                }

            }
        }

        echo
            "<head>
                
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
                        <th>update</th>
                        <th>delete</th>
                      </tr>" . $usersWrite . "
                    </table>";


//        echo "<div>";
//        for ($i = 1; $i <= $pageQuantity; $i++)
//            echo "<a href='/?page=$i'>$i</a> ";
//        echo "</div>";


        if (!key_exists('page', $_GET)) {
            $_GET['page'] = 1;
        }

        echo "<form action='".HOME_PAGE."' method='get'>";

        echo "
<a href='".HOME_PAGE."?page=1'>1</a> ...
<a href='".HOME_PAGE."?page=" . $pageQuantity . "'>" . $pageQuantity . "</a>";

        echo "
            <input type='text' name='page' placeholder='" . $_GET['page'] . "'/>
            <input type='submit' value='перейти'/>
</form>
</body>";


    }

    public static function writeAllUsersForUser(array $users, int $pageQuantity): void
    {
        $usersWrite = "";
        /** @var User $userInfo */
        foreach ($users as $userInfo) {
            $usersWrite .= "<tr><td><img src='" . $userInfo->getAvatarPath() . "' width=30 height=30 ></td>";
            $usersWrite .= $userInfo . "</tr>";
        }

        echo
            "<!DOCTYPE html>
                <html>
                <head>
                
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
                        <th>id</th>
                        <th>email</th>
                        <th>country</th>
                        <th>name</th>
                        <th>role</th>
                        <th>avatar</th>
                      </tr>" . $usersWrite . "
                    </table>
                
                </body>
                </html>";


        echo "<div>";
        for ($i = 1; $i <= $pageQuantity; $i++)
            echo "<a href='/?page=$i'>$i</a> ";
        echo "</div>";


    }

    public static function writeCreateUserHtmlForm(): void
    {

        if (key_exists("not_valid_user_data", $_SESSION)) {
            /** @var User $notValidUser */
            $notValidUser = $_SESSION["not_valid_user_data"];
            echo "<div>" . $_SESSION['validator_response'] . "</div>
       <form action='".CREATE_USER."' method='post'><br/>
            <input type='text' name='user_email' value='" . $notValidUser->getEmail() . "'/><br/>
            <input type='text' name='user_country' value='" . $notValidUser->getCountry() . "'/><br/>
            <input type='text' name='user_name' value='" . $notValidUser->getName() . "'/><br/>
            <input type='submit' value='create new User'/><br/><br/>
            
            <input type='hidden' name='command' value='create'/>
        </form>
        ";
        } else {
            echo "
       <form action='".CREATE_USER."' method='post'><br/>
            <input type='text' name='user_email' placeholder='email'/><br/>
            <input type='text' name='user_country' placeholder='country'/><br/>
            <input type='text' name='user_name' placeholder='name'/><br/>
            <input type='submit' value='create new User'/><br/><br/>
            
            <input type='hidden' name='command' value='create'/>
        </form>";
        }

        echo "<br><form action='".HOME_PAGE."' method='post'><input type='submit' value='cancel'></form>";

    }

    public static function writeUpdateUserHtmlForm(User $user): void
    {
        if (key_exists("not_valid_user_data", $_SESSION)) {
            /** @var User $notValidUser */
//            $notValidUser = $_SESSION["not_valid_user_data"];
            echo "<div>" . $_SESSION['validator_response'] . "</div>";
        }


        echo "
       <form action='".UPDATE_USER."' method='post' enctype='multipart/form-data'><br/>
            <input type='text' name='user_email' value='" . $user->getEmail() . "'/><br/>
            <input type='text' name='user_country' value='" . $user->getCountry() . "'/><br/>
            <input type='text' name='user_name' value='" . $user->getName() . "'/><br/>";
        switch ($user->getRole()) {
            case "admin":
                echo "<input type='radio' name='user_role' value='admin' checked/>admin<br/>
                      <input type='radio' name='user_role'  value='user'  />user<br/>";
                break;
            case "user":
                echo "  <input type='radio' name='user_role' value='admin' />admin<br/>
                        <input type='radio' name='user_role'  value='user' checked/>user<br/>";
                break;
        }
        echo "<img src='" . $user->getAvatarPath() . "' width=70 height=70/>";
        echo "  
                <input name='picture' type='file' />
                <input type='hidden' name='command' value='update_user_by_id'/>
                <input type='hidden' name='user_id' value='" . $user->getId() . "'/>
                <input type='hidden' name='user_path' value='" . $user->getAvatarPath() . "'/>
                <input type='submit' value='update write'/><br/><br/>
        </form>";
        echo "<br><form action='".HOME_PAGE."' method='post'><input type='submit' value='cancel'></form>";


    }

    public static function writeDeleteUserHtmlForm(int $id): void
    {
        var_dump($id);
        echo "
       <form action='".DELETE_USER."' method='post'><br/>
            <input type='hidden' name='user_id_for_deleting' value='" . $id . "'/><br/>
            <input type='submit' value='delete user'/><br/><br/>      
            <input type='hidden' name='command' value='delete_user_by_id'/> </form>
            
       <form action='".HOME_PAGE."' method='post'><br/>
            <input type='submit' value='cancel'/><br/><br/>
            <input type='hidden' name='command' value='default'/>
     </form>
            ";
    }

    public static function writeSignInButton(): void
    {
        echo "
       <form action='".LOGIN_PAGE."' method='post'><br/>
            <input type='submit' value='sign user'/><br/><br/>
            <input type='hidden' name='command' value='sign_in_page'/>
        </form>";
    }

    public static function writeCreateUserButton(): void
    {
        echo "
        <form action='".CREATE_USER_PAGE."' method='post'>
        
        <input type='hidden' name='command' value='create_page'/>
        <input type='submit' value='create User'/>
        
</form>
        ";
    }

    public static function writeSignInForm(): void
    {
        echo "
       <form action='".LOGIN."' method='post'><br/>
            <input type='text' name='mail' placeholder='mail'/><br/>
            <input type='text' name='password' placeholder='password'/><br/>
            <input type='submit' value='sign user'/><br/><br/>
            <input type='hidden' name='command' value='sign_in'/>
        </form>";
    }

    public static function writeSignOutUserForm(): void
    {
        echo "
       <form action='".LOGOUT_PAGE."' method='post'><br/>
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
        <form action='".LOGOUT."' method='post'>
        <input type='hidden' name='command' value='sign_out'><br/>
        <input type='submit' value='YES' >
        </form>
        <form action='".HOME_PAGE."' method='post'>
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
    <!--<img src="https://thumbs.dreamstime.com/b/%D0%B1%D0%B5%D0%BB%D1%8B%D0%B9-%D1%87%D0%B5%D0%BB%D0%BE%D0%B2%D0%B5%D0%BA-d-%D0%B8-%D0%BE%D1%88%D0%B8%D0%B1%D0%BA%D0%B0-%D0%B2%D1%8B%D0%B7%D1%8B%D0%B2%D0%B0%D1%8E%D1%82-%D0%BD%D0%B5-%D0%BD%D0%B0%D0%B9%D0%B4%D0%B5%D0%BD%D0%BD%D1%8B%D0%B9-106883272.jpg" width=1080 height=500>
 -->   <img src="http://localhost/resources/404.jpg" width=1080 height=500>
    <p>please don\'t fire the developer. © 2022</p>
</div>
</body>';
    }
}