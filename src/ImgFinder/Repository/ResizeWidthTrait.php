<?php

declare(strict_types=1);

namespace ImgFinder\Repository;

trait ResizeWidthTrait
{
    private function resize(string $url, int $width, string $keyword = 'w'): string
    {
        $pattern = sprintf('~(.+)(&%s=\d+)(.*)~', $keyword);

        return (preg_match($pattern, $url, $match))
            ? $match[1] . "&$keyword=" . $width . $match[3]
            : $url . "&$keyword=" . $width;
    }
}
