<?php



class DeleteHtml extends AuthenticationHtml
{
    public static function writeDeleteUserHtmlForm(int $id): void
    {
        $DELETE_USER_PAGE = DELETE_USER_PAGE;
        $HOME_PAGE = HOME_PAGE;
        echo "<h2>Do you want to delete user with id $id</h2>
       <form action='$DELETE_USER_PAGE' method='post'><br/>
            <input type='hidden' name='user_id' value='$id'/><br/>
            <input type='submit' value='delete user'/><br/><br/>      
       </form>
       <form action='$HOME_PAGE' method='post'><br/>
            <input type='submit' value='cancel'/><br/><br/>
       </form>";
    }
}