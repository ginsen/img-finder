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

        self::assertSame('test', $request->getWords());
        self::assertSame(1, $request->getPage());
        self::assertSame(15, $request->getPerPage());
    }
}
