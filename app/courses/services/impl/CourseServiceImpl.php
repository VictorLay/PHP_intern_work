<?php

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
        return $this->courseModel->readCourseById($courseId);
    }

    public function findAuthorsCourses(int $authorId): array
    {
        return $this->courseModel->readCoursesByAuthorId($authorId);
    }

    public function findCoursesWithSameTitle(string $partOfTitle): array
    {
        return $this->courseModel->readCoursesBySameTitle($partOfTitle);
    }

    public function updateCourse(Course $course): void
    {
        $this->courseModel->updateCourse($course);
    }

    public function deleteCourse(int $courseId): void
    {
        $this->courseModel->deleteCourse($courseId);
    }

    public function showDeletedUserCourses(int $userId): array
    {
        return $this->courseModel->readDeletedCourses($userId);
    }

    public function recoverCourse(int $courseId): void
    {
        $this->courseModel->recoverCourse($courseId);
    }

}