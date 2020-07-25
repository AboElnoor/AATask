<?php

namespace App;


use Illuminate\Support\Collection;


class Product
{
    /**
     * @var string
     */
    private $dataSource;

    public function __construct(string $dataSource)
    {
        $this->dataSource = $dataSource;
    }

    public function all(): array
    {
        return json_decode(file_get_contents($this->dataSource), true) ?? [];
    }
}
