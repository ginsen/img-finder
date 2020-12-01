<?php


interface ImgRepositoryInterface
{
    public function findImages(RequestInterface $request): ResponseInterface;
}
