<?php

namespace ImgFinder\Repository;

use Exception;
use ImgFinder\Payload;
use ImgFinder\RequestInterface;
use ImgFinder\Response;
use ImgFinder\ResponseInterface;
use Nyholm\Psr7\Stream;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\StreamInterface;
use Symfony\Component\HttpClient\Psr18Client;

class FarmapolisPatternImageRepository extends AbstractFarmapolisRepository
{
    protected const NAME        = 'farmapolis-pattern-image';
    private const DATA          = 'data';
    private const CONTENTS      = 'contents';
    private const IMAGE         = 'image';
    private const FILENAME_DISK = 'filename_disk';


    protected function createBody(RequestInterface $request): StreamInterface
    {
        $param = sprintf(
            'query { contents( filter: { _and: [ { status: { _eq: "published" }} { owner: { id: { _in: ["5fd3cf1c-0567-4d41-b6d4-f45095d55a60"] }}} {_or: [ { name: { _icontains: "%s" }} { short_description: { _icontains: "%s" }} ]} ] } sort: ["-date_updated","-date_created"] limit: %d page: %d ) { image: thumbnail { filename_disk }}}',
            $request->words(),
            $request->words(),
            $request->perPage(),
            $request->page()
        );

        return Stream::create(json_encode([
            'query' => $param
        ]));
    }


    protected function createResponse(iterable $data, RequestInterface $request): ResponseInterface
    {
        if (empty($data[self::DATA])) {
            return Response::fromUrls([]);
        }

        $response = [];

        foreach ($data[self::DATA][self::CONTENTS] as $item) {
            $media   = $item[self::IMAGE][self::FILENAME_DISK];
            $payload = Payload::build(
                $this->name(),
                $this->makePublicUrl($media, $request->width()),
                $this->makePublicUrl($media, $request->widthSmall())
            );
            $response[] = $payload->render();
        }

        return Response::fromUrls($response);
    }
}
