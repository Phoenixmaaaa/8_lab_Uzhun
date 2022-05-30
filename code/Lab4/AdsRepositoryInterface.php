<?php
namespace Lab4;

require_once 'Advertisement.php';

interface AdsRepositoryInterface
{
    /**
     * @param string $category
     * @return Advertisement[]
     */
    public function getAds(string $category): array;

    public function append(Advertisement $advertisement): bool;
}