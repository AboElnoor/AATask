<?php


namespace App\Repositories;


use App\Product;

class ProductXRepository extends ProductRepository
{
    public $instock = 1;
    public $outstock = 2;

    /**
     * Product Map based on data source indexes
     * @return array
     */
    protected function map(): array {
        return [
            'id' => 'ProductIdentification',
            'name' => 'ProductName',
            'currency' => 'ProductCurrency',
            'originalPrice' => 'ProductOriginalPrice',
            'currentPrice' => 'ProductCurrentPrice',
            'status' => 'StatusCode',
            'includeVAT' => 'IncludeVAT',
            'endDate' => 'OfferEndDate',
        ];
    }
}
