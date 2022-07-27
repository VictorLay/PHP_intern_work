<?php

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
                    $requiredPostKeys = ['content_type'];
                    if ($this->checkPostKeys($requiredPostKeys)) {
                        $this->addContentForm($_POST['content_type']);
                    }
                    $requiredPostKeys = ['content'];
                    if ($this->checkPostKeys($requiredPostKeys)) {
                        $content = $this->addContentAction($_POST['content'], $course->getContent());
                        $course->setContent($content);
                        $courseService->updateCourse($course);
                        Redirection::redirect(SHOW_USER_COURSES . "/$courseId" . UPDATE_URN);
                    }
                    $requiredPostKeys = ['delete_content'];
                    if ($this->checkPostKeys($requiredPostKeys)) {
                        $content = $this->removeContentAction($_POST['delete_content_type'], $course->getContent());
                        $course->setContent($content);
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

}