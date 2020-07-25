<?php


class ProductTest extends TestCase
{
    protected $productsX;
    protected $productsY;

    public function SetUp(): void
    {
        parent::SetUp();
        $this->productsX = json_decode(file_get_contents(__DIR__ . '/DataProviderX.json'), true);
        $this->productsY = json_decode(file_get_contents(__DIR__ . '/DataProviderY.json'), true);
    }

    public function testAllProducts()
    {
        $this->get('/api/v1/products');

        $products = array_merge($this->productsX, $this->productsY);

        $this->assertJsonStringEqualsJsonString(
            json_encode($products),
            $this->response->getContent()
        );
    }

    public function testProductsDataProviderFilters()
    {
        $this->get('/api/v1/products?provider=DataProviderX');

        $this->assertJsonStringEqualsJsonString(
            json_encode($this->productsX),
            $this->response->getContent()
        );

        $this->get('/api/v1/products?provider=DataProviderY');

        $this->assertJsonStringEqualsJsonString(
            json_encode($this->productsY),
            $this->response->getContent()
        );
    }

    public function testProductsCurrencyFilter()
    {
        $this->get('/api/v1/products?currency=EGP');

        $this->assertEquals(0, preg_match('/"currency":"(?!EGP).*?"/',$this->response->content()));
    }

    public function testProductsStatusCodeFilterOnProvideX()
    {
        $this->get('/api/v1/products?provider=DataProviderX&statusCode=instock');
        $instock = (new \App\Repositories\ProductXRepository())->instock;

        $this->assertEquals(0, preg_match("/\"status\":(?!$instock).*?,/", $this->response->content()));


        $this->get('/api/v1/products?provider=DataProviderX&statusCode=outstock');
        $outstock = (new \App\Repositories\ProductXRepository())->outstock;

        $this->assertEquals(0, preg_match("/\"status\":(?!$outstock).*?/",$this->response->content()));
    }

    public function testProductsStatusCodeFilterOnProvideY()
    {
        $this->get('/api/v1/products?provider=DataProviderY&statusCode=instock');
        $instock = (new \App\Repositories\ProductYRepository())->instock;

        $this->assertEquals(0, preg_match("/\"status\":(?!$instock).*?,/", $this->response->content()));


        $this->get('/api/v1/products?provider=DataProviderY&statusCode=outstock');
        $outstock = (new \App\Repositories\ProductYRepository())->outstock;

        $this->assertEquals(0, preg_match("/\"status\":(?!$outstock).*?/",$this->response->content()));
    }

    public function testProductsBalanceFilter()
    {
        $this->get("/api/v1/products?balanceMin=1000&balanceMax=2000");

        $this->assertEquals(0, preg_match("/\"currentPrice\":\"(?![1-2][0-9][0-9][0-9]\.[0-9][0-9]).*?\"/", $this->response->content()));
    }
}
