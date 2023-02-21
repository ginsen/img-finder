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

class FarmapolisProductImageRepository extends AbstractFarmapolisRepository
{
    protected const NAME            = 'farmapolis-product-image';
    private const DATA              = 'data';
    private const PRODUCTS          = 'products';
    private const ASSETS            = 'assets';
    private const DIRECTUS_FILES_ID = 'directus_files_id';
    private const FILENAME_DISK     = 'filename_disk';


    protected function createBody(RequestInterface $request): StreamInterface
    {
        $param = sprintf(
            'query { products( filter: { _and: [{ status: { _eq: "published" }} {assets: {directus_files_id: {filename_disk: {_nnull: true}}}} {_or: [ { name: { _icontains: "%s" } } {lab_id: {name: { _icontains: "%s" }}} {codes: {code: { _eq: "%d" }}} ]}] } sort: ["-date_updated","-date_created","name"] limit:%d page: %d ) { assets ( filter: { type: {_in: ["product_image", "prod_custom_img_1", "prod_custom_img_2"]} } sort: ["type"]) { directus_files_id{ filename_disk } } }}',
            $request->words(),
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

        foreach ($data[self::DATA][self::PRODUCTS] as $item) {
            $media   = $item[self::ASSETS][0][self::DIRECTUS_FILES_ID][self::FILENAME_DISK];
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
