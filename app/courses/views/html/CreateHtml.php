<?php

class CreateHtml extends ReadHtml
{
    public static function writeCreateCourseForm(): void
    {
        $createUrl = SHOW_USER_COURSES . CREATE_URN;
        echo "
        <form action='$createUrl' method='post'>
            <input style='min-width: 800px' type='text' placeholder='Введите название курса' name='course_title'/>
            <input type='submit' value='создать новый курс'/>
        </form>
        
        ";
    }

}