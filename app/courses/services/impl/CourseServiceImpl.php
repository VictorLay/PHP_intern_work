<?php

namespace app\courses\services\impl;

use app\core\models\factory\ModelsFactory;
use app\courses\entities\Course;
use app\courses\models\CourseModel;
use app\courses\services\CourseService;



class CourseServiceImpl implements CourseService
{

    private CourseModel $courseModel;

    public function __construct()
    {
        $this->courseModel = ModelsFactory::getInstance()->getCourseDao();
    }

    public function createNewCourse(Course $course): int
    {
        return $this->courseModel->create($course);
    }

    public function findCourse(int $courseId): Course
    {
        return $this->sterilizeOutput($this->courseModel->readCourseById($courseId));
    }

    public function findAuthorsCourses(int $authorId): array
    {
        return $this->sterilizeOutput($this->courseModel->readCoursesByAuthorId($authorId));
    }

    public function findCoursesWithSameTitle(string $partOfTitle): array
    {
        return $this->sterilizeOutput($this->courseModel->readCoursesBySameTitle($partOfTitle));
    }

    public function findAllCourses(): array
    {
        return $this->sterilizeOutput($this->courseModel->readAllCourses());
    }

    public function updateCourse(Course $course): void
    {
        $course->getContent()->decodeHtmlSpecialChar();
        $this->courseModel->updateCourse($course);
    }

    public function deleteCourse(int $courseId): void
    {
        $this->courseModel->deleteCourse($courseId);
    }

    public function showDeletedUserCourses(int $userId): array
    {
        return $this->sterilizeOutput($this->courseModel->readDeletedCourses($userId));
    }

    public function recoverCourse(int $courseId): void
    {
        $this->courseModel->recoverCourse($courseId);
    }

    private function sterilizeOutput(Course|array|null $courses): Course|array|null
    {
        if(is_null($courses)){
            return null;
        }
       if( is_array($courses)){
           /** @var Course $course */
           foreach ($courses as $course) {
               $course = $this->sterilizeCourse($course);
           }
           return $courses;
       }else{
           return $this->sterilizeCourse($courses);
       }
    }

    private function sterilizeCourse(Course $course):Course {
        $course->setTitle(
            htmlspecialchars($course->getTitle())
        );
        $content = $course->getContent();
        $texts = [];
        $videos = [];
        $articles = [];
        foreach ($content->getTexts() as $text){
            if (is_null($text)){
                continue;
            }
            $texts[] = htmlspecialchars($text);
        }
        foreach ($content->getLinksToTheVideos() as $video){
            if (is_null($video)){
                continue;
            }
            $videos[] = htmlspecialchars($video);
        }
        foreach ($content->getLinksToTheArticles() as $article){
            if (is_null($article)){
                continue;
            }
            $articles[] = htmlspecialchars($article);
        }
        $content->setTexts($texts);
        $content->setLinksToTheVideos($videos);
        $content->setLinksToTheArticles($articles);

        return $course;
    }

}