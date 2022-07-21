<?php
require_once "./bean/Content.php";

class Course extends Entity
{

    private string $title;

    private int $authorId;

    private Content $content;

    /**
     * @param string $title
     * @param int $authorId
     * @param Content $content
     */
    public function __construct(string $title, int $authorId, Content $content)
    {
        $this->title = $title;
        $this->authorId = $authorId;
        $this->content = $content;
    }


    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return int
     */
    public function getAuthorId(): int
    {
        return $this->authorId;
    }

    /**
     * @param int $authorId
     */
    public function setAuthorId(int $authorId): void
    {
        $this->authorId = $authorId;
    }


    /**
     * @return Content
     */
    public function getContent(): Content
    {
        return $this->content;
    }

    /**
     * @param Content $content
     */
    public function setContent(Content $content): void
    {
        $this->content = $content;
    }



//У курса есть название
//У курса есть автор
//У курса есть контент, который будет хранится в json


}