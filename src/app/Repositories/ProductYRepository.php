<?php


namespace App\Repositories;


use App\Product;

class ProductYRepository extends ProductRepository
{
    public $instock = 1; //TODO::To be changed to 100
    public $outstock = 2; //TODO::To be changed to 200

    /**
     * Product Map based on data source indexes
     * @return array
     */
    protected function map(): array {
        return [
            'id' => 'id',
            'name' => 'name',
            'currency' => 'currency',
            'originalPrice' => 'original_price',
            'currentPrice' => 'current_price',
            'status' => 'status',
            'includeVAT' => 'include_VAT',
            'endDate' => 'end_date',
        ];
    }
}
