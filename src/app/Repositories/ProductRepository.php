<?php


namespace App\Repositories;


use App\Product;

abstract class ProductRepository implements ProductRepositoryInterface
{
    /**
     * @var Product
     */
    private $product;
    public $instock;
    public $outstock;

    /**
     * Set Retrieved Products Model
     * @param Product $product
     * @return ProductRepository
     */
    public function setProduct(Product $product)
    {
        $this->product = $product;
        return $this;
    }

    /**
     * get all products
     * @return array
     */
    public function all(): array
    {
        return $this->getMappedProducts($this->product->all());
    }

    /**
     * get Filtered products
     * @param array $filters
     * @return array
     */
    public function get(array $filters = []): array
    {
        // Return all on empty $filter to avoid unneeded loop
        if (empty($filters)) {
            return $this->all();
        }

        // TODO::To be optimized
        $products = array_filter($this->product->all(), function ($item) use ($filters) {
            $matched = true;

            // Filter products by currency
            if (!empty($filters['currency'])) {
                $matched &= $item[$this->map()['currency']] == $filters['currency'];
            }

            // Filter products by status
            if ($matched && !empty($filters['statusCode'])) {
                $matched &= $item[$this->map()['status']] == $this->{$filters['statusCode']};
            }

            // Filter products by minimum balance
            if ($matched && !empty($filters['balanceMin'])) {
                $matched &= $item[$this->map()['currentPrice']] >= $filters['balanceMin'];
            }

            // Filter products by maximum balance
            if ($matched && !empty($filters['balanceMax'])) {
                $matched &= $item[$this->map()['currentPrice']] <= $filters['balanceMax'];
            }

            return $matched;
        });

        // Mapping after filtering the products
        return $this->getMappedProducts($products);
    }

    /**
     * Map products based on the map returned from each data source
     *
     * @param array $products
     * @return array
     */
    protected function getMappedProducts(array $products): array
    {
        return array_map([$this, 'getMappedProduct'], $products) ?? [];
    }

    /**
     * Map product based on the map returned from each data source
     *
     * @param $item
     * @return array
     */
    protected function getMappedProduct(array $item): array
    {
        $product = [];
        foreach ($this->map() as $index => $value) {
            $product[$index] = $item[$value];
        }

        return $product;
    }

    /**
     * Product Map based on data source indexes
     * @return array
     */
    abstract protected function map(): array;
}
