<?php


interface GoogleTranslateInterface
{
    public function findWord(RequestInterface $request): RequestInterface;

    public function isEnabled(): bool;
}