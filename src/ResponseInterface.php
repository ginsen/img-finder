<?php


interface ResponseInterface
{
    public function merge(ResponseInterface $response): self;

    /**
     * @return iterable|array
     */
    public function toArray(): iterable;
}

