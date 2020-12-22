<?php

declare(strict_types=1);

namespace ImgFinder;

use ImgFinder\Service\RepositoryService;
use ImgFinder\Service\TranslatorService;

class ImgFinder
{
    /** @var TranslatorService */
    private $translator;

    /** @var RepositoryService */
    private $imgRepo;


    public function __construct(Config $config)
    {
        $this->translator = $config->translator();
        $this->imgRepo    = $config->repository();
    }


    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function search(RequestInterface $request): ResponseInterface
    {
        $request = $this->translator->translate($request);

        return $this->imgRepo->findImages($request);
    }


    /**
     * @return string[]
     */
    public function repositories(): iterable
    {
        return $this->imgRepo->names();
    }
}
