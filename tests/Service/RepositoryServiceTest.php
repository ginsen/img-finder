<?php

namespace Tests\Service;

use ImgFinder\Request;
use ImgFinder\ResponseInterface;
use ImgFinder\Service\RepositoryService;
use Mockery as m;
use PHPUnit\Framework\TestCase;
use Psr\Cache\CacheItemPoolInterface;

class RepositoryServiceTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_init_instance()
    {
        $service = $this->makeService();

        self::assertInstanceOf(RepositoryService::class, $service);
    }

    /**
     * @test
     */
    public function it_should_init_instance_with_cache()
    {
        $cache   = m::mock(CacheItemPoolInterface::class);
        $service = $this->makeService($cache);

        self::assertInstanceOf(RepositoryService::class, $service);
    }


    /**
     * @test
     */
    public function it_should_return_response_when_request_find_images()
    {
        $service  = $this->makeService();
        $request  = Request::set('test');
        $response = $service->findImages($request);

        self::assertInstanceOf(ResponseInterface::class, $response);
    }


    /**
     * @param CacheItemPoolInterface|null $cache
     * @return RepositoryService
     */
    public function makeService(CacheItemPoolInterface $cache = null): RepositoryService
    {
        $repos = ['Tests\Repository\SpyRepository' => [
                'params' => ['authorization' => 'my-credentials'],
            ],
        ];

        return RepositoryService::init($repos, $cache);
    }
}
