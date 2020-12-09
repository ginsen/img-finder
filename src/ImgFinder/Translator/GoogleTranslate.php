<?php

declare(strict_types=1);

namespace ImgFinder\Translator;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use ImgFinder\RequestInterface;

class GoogleTranslate implements TranslatorInterface
{
    const NAME = 'google-translate';


    /** @var string */
    private $apikey;

    /** @var string */
    private $from;

    /** @var string */
    private $to;

    /** @var ClientInterface */
    private $httpClient;


    public function __construct(string $apikey, string $from, string $to)
    {
        $this->apikey     = $apikey;
        $this->from       = $from;
        $this->to         = $to;
        $this->httpClient = new Client();
    }


    public function getName(): string
    {
        return self::NAME;
    }


    public function findWord(RequestInterface $request): RequestInterface
    {
        $url  = $this->makeUrl($request);
        $data = $this->doHttpRequest($url);

        return $this->createNewRequest($request, $data);
    }


    private function makeUrl(RequestInterface $request): string
    {
        return sprintf(
            'https://www.googleapis.com/language/translate/v2?key=%s&source=%s&target=%s&q=%s',
            $this->apikey,
            $this->from,
            $this->to,
            $request->getUrlWords()
        );
    }


    private function doHttpRequest(string $url): iterable
    {
        try {
            $res  = $this->httpClient->get($url);
            $json = (string) $res->getBody();

            return \GuzzleHttp\json_decode($json, true);
        } catch (Exception $exception) {
            return [];
        }
    }


    private function createNewRequest(RequestInterface $request, iterable $data): RequestInterface
    {
        $translated = $data['data']['translations'][0]['translatedText'];

        if ($translated === $request->getWords()) {
            return $request;
        }

        return $request->setWords($translated);
    }
}
