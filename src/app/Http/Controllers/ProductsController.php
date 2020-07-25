<?php

namespace App\Http\Controllers;


use App\Product;
use App\Repositories\ProductXRepository;
use App\Repositories\ProductYRepository;

class ProductsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index()
    {
        $products = $this->getProductsByProviders();

        return $products;
    }

    protected function getProductsByProviders()
    {
        $productXCollection = [];
        $productYCollection = [];

        switch ($provider = request('provider', null)) {
            case null:

            case 'DataProviderX':
                $productX = new Product(env('DataProviderX'));
                $productXCollection = (new ProductXRepository())->setProduct($productX)->get(request()->except('provider'));
                if ($provider) break;

            case 'DataProviderY':
                $productY = new Product(env('DataProviderY'));
                $productYCollection = (new ProductYRepository())->setProduct($productY)->get(request()->except('provider'));
        }

        return array_merge($productXCollection, $productYCollection);
    }
}
