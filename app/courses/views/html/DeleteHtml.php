<?php

namespace app\courses\views\html;

use Course;

class DeleteHtml
{
    public static function writeDeleteWarning(Course $course): void
    {
        $deleteCoursePageUrl = SHOW_USER_COURSES . "/" . $course->getId() . DELETE_URN;
        $showUserCourseUrl = SHOW_USER_COURSES . "/" . $course->getId();
        $courseTitle = $course->getTitle();


        echo "Вы действительно хотите удалить курс: 
            <h2>\"$courseTitle\"</h2><br>
            <form action='$deleteCoursePageUrl' method='post'>
                <input type='submit' value='YES'>
            </form>
            <form action='$showUserCourseUrl' method='post'>
                <input type='submit' value='NO'>
            </form>
            <div style='min-height: 50px; background-color: black'></div><br>
            ";

    }
}