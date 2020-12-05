<?php

declare(strict_types=1);

namespace ImgFinder;

interface RequestInterface
{
    public static function set(
        string $words,
        int $page = 1,
        int $perPage = 10,
        string $orientation = 'landscape'
    ): self;

    public function setWords(string $words): self;

    public function setPage(int $page): self;

    public function setPerPage(int $perPage): self;

    public function setOrientation(string $orientation): self;

    public function getWords(): string;

    public function getUrlWords(): string;

    public function getSlugWords(): string;

    public function getPage(): int;

    public function getPerPage(): int;

    public function getOrientation(): string;

    public function isEqual(self $request): bool;

    public function getCacheKey(): string;
}
