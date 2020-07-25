<?php


namespace App\DataProviders;


class Provider implements ProviderInterface
{
    private $map;

    public function setDataSource(string $source)
    {
        $this->dataSource = $source;
    }

    public function getDataMap()
    {
        return $this->map;
    }

    public function setDataMap(array $map)
    {
        $this->map = $map;
    }
}
