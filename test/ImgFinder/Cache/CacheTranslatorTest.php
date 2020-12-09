<?php

declare(strict_types=1);

namespace ImgFinder\Cache;

use ImgFinder\Request;
use ImgFinder\RequestInterface;
use ImgFinder\Translator\TranslatorInterface;
use Mockery as m;
use PHPUnit\Framework\TestCase;
use Psr\Cache\CacheItemInterface;
use Psr\Cache\CacheItemPoolInterface;

class CacheTranslatorTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_translate_without_cache_and_translator_no_find_word()
    {
        $request    = Request::set('hello world');
        $item       = $this->getItemCache();
        $cache      = $this->getCachePool($item);
        $translator = $this->getTranslator($request);

        $translatorCache = new CacheTranslator($cache, $translator);
        $newRequest      = $translatorCache->findWord($request);

        self::assertSame($request, $newRequest);
    }


    /**
     * @test
     */
    public function it_should_translate_without_cache_and_translator_find_word()
    {
        $request      = Request::set('hello world');
        $transRequest = Request::set('hola mundo');
        $item         = $this->getItemCache();
        $cache        = $this->getCachePool($item);
        $translator   = $this->getTranslator($transRequest);

        $translatorCache = new CacheTranslator($cache, $translator);
        $newRequest      = $translatorCache->findWord($request);

        self::assertSame($transRequest, $newRequest);
    }


    /**
     * @test
     */
    public function it_should_find_request_cache()
    {
        $request      = Request::set('hello world');
        $transRequest = Request::set('hola mundo');
        $translator   = $this->getTranslator($transRequest);
        $item         = $this->getItemCache($transRequest);
        $cache        = $this->getCachePool($item);

        $translatorCache = new CacheTranslator($cache, $translator);
        $newRequest      = $translatorCache->findWord($request);

        self::assertSame($transRequest->getWords(), $newRequest->getWords());
    }


    /**
     * @param RequestInterface|null $request
     * @return CacheItemInterface
     */
    private function getItemCache(RequestInterface $request = null): CacheItemInterface
    {
        $item = m::mock(CacheItemInterface::class);

        $item->shouldReceive('isHit')->andReturn(!empty($request));
        $item->shouldReceive('set')->andReturnNull();
        $item->shouldReceive('expiresAfter')->andReturnNull();
        $item->shouldReceive('get')->andReturn(serialize($request));

        return $item;
    }


    /**
     * @param CacheItemInterface $item
     * @return CacheItemPoolInterface
     */
    public function getCachePool(CacheItemInterface $item): CacheItemPoolInterface
    {
        $cache = m::mock(CacheItemPoolInterface::class);

        $cache->shouldReceive('getItem')->andReturn($item);
        $cache->shouldReceive('save')->andReturnNull();

        return $cache;
    }


    /**
     * @param RequestInterface $request
     * @return TranslatorInterface
     */
    public function getTranslator(RequestInterface $request): TranslatorInterface
    {
        $translator = m::mock(TranslatorInterface::class);

        $translator->shouldReceive('getName')->andReturn('translator');
        $translator->shouldReceive('findWord')->andReturn($request);

        return $translator;
    }
}
