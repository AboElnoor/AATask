<?php


namespace App\DataProviders;


interface ProviderInterface
{
    public function setDataSource(string $source);
    public function setDataMap(array $map);
    public function getDataMap();
}
