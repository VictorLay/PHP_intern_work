<?php
require_once "./bean/Course.php";

interface CourseService
{
    public function createNewCourse(Course $course): int;

    public function findCourse(int $courseId): Course;

    public function findAuthorsCourses(int $authorId): array;

    public function findCoursesWithSameTitle(string $partOfTitle): array;

    public function updateCourse(Course $course): void;

    public function deleteCourse(int $courseId): void;

}