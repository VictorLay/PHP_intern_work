<?php

class UserInterpreter
{

    // for admin
    public static function parseUserToTable(User $user): string
    {
        $userAvatarPath = stristr($user->getAvatarPath(), "/");
        $userId = $user->getId();
        $userEmail = $user->getEmail();
        $userCountry = $user->getCountry();
        $userName = $user->getName();
        $userRole = $user->getRole();
        $SHOW_USER_PAGE = SHOW_USER_PAGE;

        return
            "<td><img src='$userAvatarPath' width='70' height='70' ></td> \n
            <td>$userId</td> \n
            <td><a href='$SHOW_USER_PAGE?user_id=$userId'>$userEmail</a></td> \n
            <td>$userCountry</td> \n
            <td>$userName</td> \n
            <td>$userRole</td>\n";
    }
}