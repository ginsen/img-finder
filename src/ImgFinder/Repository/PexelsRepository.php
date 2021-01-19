<?php

declare(strict_types=1);

namespace ImgFinder\Repository;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use ImgFinder\Payload;
use ImgFinder\RequestInterface;
use ImgFinder\Response;
use ImgFinder\ResponseInterface;

class PexelsRepository implements ImgRepositoryInterface
{
    const NAME             = 'pexels';
    const PHOTOS           = 'photos';
    const SRC              = 'src';
    const MEDIUM           = 'medium';
    const PHOTOGRAPHER     = 'photographer';
    const PHOTOGRAPHER_URL = 'photographer_url';

    use ThumbnailTrait;


    /** @var string */
    private $authorization;

    /** @var ClientInterface */
    private $httpClient;


    public function __construct(string $authorization)
    {
        $this->authorization = $authorization;
        $this->httpClient    = new Client();
    }


    public function name(): string
    {
        return self::NAME;
    }


    public function findImages(RequestInterface $request): ResponseInterface
    {
        $url  = $this->makeUrl($request);
        $data = $this->doHttpRequest($url);

        return $this->createResponse($data, $request);
    }


    /**
     * @param RequestInterface $request
     * @return string
     */
    private function makeUrl(RequestInterface $request): string
    {
        return sprintf(
            'https://api.pexels.com/v1/search?query=%s&page=%d&per_page=%d&orientation=%s',
            $request->urlWords(),
            $request->page(),
            $request->perPage(),
            $request->orientation()
        );
    }


    /**
     * @param string $url
     * @return iterable|array
     */
    private function doHttpRequest(string $url): iterable
    {
        try {
            $res = $this->httpClient->get($url, [
                'headers' => ['Authorization' => $this->authorization],
            ]);

            $json = (string) $res->getBody();

            return (array) \GuzzleHttp\json_decode($json, true);
        } catch (Exception $exception) {
            return [];
        }
    }


    /**
     * @param iterable|array   $data
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    private function createResponse(iterable $data, RequestInterface $request): ResponseInterface
    {
        if (empty($data)) {
            return Response::fromUrls([]);
        }

        $orientation = $request->orientation();
        $response    = [];

        foreach ($data[self::PHOTOS] as $photo) {
            $thumbnail = $this->thumbnail($photo[self::SRC][self::MEDIUM], $request);
            $payload   = Payload::build(
                $photo[self::PHOTOGRAPHER] ?: '',
                $photo[self::PHOTOGRAPHER_URL] ?: '',
                $photo[self::SRC][$orientation],
                $thumbnail
            );
            $response[] = $payload->render();
        }

        return Response::fromUrls($response);
    }
}
