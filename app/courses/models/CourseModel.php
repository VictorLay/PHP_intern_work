<?php

interface CourseModel
{

    public function create(Course $course): int;

    public function readCourseById(int $id): ?Course;

    public function readCoursesByAuthorId(int $authorId): array;

    public function readCoursesBySameTitle(string $title): array;

    public function updateCourse(Course $course): void;

    public function deleteCourse(int $courseId): void;

    public function readDeletedCourses(int $authorId):array;

    public function recoverCourse(int $courseId): void;
}