<?php

namespace app\courses\views\html;


use app\courses\entities\Course;
use app\users\entities\User;

class ReadHtml extends UpdateHtml
{
    public static function writeCoursesPage(array $courses): void
    {
        /** @var Course $course */
        foreach ($courses as $course){
            self::writeCoursePage($course);
            echo "<div style='min-height: 50px; background-color: black'></div><br>";
        }

    }

    public static function writeCoursePage(Course $course): void
    {
        /** @var User $userFromSession */
        $userFromSession = $_SESSION['user'];
        $userAuthorId = $userFromSession->getId();
        $isOwner = $userAuthorId == $course->getAuthorId();
        $title = $course->getTitle();
        $content = $course->getContent();
        $texts = $content->getTexts();
        $videoLinks = $content->getLinksToTheVideos();
        $articleLinks = $content->getLinksToTheArticles();

        echo "<h2>$title 'id = {$course->getId()}'</h2>";

        foreach ($texts as $text) {
            echo "
            <div>
            <h5>Text:</h5>
            <pre style=' font-size: large '>$text</pre>
            </div>
        <br/>
        ";
        }
        foreach ($videoLinks as $videoLink) {
            echo "
        <div>
            <h5>Viedeo link:</h5>

            <a href='https://www.google.com/webhp?q=$videoLink'>
                $videoLink
            </a>
        </div><br/>
        ";
        }
        foreach ($articleLinks as $articleLink) {
            echo "
        <div>
            <h5>Article link:</h5>

            <a href='https://www.google.com/webhp?q=$articleLink'>
                $articleLink
            </a>
        </div><br/>
        ";
        }

        if ($isOwner){
            echo "
            <a href='".SHOW_USER_COURSES."/".$course->getId().DELETE_URN."'>DELETE</a><br>
            <a href='".SHOW_USER_COURSES."/".$course->getId().UPDATE_URN."'>UPDATE</a>
            ";
        }


        echo " <br/>End of course<br/><br/>";


    }

    public static function writeDeletedCoursesPage(array $courses): void
    {
        echo "<h2>Список удалённых курсов пользователя:</h2>";
        if (empty($courses)){
            echo "Удалённых курсов у Вас нет.";
        }
        /** @var Course $course */
        foreach ($courses as $course){
            self::writeDeletedCoursePage($course);
            echo "<div style='min-height: 30px; background-color: black'></div><br>";
        }

    }

    public static function writeDeletedCoursePage(Course $course): void
    {
        $title = $course->getTitle();
        $content = $course->getContent();
        $texts = $content->getTexts();
        $videoLinks = $content->getLinksToTheVideos();
        $articleLinks = $content->getLinksToTheArticles();

        echo "<h2>$title 'id = {$course->getId()}'</h2>";

        foreach ($texts as $text) {
            echo "
            <div>
            <h5>Text:</h5>
            <pre style=' font-size: large '>$text</pre>
            </div>
        <br/>
        ";
        }
        foreach ($videoLinks as $videoLink) {
            echo "
        <div>
            <h5>Viedeo link:</h5>

            <a href='https://www.google.com/webhp?q=$videoLink'>
                $videoLink
            </a>
        </div><br/>
        ";
        }
        foreach ($articleLinks as $articleLink) {
            echo "
        <div>
            <h5>Article link:</h5>

            <a href='https://www.google.com/webhp?q=$articleLink'>
                $articleLink
            </a>
        </div><br/>
        ";
        }

        echo "
        <form method='post'> 
            <input type='hidden' name='recovering_course_id' value='{$course->getId()}'>
            <input type='submit' value='Восстановить'>
        </form>
        ";

        echo " <br/>End of course<br/><br/>";


    }
}