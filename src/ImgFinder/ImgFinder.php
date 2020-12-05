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
        $this->translator = $config->getTranslator();
        $this->imgRepo    = $config->getRepository();
    }


    public function search(RequestInterface $request): ResponseInterface
    {
        $request = $this->translator->translate($request);

        return $this->imgRepo->findImages($request);
    }
}
