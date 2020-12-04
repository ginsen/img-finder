<?php

namespace ImgFinder\Cache;

use ImgFinder\RequestInterface;

abstract class AbstractCache
{
    const ONE_DAY = 'P1D';

    /**
     * @param RequestInterface $request
     * @return string
     */
    public function getCacheKey(RequestInterface $request): string
    {
        return sprintf('%s-%s', $this->getName(), $request->getCacheKey());
    }
}
