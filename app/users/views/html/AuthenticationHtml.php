<?php

namespace app\users\views\html;


use app\users\entities\User;

class AuthenticationHtml extends ErrorHtml
{

    public static function writeSignInButton(): void
    {
        echo "
       <form action='" . LOGIN_PAGE . "' method='post'><br/>
            <input type='submit' value='sign user'/><br/><br/>
        </form>";
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

    public static function writeLoginForm(): void
    {
        echo "
        <form action='" . LOGIN_PAGE . "' method='post'><br/>
            <input type='text' name='mail' placeholder='mail'/><br/>
            <input type='text' name='password' placeholder='password'/><br/>
            <input type='submit' value='sign user'/><br/><br/>
            <input type='hidden' name='command' value='sign_in'/>
        </form>";
    }

    public static function writeLoginFormWithWarning(string $userEmail): void
    {
        echo "
       <div>Incorrect login or password</div>
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

    public static function writeSignOutWarning(User $user): void
    {
        $LOGOUT_PAGE = LOGOUT_PAGE;
        $HOME_PAGE = HOME_PAGE;
        echo "
        <h3> You try to sign out. <br>" . $user->getName() . ", are you sure ?</h3><br/>
        your role is {" . $user->getRole() . "}
        <br/><br/>
        <form action='$LOGOUT_PAGE' method='post'>
        <input type='hidden' name='sign_out' value='yes'><br/>
        <input type='submit' value='YES' >
        </form>        
        <br/><br/>
        <form action='$HOME_PAGE' method='get'>
        <input type='submit' value='NO' >
        </form>
        ";
    }
}
