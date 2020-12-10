<?php

declare(strict_types=1);

namespace ImgFinder;

interface RequestInterface
{
    public static function set(
        string $words,
        string $repository = null,
        int $page = 1,
        int $perPage = 10,
        string $orientation = 'landscape'
    ): self;

    public function setWords(string $words): self;

    public function setRepository(string $repository): self;

    public function setPage(int $page): self;

    public function setPerPage(int $perPage): self;

    public function setOrientation(string $orientation): self;

    public function words(): string;

    public function urlWords(): string;

    public function slugWords(): string;

    public function hasRepository(): bool;

    public function repository(): ?string;

    public function page(): int;

    public function perPage(): int;

    public function orientation(): string;

    public function isEqual(self $request): bool;

    public function cacheKey(): string;
}
