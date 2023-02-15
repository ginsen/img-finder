<?php

declare(strict_types=1);

namespace ImgFinder;

class Payload
{
    public const AUTHOR     = 'author';
    public const URL_AUTHOR = 'url_author';
    public const PHOTOS     = 'photos';
    public const THUMBNAIL  = 'thumbnail';
    public const IMAGE      = 'image';


    private string $author;
    private string $urlAuthor;
    private string $urlImage;
    private string $thumbnail;


    public static function build(string $author, string $urlAuthor, string $urlImage, string $thumbnail): self
    {
        $instance = new static();

        $instance->author    = $author;
        $instance->urlAuthor = $urlAuthor;
        $instance->urlImage  = $urlImage;
        $instance->thumbnail = $thumbnail;

        return $instance;
    }


    public function render(): iterable
    {
        return [
            self::AUTHOR     => $this->author,
            self::URL_AUTHOR => $this->urlAuthor,
            self::PHOTOS     => [
                self::THUMBNAIL => $this->thumbnail,
                self::IMAGE     => $this->urlImage,
            ],
        ];
    }


    private function __construct()
    {
    }
}
