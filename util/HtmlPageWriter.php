<?php
require_once "./bean/User.php";

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
            $usersWrite .= "<td><form action='/' method='post'>
<input type='hidden' value='" . $userInfo->getName() . "' name='user_name'>
<input type='hidden' value='" . $userInfo->getEmail() . "' name='user_email'>
<input type='hidden' value='" . $userInfo->getCountry() . "' name='user_country'>
<input type='hidden' value='" . $userInfo->getRole() . "' name='user_role'>
<input type='hidden' value='" . $userInfo->getId() . "' name='user_id'>
<input type='hidden' value='update_user_by_id_page' name='command'>
<input type='submit' value='update'>
</form></td>";

            if (key_exists("user", $_SESSION)) {
                /** @var User $signedUser */
                $signedUser = $_SESSION['user'];
                if ($userInfo->getId() != $signedUser->getId()) {
                    $usersWrite .= "<td><form action='/' method='post'>
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

        echo "<form action='/' method='get'>";

        echo "
<a href='/?page=1'>1</a> ...
<a href='/?page=" . $pageQuantity . "'>" . $pageQuantity . "</a>";

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
            echo "
       <form action='/' method='post'><br/>
            <input type='text' name='user_email' value='" . $notValidUser->getEmail() . "'/><br/>
            <input type='text' name='user_country' value='" . $notValidUser->getCountry() . "'/><br/>
            <input type='text' name='user_name' value='" . $notValidUser->getName() . "'/><br/>
            <input type='submit' value='create new User'/><br/><br/>
            
            <input type='hidden' name='command' value='create'/>
        </form>";
        } else {
            echo "
       <form action='/' method='post'><br/>
            <input type='text' name='user_email' placeholder='email'/><br/>
            <input type='text' name='user_country' placeholder='country'/><br/>
            <input type='text' name='user_name' placeholder='name'/><br/>
            <input type='submit' value='create new User'/><br/><br/>
            
            <input type='hidden' name='command' value='create'/>
        </form>";
        }

    }

    public static function writeUpdateUserHtmlForm(User $user): void
    {
        echo "
       <form action='/' method='post' enctype='multipart/form-data'><br/>
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
        echo "  
                <input name='picture' type='file' />
                <input type='hidden' name='command' value='update_user_by_id'/>
                <input type='hidden' name='user_id' value='" . $user->getId() . "'/>
                <input type='submit' value='update write'/><br/><br/>
        </form>";


    }

    public static function writeDeleteUserHtmlForm(int $id): void
    {
        echo "
       <form action='/' method='post'><br/>
            <input type='hidden' name='user_id_for_deleting' value='" . $id . "'/><br/>
            <input type='submit' value='delete user'/><br/><br/>      
            <input type='hidden' name='command' value='delete_user_by_id'/> </form>
            
       <form action='/' method='post'><br/>
            <input type='submit' value='cancel'/><br/><br/>
            <input type='hidden' name='command' value='default'/>
     </form>
            ";
    }

    public static function writeSignInButton(): void
    {
        echo "
       <form action='/' method='post'><br/>
            <input type='submit' value='sign user'/><br/><br/>
            <input type='hidden' name='command' value='sign_in_page'/>
        </form>";
    }

    public static function writeCreateUserButton(): void
    {
        echo "
        <form action='/' method='post'>
        
        <input type='hidden' name='command' value='create_page'/>
        <input type='submit' value='create User'/>
        
</form>
        ";
    }

    public static function writeSignInForm(): void
    {
        echo "
       <form action='index.php' method='post'><br/>
            <input type='text' name='mail' placeholder='mail'/><br/>
            <input type='text' name='password' placeholder='password'/><br/>
            <input type='submit' value='sign user'/><br/><br/>
            <input type='hidden' name='command' value='sign_in'/>
        </form>";
    }

    public static function writeSignOutUserForm(): void
    {
        echo "
       <form action='/' method='post'><br/>
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
        <form action='/' method='post'>
        <input type='hidden' name='command' value='sign_out'><br/>
        <input type='submit' value='YES' >
        </form>
        <form action='/' method='post'>
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
}