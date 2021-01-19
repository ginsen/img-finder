<?php

declare(strict_types=1);

namespace ImgFinder;

interface RequestInterface
{
    /**
     * @param string      $words       The search term
     * @param int         $page        Page number
     * @param int         $perPage     Items per page
     * @param string      $orientation Orientation: 'landscape' or 'portrait', default: 'landscape'
     * @param int         $widthSmall  Width of small photos, default 320 pixels
     * @param string|null $repository  The used repository, if it not defined, search in all repositories
     * @return static
     */
    public static function set(
        string $words,
        int $page = 1,
        int $perPage = 10,
        string $orientation = 'landscape',
        int $widthSmall = 320,
        string $repository = null
    ): self;

    public function setWords(string $words): self;

    public function setRepository(string $repository): self;

    public function setPage(int $page): self;

    public function setPerPage(int $perPage): self;

    public function setOrientation(string $orientation): self;

    public function setWidthSmall(int $width): self;

    public function words(): string;

    public function urlWords(): string;

    public function slugWords(): string;

    public function hasRepository(): bool;

    public function repository(): ?string;

    public function page(): int;

    public function perPage(): int;

    public function orientation(): string;

    public function widthSmall(): int;

    public function isEqual(self $request): bool;

    public function cacheKey(): string;
}
