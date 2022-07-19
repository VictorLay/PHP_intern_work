<?php

class Content implements JsonSerializable
{
    private array $text;
    private array $linkToTheArticle;
    private array $linkToTheVideo;

    /**
     * @param array $text
     * @param array $linkToTheArticle
     * @param array $linkToTheVideo
     */
    public function __construct(array $text = [], array $linkToTheArticle = [], array $linkToTheVideo = [])
    {
        $this->text = $text;
        $this->linkToTheArticle = $linkToTheArticle;
        $this->linkToTheVideo = $linkToTheVideo;
    }

    /**
     * @return array
     */
    public function getText(): array
    {
        return $this->text;
    }

    /**
     * @param array $text
     */
    public function setText(array $text): void
    {
        $this->text = $text;
    }

    /**
     * @return array
     */
    public function getLinkToTheArticle(): array
    {
        return $this->linkToTheArticle;
    }

    /**
     * @param array $linkToTheArticle
     */
    public function setLinkToTheArticle(array $linkToTheArticle): void
    {
        $this->linkToTheArticle = $linkToTheArticle;
    }

    /**
     * @return array
     */
    public function getLinkToTheVideo(): array
    {
        return $this->linkToTheVideo;
    }

    /**
     * @param array $linkToTheVideo
     */
    public function setLinkToTheVideo(array $linkToTheVideo): void
    {
        $this->linkToTheVideo = $linkToTheVideo;
    }


    public function jsonSerialize(): array
    {
        return [
            [
                'type' => 'text',
                'content' => $this->text
            ],
            [
                'type'=>'linkToTheArticle',
                'content' => $this->linkToTheArticle
            ],
            [
                'type'=>'linkToTheVideo',
                'content' => $this->linkToTheVideo
            ]
        ];
    }

    public function setContentFieldsWithJson(string $jsonContent): void
    {
        $array = json_decode($jsonContent, JSON_OBJECT_AS_ARRAY);

        $this->text = $array['text'];
        $this->linkToTheArticle = $array['linkToTheArticle'];
        $this->linkToTheVideo = $array['linkToTheVideo'];
    }


}