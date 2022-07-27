<?php


class CourseModelImpl extends TransactionImpl implements CourseModel
{
    private const CREATE_QUERY = "INSERT INTO my_db_test.courses (`title`, `author_id`, `content`, `deleted`) VALUES ( :title , :authorId, :content, FALSE);";
    private const READ_BY_ID_QUERY = "SELECT * FROM my_db_test.courses WHERE `courses`.`course_id` = :courseId AND deleted = FALSE;";
    private const READ_ALL_COURSES_QUERY = "SELECT * FROM my_db_test.courses WHERE deleted = FALSE;";
    private const READ_BY_AUTHOR_ID_QUERY = "SELECT * FROM my_db_test.courses WHERE `courses`.`author_id` = :authorId AND deleted = FALSE;";
    private const READ_BY_LIKE_STRING_IN_TITLE_QUERY = "SELECT * FROM my_db_test.courses WHERE courses.title like :likeVariable AND deleted = FALSE;";
    private const READ_DELETED_COURSES_BY_AUTHOR_ID = "SELECT * FROM my_db_test.courses WHERE `courses`.`author_id` = :authorId AND deleted = TRUE;";
    private const UPDATE_QUERY = "UPDATE my_db_test.courses SET `title`=:title, `author_id`=:authorId, `content`=:content  WHERE `courses`.`course_id` = :courseId AND deleted = FALSE;";
    private const RECOVER_COURSE_BY_COURSE_ID_QUERY = "UPDATE my_db_test.courses SET `deleted` = FALSE WHERE `courses`.`course_id` = :courseId AND deleted = TRUE;";
    private const DELETE_BY_ID_QUERY = "UPDATE my_db_test.courses SET `deleted` = TRUE  WHERE `courses`.`course_id` = :courseId;";


    public function create(Course $course): int
    {
        $title = $course->getTitle();
        $authorId = $course->getAuthorId();
        $content = $course->getContent();
        $contentJson = json_encode($content);

        $statement = $this->connection->prepare(self::CREATE_QUERY);
        $statement->bindParam(":title", $title);
        $statement->bindParam(":authorId", $authorId, PDO::PARAM_INT);
        $statement->bindParam(":content", $contentJson);
        $statement->execute();
        return $this->connection->lastInsertId();
    }

    public function readCourseById(int $id): ?Course
    {
        $statement = $this->connection->prepare(self::READ_BY_ID_QUERY);
        $statement->bindParam(":courseId", $id, PDO::PARAM_INT);
        $statement->execute();
        if ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            return $this->extractCourseFromRow($row);
        }
        return null;
    }

    public function readCoursesByAuthorId(int $authorId): array
    {
        $statement = $this->connection->prepare(self::READ_BY_AUTHOR_ID_QUERY);
        $statement->bindParam(":authorId", $authorId, PDO::PARAM_INT);
        $statement->execute();
        $courseFromQuery = [];

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $courseFromQuery[] = $this->extractCourseFromRow($row);
        }
        return $courseFromQuery;
    }

    public function readCoursesBySameTitle(string $title): array
    {
        $statement = $this->connection->prepare(self::READ_BY_LIKE_STRING_IN_TITLE_QUERY);
        $likeVariable = '%' . $title . '%';
        $statement->bindParam(":likeVariable", $likeVariable);
        $statement->execute();
        $courseFromQuery = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $courseFromQuery[] = $this->extractCourseFromRow($row);
        }
        return $courseFromQuery;
    }

    public function readAllCourses(): array
    {
        $statement = $this->connection->prepare(self::READ_ALL_COURSES_QUERY);
        $statement->execute();
        $courseFromQuery = [];
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $courseFromQuery[] = $this->extractCourseFromRow($row);
        }
        return $courseFromQuery;
    }


    public function updateCourse(Course $course): void
    {
        $courseId = $course->getId();
        $authorId = $course->getAuthorId();
        $title = $course->getTitle();
        $contentJson = json_encode($course->getContent());

        $statement = $this->connection->prepare(self::UPDATE_QUERY);
        $statement->bindParam(":courseId", $courseId, PDO::PARAM_INT);
        $statement->bindParam(":authorId", $authorId, PDO::PARAM_INT);
        $statement->bindParam(":title", $title);
        $statement->bindParam(":content", $contentJson);
        $statement->execute();
    }

    public function deleteCourse(int $courseId): void
    {
        $statement = $this->connection->prepare(self::DELETE_BY_ID_QUERY);
        $statement->bindParam(":courseId", $courseId, PDO::PARAM_INT);
        $statement->execute();
    }

    private function extractCourseFromRow(mixed $row): Course
    {
        $title = $row['title'];
        $authorId = $row['author_id'];
        $contentJson = $row['content'];
        $courseId = $row['course_id'];

        $content = new Content();
        $content->setContentFieldsWithJson($contentJson);
        $course = new Course($title, $authorId, $content);
        $course->setId($courseId);

        return $course;
    }

    public function readDeletedCourses(int $authorId): array
    {
        $statement = $this->connection->prepare(self::READ_DELETED_COURSES_BY_AUTHOR_ID);
        $statement->bindParam(":authorId", $authorId, PDO::PARAM_INT);
        $statement->execute();
        $courseFromQuery = [];

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            $courseFromQuery[] = $this->extractCourseFromRow($row);
        }
        return $courseFromQuery;
    }

    public function recoverCourse(int $courseId): void
    {
        $statement = $this->connection->prepare(self::RECOVER_COURSE_BY_COURSE_ID_QUERY);
        $statement->bindParam(":courseId", $courseId, PDO::PARAM_INT);
        $statement->execute();
    }


}