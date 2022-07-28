<?php

namespace app\courses\services;

use app\courses\entities\Course;

interface CourseService
{
    public function createNewCourse(Course $course): int;

    public function findCourse(int $courseId): Course;

    public function findAuthorsCourses(int $authorId): array;

    public function findCoursesWithSameTitle(string $partOfTitle): array;

    public function findAllCourses(): array;

    public function updateCourse(Course $course): void;

    public function deleteCourse(int $courseId): void;

    public function showDeletedUserCourses(int $userId): array;

    public function recoverCourse(int $courseId): void;

}