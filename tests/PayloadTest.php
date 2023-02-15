<?php

declare(strict_types=1);

namespace Tests;

use ImgFinder\Payload;
use PHPUnit\Framework\TestCase;

class PayloadTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_make_valid_instance()
    {
        $payload = Payload::build(
            'foo',
            'http://foo.io',
            'http://image',
            'http://thumbnail'
        );

        self::assertInstanceOf(Payload::class, $payload);
    }


    /**
     * @test
     */
    public function it_should_render_to_array()
    {
        $payload = Payload::build(
            'foo',
            'http://foo',
            'http://image',
            'http://thumbnail'
        );

        $data = $payload->render();

        self::assertIsArray($data);
        self::assertSame('foo', $data[Payload::AUTHOR]);
        self::assertSame('http://foo', $data[Payload::URL_AUTHOR]);
        self::assertSame('http://image', $data[Payload::PHOTOS][Payload::IMAGE]);
        self::assertSame('http://thumbnail', $data[Payload::PHOTOS][Payload::THUMBNAIL]);
    }
}
