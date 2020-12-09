<?php

declare(strict_types=1);

namespace ImgFinder;

use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_make_valid_instance()
    {
        $request = Request::set('test');

        self::assertInstanceOf(RequestInterface::class, $request);
    }


    /**
     * @test
     */
    public function it_should_return_default_values()
    {
        $request = Request::set('test');

        self::assertSame('test', $request->getWords());
        self::assertSame(1, $request->getPage());
        self::assertSame(10, $request->getPerPage());
        self::assertSame('landscape', $request->getOrientation());
    }


    /**
     * @test
     */
    public function it_should_allow_set_values()
    {
        $request1 = Request::set('test');
        $request2 = $request1->setWords('other phrase');
        $request3 = $request2->setPage(2);
        $request4 = $request3->setPerPage(11);
        $request5 = $request4->setOrientation('portrait');

        self::assertSame('test', $request1->getWords());
        self::assertSame('other phrase', $request2->getWords());

        self::assertSame(1, $request2->getPage());
        self::assertSame(2, $request3->getPage());

        self::assertSame(10, $request3->getPerPage());
        self::assertSame(11, $request4->getPerPage());

        self::assertSame('landscape', $request4->getOrientation());
        self::assertSame('portrait', $request5->getOrientation());
    }


    /**
     * @test
     */
    public function it_should_compare_equals_instances()
    {
        $request1 = Request::set('test');
        $request2 = Request::set('test');

        self::assertFalse($request1->isEqual($request2));
        self::assertTrue($request1->isEqual($request1));
        self::assertTrue($request2->isEqual($request2));
    }


    /**
     * @test
     */
    public function it_should_return_words_in_several_formats()
    {
        $request = Request::set('protección crema solar!');

        self::assertSame('protección crema solar!', $request->getWords());
        self::assertSame('protecci%C3%B3n+crema+solar%21', $request->getUrlWords());
        self::assertSame('proteccion-crema-solar', $request->getSlugWords());
    }


    /**
     * @test
     */
    public function it_should_return_cache_key_in_slug_format()
    {
        $request = Request::set('test');

        self::assertSame('landscape-10-test-1', $request->getCacheKey());
    }
}
