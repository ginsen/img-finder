<?php

declare(strict_types=1);

namespace ImgFinder;

interface RequestInterface
{
    public static function fromParams(
        string $words,
        int $page = 1,
        int $perPage = 15,
        string $orientation = 'landscape'
    ): self;

    public function setWords(string $words): self;

    public function setPage(int $page): self;

    public function setPerPage(int $perPage): self;

    public function getWords(): string;

    public function getQueryStr(): string;

    public function getPage(): int;

    public function getPerPage(): int;

    public function getOrientation(): string;

    public function isEqual(self $request): bool;
}
