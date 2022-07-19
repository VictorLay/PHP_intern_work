<?php
require_once "./service/CourseService.php";
require_once "./dao/CourseDao.php";
require_once "./dao/factory/FactoryDao.php";

class CourseServiceImpl implements CourseService
{

    private CourseDao $courseDao;

    public function __construct()
    {
        $this->courseDao = FactoryDao::getInstance()->getCourseDao();
    }

    public function createNewCourse(Course $course): int
    {
        return $this->courseDao->create($course);
    }

    public function findCourse(int $courseId): Course
    {
        return $this->courseDao->readCourseById($courseId);
    }

    public function findAuthorsCourses(int $authorId): array
    {
        return $this->courseDao->readCoursesByAuthorId($authorId);
    }

    public function findCoursesWithSameTitle(string $partOfTitle): array
    {
        return $this->courseDao->readCoursesBySameTitle($partOfTitle);
    }

    public function updateCourse(Course $course): void
    {
        $this->courseDao->updateCourse($course);
    }

    public function deleteCourse(int $courseId): void
    {
        $this->courseDao->deleteCourse($courseId);
    }

}