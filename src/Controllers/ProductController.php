<?php declare(strict_types = 1);

namespace App\Controllers;

use App\DTO\Product;
use App\Models\Menu;

class ProductController
{
    private Menu $menuModel;

    public function __construct(Menu $menuModel)
    {
        $this->menuModel = $menuModel;
    }

    public function getAction(): void
    {
        $this->menuModel->getProductsByMenuName('Takeaway');
    }

    public function putAction(): void
    {
        $productDTO = new Product(
            null,
            'Chips'
        );
        $this->menuModel->updateProductName(7, 84, $productDTO);
    }
}