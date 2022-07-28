<?php

namespace app\courses\controllers;

use app\core\utils\permission\impl\PermissionImpl;
use app\core\services\factory\ServiceFactory;
use app\core\views\CoreHtmlPageWriter;
use app\core\utils\Redirection;
use app\users\entities\User;
use app\courses\entities\Content;
use app\courses\views\HtmlCoursePageWriter;
use app\courses\entities\Course;

/** @link Router */
class CourseController extends PermissionImpl
{
    public function displayUserCoursesPage(array $infFromUri): void
    {
        $this->setAccessedRoles([ADMIN, USER]);
        if ($this->checkUserPermission()) {
            /** @var User $userFromSession */
            $userFromSession = $_SESSION['user'];
            $courseService = ServiceFactory::getInstance()->getCourseService();
            $courses = $courseService->findAuthorsCourses($userFromSession->getId());

            HtmlCoursePageWriter::writeCoursesPage($courses);
        } else {
            CoreHtmlPageWriter::write403ErrorPage();
        }
    }

    public function displayCourse(array $infFromUri): void
    {
        $this->setAccessedRoles([ADMIN, USER]);
        if ($this->checkUserPermission()) {
            $courseId = $infFromUri[1];
            $courseService = ServiceFactory::getInstance()->getCourseService();
            $course = $courseService->findCourse($courseId);
            HtmlCoursePageWriter::writeCoursePage($course);
        } else {
            CoreHtmlPageWriter::write403ErrorPage();
        }
    }

    public function displayAllCoursesPage(array $infFromUri): void
    {
        $this->setAccessedRoles([ADMIN, USER]);
        if ($this->checkUserPermission()) {
            $courseService = ServiceFactory::getInstance()->getCourseService();
            $courses = $courseService->findAllCourses();

            HtmlCoursePageWriter::writeCoursesPage($courses);
        } else {
            CoreHtmlPageWriter::write403ErrorPage();
        }
    }

    public function displayUpdateCoursePage(array $infFromUri): void
    {
        $this->setAccessedRoles([ADMIN, USER]);
        if ($this->checkUserPermission()) {
            /** @var User $userFromSession */
            $userFromSession = $_SESSION['user'];
            $requestMethod = $infFromUri['REQUEST_METHOD'];
            $courseId = $infFromUri[1];
            $courseService = ServiceFactory::getInstance()->getCourseService();
            $course = $courseService->findCourse($courseId);
            if ($course->getAuthorId() != $userFromSession->getId()) {
                Redirection::redirect(SHOW_USER_COURSES);
            }
            switch ($requestMethod) {
                case "GET":
                    HtmlCoursePageWriter::writeUpdateCoursePage($course);
                    break;
                case "POST":
                    var_dump($_POST);

                    $requiredPostKeys = ['content_type'];
                    if ($this->checkPostKeys($requiredPostKeys)) {
                        $this->addContentForm($_POST['content_type']);
                    }

                    $requiredPostKeys = ['content'];
                    if ($this->checkPostKeys($requiredPostKeys)) {
                        $content = $this->addContentAction($_POST['content'], $course->getContent());
                        $course->setContent($content);
                        $course->setTitle(htmlspecialchars_decode($course->getTitle()));
                        $courseService->updateCourse($course);
                        Redirection::redirect(SHOW_USER_COURSES . "/$courseId" . UPDATE_URN);
                    }

                    $requiredPostKeys = ['delete_content'];
                    if ($this->checkPostKeys($requiredPostKeys)) {
                        $content = $this->removeContentAction($_POST['delete_content_type'], $course->getContent());
                        $course->setContent($content);
                        $course->setTitle(htmlspecialchars_decode($course->getTitle()));
                        $courseService->updateCourse($course);
                        Redirection::redirect(SHOW_USER_COURSES . "/$courseId" . UPDATE_URN);
                    }

                    break;
            }
        } else {
            CoreHtmlPageWriter::write403ErrorPage();
        }
    }

    public function displayCreateCoursePage(array $infFromUri): void
    {
        $this->setAccessedRoles([ADMIN, USER]);
        if ($this->checkUserPermission()) {
            $requiredPostKeys = ['course_title'];
            /** @var User $userFromSession */
            $userFromSession = $_SESSION['user'];
            $requestMethod = $infFromUri['REQUEST_METHOD'];
            switch ($requestMethod) {
                case "GET":
                    HtmlCoursePageWriter::writeCreateCourseForm();
                    break;
                case "POST":
                    if ($this->checkPostKeys($requiredPostKeys)) {
                        $courseTitle = $_POST['course_title'];
                        $content = new Content([], [], []);
                        $course = new Course($courseTitle, $userFromSession->getId(), $content);
                        $courseService = ServiceFactory::getInstance()->getCourseService();
                        $newCourseId = $courseService->createNewCourse($course);
                        $newCourse = $courseService->findCourse($newCourseId);
                        HtmlCoursePageWriter::writeCoursePage($newCourse);
                    }

                    break;
            }
        } else {
            CoreHtmlPageWriter::write403ErrorPage();
        }

    }

    public function displayDeleteCoursePage(array $infFromUri): void
    {
        $this->setAccessedRoles([ADMIN, USER]);
        if ($this->checkUserPermission()) {
            $requiredPostKeys = ['course_title'];
            /** @var User $userFromSession */
            $userFromSession = $_SESSION['user'];
            $requestMethod = $infFromUri['REQUEST_METHOD'];
            $courseId = $infFromUri[1];
            $courseService = ServiceFactory::getInstance()->getCourseService();
            $course = $courseService->findCourse($courseId);
            if ($course->getAuthorId() != $userFromSession->getId()) {
                Redirection::redirect(SHOW_USER_COURSES);
            }
            switch ($requestMethod) {
                case "GET":
                    HtmlCoursePageWriter::writeDeleteWarning($course);
                    HtmlCoursePageWriter::writeCoursePage($course);
                    break;
                case "POST":
                    $courseService = ServiceFactory::getInstance()->getCourseService();
                    $courseService->deleteCourse($courseId);
                    Redirection::redirect("/courses");
            }
        } else {
            CoreHtmlPageWriter::write403ErrorPage();
        }

    }

    public function displaySearchPage(array $infFromUri): void
    {
        $requestMethod = $infFromUri['REQUEST_METHOD'];
        $this->setAccessedRoles([ADMIN, USER]);
        if ($this->checkUserPermission()) {
            switch ($requestMethod) {
                case "GET":
                    if (key_exists("search", $_GET)) {
                        $courseService = ServiceFactory::getInstance()->getCourseService();
                        $sameCourses = $courseService->findCoursesWithSameTitle($_GET['search']);
                        HtmlCoursePageWriter::writeSearchPage();
                        HtmlCoursePageWriter::writeCoursesPage($sameCourses);
                    } else {
                        HtmlCoursePageWriter::writeSearchPage();
                    }
                    break;
                case "POST":
                    CoreHtmlPageWriter::write405ErrorPage();
                    break;
            }
        } else {
            CoreHtmlPageWriter::write403ErrorPage();
        }
    }

    public function displayDeletedCourses(array $infFromUri): void
    {
        $requestMethod = $infFromUri['REQUEST_METHOD'];
        $this->setAccessedRoles([ADMIN, USER]);
        if ($this->checkUserPermission()) {
            /** @var User $userFromSession */
            $userFromSession = $_SESSION['user'];
            switch ($requestMethod) {
                case "GET":
                    $courseService = ServiceFactory::getInstance()->getCourseService();
                    $deletedCourses = $courseService->showDeletedUserCourses($userFromSession->getId());
                    HtmlCoursePageWriter::writeDeletedCoursesPage($deletedCourses);
                    break;
                case "POST":
                    $requiredPostKeys = ["recovering_course_id"];
                    if ($this->checkPostKeys($requiredPostKeys)) {
                        $recoveringCourseId = $_POST['recovering_course_id'];
                        $courseService = ServiceFactory::getInstance()->getCourseService();
                        $courseService->recoverCourse($recoveringCourseId);
                        $course = $courseService->findCourse($recoveringCourseId);
                        echo "
                            <a href='/'>Домой</a>
                            <br/>
                            <h3>Восстановленный курс:</h3>";
                        HtmlCoursePageWriter::writeCoursePage($course);

                    } else {
                        CoreHtmlPageWriter::write422ErrorPage();
                    }
                    break;
            }
        } else {
            CoreHtmlPageWriter::write403ErrorPage();
        }
    }


    private function addContentForm(string $contentType): void
    {
        switch ($contentType) {
            case "txt":
                HtmlCoursePageWriter::writeTextForm();
                break;
            case "video":
                HtmlCoursePageWriter::writeVideoForm();
                break;
            case "article":
                HtmlCoursePageWriter::writeArticleForm();
                break;
        }
    }

    private function addContentAction(string $contentType, Content $content): Content
    {
        switch ($contentType) {
            case "text":
                $text = $_POST['text'];
                $texts = $content->getTexts();
                $texts[] = $text;
                $content->setTexts($texts);
                return $content;
            case "video":
                $video = $_POST['video'];
                $videos = $content->getLinksToTheVideos();
                $videos[] = $video;
                $content->setLinksToTheVideos($videos);
                return $content;
            case "article":
                $article = $_POST['article'];
                $articles = $content->getLinksToTheArticles();
                $articles[] = $article;
                $content->setLinksToTheArticles($articles);
                return $content;
        }
        return $content;
    }

    private function removeContentAction(string $contentType, Content $content): Content
    {

        switch ($contentType) {
            case "text":
                $textIndex = $_POST['delete_content'];
                $texts = $content->getTexts();
                unset($texts[$textIndex]);
                $content->setTexts($texts);
                return $content;
            case "video":
                $videoIndex = $_POST['delete_content'];
                $videos = $content->getLinksToTheVideos();
                unset($videos[$videoIndex]);
                $content->setLinksToTheVideos($videos);
                return $content;
            case "article":
                $articleIndex = $_POST['delete_content'];
                $articles = $content->getLinksToTheArticles();
                unset($articles[$articleIndex]);
                $content->setLinksToTheArticles($articles);
                return $content;
        }
        return $content;
    }

}