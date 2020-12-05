<?php

declare(strict_types=1);

namespace ImgFinder\Translator;

use ImgFinder\Exception\DictionaryException;
use ImgFinder\RequestInterface;
use Symfony\Component\Translation\Loader\YamlFileLoader;
use Symfony\Component\Translation\Translator;

class DictionaryYaml implements TranslatorInterface
{
    const NAME = 'dictionary-yml';

    /** @var Translator */
    private $dictionary;


    public function __construct(string $filename)
    {
        if (!is_readable($filename)) {
            throw new DictionaryException('dictionary file not found');
        }

        $this->dictionary = $this->loadTranslator($filename);
    }


    public function getName(): string
    {
        return self::NAME;
    }


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
     * @return Translator
     */
    private function loadTranslator(string $filename): Translator
    {
        $translator = new Translator('es');

        $translator->addLoader('yaml', new YamlFileLoader());
        $translator->addResource('yaml', $filename, 'en');
        $translator->setFallbackLocales(['en']);

        return $translator;
    }
}
