<?php

declare(strict_types=1);

namespace ImgFinder\Cache;

use DateInterval;
use ImgFinder\RequestInterface;
use ImgFinder\Translate\TranslateInterface;
use Psr\Cache\CacheItemPoolInterface;

class CacheTranslate extends AbstractCache implements TranslateInterface
{
    /** @var CacheItemPoolInterface */
    private $cache;

    /** @var TranslateInterface */
    private $translator;


    public function __construct(CacheItemPoolInterface $cache, TranslateInterface $translator)
    {
        $this->cache      = $cache;
        $this->translator = $translator;
    }


    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return $this->translator->getName();
    }


    /**
     * {@inheritdoc}
     */
    public function findWord(RequestInterface $request): RequestInterface
    {
        $key  = $this->getCacheKey($request);
        $item = $this->cache->getItem($key);

        if ($item->isHit()) {
            return unserialize($item->get());
        }

        $newRequest = $this->translator->findWord($request);
        if ($newRequest->isEqual($request)) {
            return $request;
        }

        $item->set(serialize($newRequest));
        $item->expiresAfter(new DateInterval(self::ONE_DAY));
        $this->cache->save($item);

        return $newRequest;
    }
}
