<?php

use app\courses\views\html\DeleteHtml;

class UpdateHtml extends DeleteHtml
{

    public static function writeUpdateCoursePage(Course $course): void
    {
        $updateUrl = SHOW_USER_COURSES ."/". $course->getId() . UPDATE_URN;

        $title = $course->getTitle();
        $content = $course->getContent();
        $texts = $content->getTexts();
        $videoLinks = $content->getLinksToTheVideos();
        $articleLinks = $content->getLinksToTheArticles();

        echo "<h2>$title</h2>";

        foreach ($texts as $key=>$text) {
            echo "
        <div>
            <form action='$updateUrl' method='post'>
                <pre style=' font-size: large '>$text</pre>
                <input type='hidden' name='delete_content_type' value='text'>
                <input type='hidden' name='delete_content' value='$key'>
                <input type='submit' value='-'>
            </form>
        </div>
        <br/>
        ";
        }

        foreach ($videoLinks as $key=>$videoLink) {
            echo "
        <div>
            <form action='$updateUrl' method='post'>
                $videoLink
                <input type='hidden' name='delete_content_type' value='video'>
                <input type='hidden' name='delete_content' value='$key'>
                <input type='submit' value='-'>
            </form>
        </div><br/>
        ";
        }

        foreach ($articleLinks as $key=>$articleLink) {
            echo "
        <div>
            <form action='$updateUrl' method='post'>
                $articleLink
                <input type='hidden' name='delete_content_type' value='article'>
                <input type='hidden' name='delete_content' value='$key'>
                <input type='submit' value='-'>
            </form>
        </div><br/>
        ";
        }

        echo "    <br> <br> 
    
        <form action='$updateUrl' method='post'>
        Video-content:
        <input type='hidden' name='content_type' value='video'>
            <input type='submit' value='+'>
        </form>  
        
        <form action='$updateUrl' method='post'>
        Text-content:
        <input type='hidden' name='content_type' value='txt'>
            <input type='submit' value='+'>
        </form>  
        
        <form action='$updateUrl' method='post'>
        Article-content:
        <input type='hidden' name='content_type' value='article'>
            <input type='submit' value='+'>
        </form>";
        echo "<br/>End of course <br/><br/><br/>";


    }

    public static function writeTextForm(): void
    {
        echo "
        <form method='post'>
                <p>
                    <h6></h6>
                    <textarea
                    name='text'
                    style='max-width: 800px;
                    min-width: 800px;
                    max-height: 1000px;
                    min-height: 600px;'
                    placeholder='Введите текстый контент курса:'
                    ></textarea>
                </p>
                <br/>
            <input type='hidden' name='content' value='text'>
            <input type='submit' value='Добавить текстовый контент'>
        </form>
        ";
    }

    public static function writeVideoForm(): void
    {
        echo "
        <form method='post'>
            <input style='min-width: 800px' type='text' placeholder='Введите ссылку на видео' name='video'>
            <br/>
            <input type='hidden' name='content' value='video'>
            <input type='submit' value='Добавить текстовый контент'>
        </form>
        ";
    }

    public static function writeArticleForm(): void
    {
        echo "
        <form method='post'>
            <input style='min-width: 800px' type='text' placeholder='Введите ссылку на статью' name='article'>
            <br/>
            <input type='hidden' name='content' value='article'>
            <input type='submit' value='Добавить текстовый контент'>
        </form>
        ";
    }


}