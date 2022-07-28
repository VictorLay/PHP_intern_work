<?php

namespace app\users\views;


use app\users\entities\User;
use app\users\views\html\ShowUsersHtml;

class HtmlUserPageWriter extends ShowUsersHtml
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


    public static function writeCreateUserHtmlForm(): void
    {
        $createUserUrl = CREATE_USER_PAGE;
        if (key_exists("not_valid_user_data", $_SESSION)) {
            /** @var User $notValidUser */
            $notValidUser = $_SESSION["not_valid_user_data"];
            echo "<div>" . $_SESSION['validator_response'] . "</div>
       <form action='$createUserUrl' method='post'><br/>
            <input type='text' name='user_email' value='" . $notValidUser->getEmail() . "'/><br/>
            <input type='text' name='user_country' value='" . $notValidUser->getCountry() . "'/><br/>
            <input type='text' name='user_name' value='" . $notValidUser->getName() . "'/><br/>
            <input type='submit' value='create new User'/><br/><br/>
            
            <input type='hidden' name='command' value='create'/>
        </form>
        ";
        } else {
            echo "
       <form action='$createUserUrl' method='post'><br/>
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
        $HOME_PAGE = HOME_PAGE;

        $userName = $user->getName();
        $userCountry = $user->getCountry();
        $userEmail = $user->getEmail();
        $userAvatarPath = stristr($user->getAvatarPath(), "/");
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
                <form method='post' enctype='multipart/form-data'><br/>
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

    public static function writeSignedUserUpdateForm(User $user): void
    {


        $HOME_PAGE = HOME_PAGE;

        $userName = $user->getName();
        $userCountry = $user->getCountry();
        $userEmail = $user->getEmail();
        $userAvatarPath = stristr($user->getAvatarPath(), "/");
        $userId = $user->getId();
        $UPDATE_USER_PAGE = SHOW_ALL_USERS_PAGE . "/". $userId . UPDATE_URN;

        echo "
                <form action='$UPDATE_USER_PAGE' method='post' enctype='multipart/form-data'><br/>
                    <input type='text' name='user_email' value='$userEmail'/><br/>
                    <input type='text' name='user_country' value='$userCountry'/><br/>
                    <input type='text' name='user_name' value='$userName'/><br/>
                    <input type='hidden' name='user_id' value='$userId'/><br/>
                    <img src='$userAvatarPath' width=70 height=70/>
                    <input type='file' name='picture' accept='image/*'/>
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


    public static function writeCreateUserButton(): void
    {
        echo "
        <form action='" . CREATE_USER_PAGE . "' method='post'>
            <input type='submit' value='create User'/>
        </form>
        ";
    }


}