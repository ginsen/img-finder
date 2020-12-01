<?php

interface ImgFinderInterface
{
    public function search(RequestInterface $request): ResponseInterface;
}
