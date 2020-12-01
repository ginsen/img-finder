<?php

interface RequestInterface
{
    public static function fromParams(string $words, int $page = 1, int $elementPerPage = 15): self;

    public function setWords(string $words): self;

    public function setPage(int $page): self;

    public function setElementsPerPage(int $elementPerPage): self;

    public function getWords(): string;

    public function getPage(): int;

    public function getElementsPerPage(): int;
}

