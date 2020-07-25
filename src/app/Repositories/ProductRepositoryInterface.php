<?php


namespace App\Repositories;


use App\Product;

interface ProductRepositoryInterface
{
    public function setProduct(Product $product);

    /**
     * get all products
     * @return array
     */
    public function all(): array;
}
