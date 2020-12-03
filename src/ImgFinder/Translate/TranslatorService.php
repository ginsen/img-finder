<?php

declare(strict_types=1);

namespace ImgFinder\Translate;

use ImgFinder\Config;
use ImgFinder\RequestInterface;
use ReflectionClass;

class TranslatorService
{
    /** @var TranslateInterface[] */
    private $translators;


    /**
     * TranslatorService constructor.
     * @param Config $config
     * @throws
     */
    public function __construct(Config $config)
    {
        foreach ($config->getTranslators() as $class => $trans) {
            $reflection          = new ReflectionClass($class);
            $this->translators[] = $reflection->newInstanceArgs($trans['params']);
        }
    }

    public function translate(RequestInterface $request): RequestInterface
    {
        foreach ($this->translators as $translator) {
            $newRequest = $translator->findWord($request);
            if (!$newRequest->isEqual($request)) {
                return $newRequest;
            }
        }

        return $request;
    }
}
