<?php

namespace app\core\utils\validator;

use app\core\entities\Entity;
use app\users\entities\User;
use app\core\utils\logger\Logger;

class UserValidator
{

    public static function isValid(Entity $entity): bool
    {
        //todo Не использовать глобальные переменные в утилитных методах/ Переделать при наличии времени
        // Сильная привязка кода контроллера к реализции метода
        /** @var User $entity */
        $name = $entity->getName();
        $role = $entity->getRole();
        $country = $entity->getCountry();
        $email = $entity->getEmail();
        $path = $entity->getAvatarPath();
        $isValidName = self::isValidString($name);
        $isValidRole = self::isValidString($role);
        $isValidCountry = self::isValidString($country);
        $isValidEmail = self::isValidMail($email);
        $isValidPath = self::isValidPath($path);

        $logger = Logger::getLogger();
        $logger->log( '$isValidName = '.$isValidName.'$isValidRole = '.$isValidRole.'$isValidCountry = '.$isValidCountry.'$isValidEmail = '.$isValidEmail.'$isValidPath = '.$isValidPath,DEBUG_LEVEL);
        $logger->log("isValidPath = ".$isValidPath, DEBUG_LEVEL);
        $validationResponse = ($isValidName?'':"The name '$name' isn't valid.<br>").
            ($isValidCountry?'':"The country '$country' isn't valid.<br>").
            ($isValidEmail?'':"The email '$email' isn't valid.<br>").
            ($isValidPath?'':"The email '$path' isn't valid.<br>");

        $_SESSION['validator_response'] = $validationResponse;
        $logger->log("$validationResponse" ,DEBUG_LEVEL);
//        return true;
        return $isValidName && $isValidCountry && $isValidRole && $isValidEmail && $isValidPath;
    }



    public static function isValidString(?string $field):bool{
        if (is_null($field)){
            return false;
        }
        $isValid = !(preg_match('/^\s*$/',$field));
        $isValid &= preg_match("/.{3,45}/", $field);

        $isValid &= !(preg_match("/[\d!@'\"#$%\^&*)(+=\/\\\|}{;.?]+/", $field));

        return $isValid;
    }


    public static function isValidPath(?string $field):bool{
        if (is_null($field)){
            return false;
        }
        $logger = Logger::getLogger();

        $isValid = !preg_match('/^\s*$/',$field);
        $logger->log("path $isValid", DEBUG_LEVEL);
        $isValid &= preg_match("/.{1,45}/", $field);
        $logger->log("path $isValid", DEBUG_LEVEL);
//        $isValid &= preg_match("/^\.\/resources\/\w+\.(jpg|png|jpeg)$/", $field);
        $isValid &= preg_match("/\.(jpg|png|jpeg)$/", $field);
        $logger->log("path $isValid", DEBUG_LEVEL);

        return $isValid;
    }

    public static function isValidMail(string $mail):bool{
        $isValid = preg_match('/^[^.0-9\-][.a-zA-Z\\\а-яА-Я%&*+\-\/$!#=?^_`0-9}{|~]{1,45}@[а-яa-z]{3,45}\.(
ac|ad|ae|af|ag|ai|al|am|an|ao|aq|ar|as|at|au|aw|ax|az|ba|bb|bd|be|bf|bg|bh|bi|bj|bm|bn|bo|br|bs|bt|bv|bw|by|бел|bz|ca
|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|cr|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|ee|eg|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd
|ge|gf|gg|gh|gi|gl|gm|gn|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|im|in|io|iq|ir|is|it|je|jm|jo|jp|ke|kg|kh
|ki|km|kn|kp|kr|kd|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|me|mg|mh|mk|ml|mm|mn|мон|mo|mp|mq|mr|ms|mt|mu|mv
|mw|mx|my|mz|na|nc|ne|nf|ng|ni|nl|no|np|nr|nu|nz|om|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|ps|pt|pw|py|qa|re|ro|rs|срб|ru|рф|rw
|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tl|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug
|uk|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|xk|ye|yt|yu|za|zm|zw)\.{0}/', $mail);
//        $isValid = preg_match('/^.{3,}@[a-z]{3,}\.(ru|en|by|pol|com)$/', $mail);
        return $isValid && preg_match("/^.{10,45}$/",$mail);
    }

}