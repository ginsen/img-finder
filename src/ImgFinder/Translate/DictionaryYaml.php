<?php

declare(strict_types=1);

namespace ImgFinder\Translate;

use ImgFinder\Exception\DictionaryException;
use ImgFinder\RequestInterface;
use Symfony\Component\Translation\Loader\YamlFileLoader;
use Symfony\Component\Translation\Translator as sfTranslator;

class DictionaryYaml implements TranslateInterface
{
    /** @var sfTranslator */
    private $dictionary;


    public function __construct(string $filename)
    {
        if (!is_readable($filename)) {
            throw new DictionaryException('dictionary file not found');
        }

        $this->dictionary = $this->loadTranslator($filename);
    }


    /**
     * {@inheritdoc}
     */
    public function findWord(RequestInterface $request): RequestInterface
    {
        $wordTrans = $this->dictionary->trans($request->getWords());

        if ($wordTrans === $request->getWords()) {
            return $request;
        }

        return $request->setWords($wordTrans);
    }


    /**
     * @param string $filename
     * @return sfTranslator
     */
    private function loadTranslator(string $filename): sfTranslator
    {
        $translator = new sfTranslator('es');

        $translator->addLoader('array', new YamlFileLoader());
        $translator->addResource('array', $filename, 'en');
        $translator->setFallbackLocales(['en']);

        return $translator;
    }
}
