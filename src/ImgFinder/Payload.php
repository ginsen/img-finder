<?php

declare(strict_types=1);

namespace ImgFinder;

class Payload
{
    const AUTHOR     = 'author';
    const URL_AUTHOR = 'url_author';
    const PHOTOS     = 'photos';
    const THUMBNAIL  = 'thumbnail';
    const IMAGE      = 'image';


    /** @var string */
    private $author;

    /** @var string */
    private $urlAuthor;

    /** @var string */
    private $urlImage;

    /** @var string */
    private $thumbnail;


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
