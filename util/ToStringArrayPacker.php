<?php
require_once "./bean/User.php";

class ToStringArrayPacker
{

    public static function packToAssociativeArray(User $user):array{
        return $userInf[] = [
            "user_id" => $user->getId(),
            "user_name" => $user->getName(),
            "user_country" => $user->getCountry(),
            "user_email" => $user->getEmail(),
            "user_avatar_path" => $user->getAvatarPath(),
            "user_role" => $user->getRole()
        ];

    }
}