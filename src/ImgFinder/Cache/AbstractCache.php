<?php

declare(strict_types=1);

namespace ImgFinder\Cache;

use ImgFinder\RequestInterface;

abstract class AbstractCache
{
    const ONE_DAY = 'P1D';


    public function getCacheKey(RequestInterface $request): string
    {
        return sprintf('%s-%s', $this->getName(), $request->getCacheKey());
    }
}
