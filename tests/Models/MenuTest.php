<?php declare(strict_types=1);

namespace Tests\Models;

use App\DTO\Menu as MenuDTO;
use App\DTO\Product;
use App\DTO\Product as ProductDTO;
use App\GreatFoodLtd\Menus;
use App\Models\Menu;
use PHPUnit\Framework\TestCase;

class MenuTest extends TestCase
{
    public function testGetProductsByMenuNameOnSuccess(): void
    {
        $menuClientMock = $this->createMock(Menus::class);

        $menu = new MenuDTO(
            3,
            'Takeaway'
        );

        $product1 = new ProductDTO(
            1,
            'Burger'
        );
        $product2 = new ProductDTO(
            2,
            'Chips'
        );
        $product3 = new ProductDTO(
            3,
            'Lasagna'
        );
        $products = [
            $product1,
            $product2,
            $product3
        ];
        $menuClientMock->expects($this->once())
            ->method('getMenus')
            ->willReturn([$menu]);

        $menuClientMock->expects($this->once())
            ->method('getMenuProducts')
            ->willReturn($products);


        $menuModel = new Menu($menuClientMock);
        $products = $menuModel->getProductsByMenuName('Takeaway');

        $this->assertNotNull($products);
        $this->assertIsArray($products);

        $this->assertSame($product1->id, $products[0]->id);
        $this->assertSame($product1->name, $products[0]->name);
        $this->assertSame($product2->id, $products[1]->id);
        $this->assertSame($product2->name, $products[1]->name);
        $this->assertSame($product3->id, $products[2]->id);
        $this->assertSame($product3->name, $products[2]->name);
    }

    public function testGetProductsByMenuNameOnNullMenus(): void
    {
        $menuClientMock = $this->createMock(Menus::class);

        $menuClientMock->expects($this->once())
            ->method('getMenus')
            ->willReturn(null);


        $menuModel = new Menu($menuClientMock);
        $products = $menuModel->getProductsByMenuName('Takeaway');

        $this->assertNull($products);
    }

    public function testGetProductsByMenuNameOnNoMenu(): void
    {
        $menuClientMock = $this->createMock(Menus::class);

        $menu = new MenuDTO(
            9999,
            'FrenchMenu'
        );

        $menuClientMock->expects($this->once())
            ->method('getMenus')
            ->willReturn([$menu]);


        $menuModel = new Menu($menuClientMock);
        $products = $menuModel->getProductsByMenuName('Takeaway');

        $this->assertNull($products);
    }

    public function testGetProductsByMenuNameOnNoProducts(): void
    {
        $menuClientMock = $this->createMock(Menus::class);

        $menu = new MenuDTO(
            3,
            'Takeaway'
        );

        $menuClientMock->expects($this->once())
            ->method('getMenus')
            ->willReturn([$menu]);

        $menuClientMock->expects($this->once())
            ->method('getMenuProducts')
            ->willReturn(null);


        $menuModel = new Menu($menuClientMock);
        $products = $menuModel->getProductsByMenuName('Takeaway');

        $this->assertNull($products);
    }

    public function testUpdateProductNameOnSuccess(): void
    {
        $menuClientMock = $this->createMock(Menus::class);

        $productDTO = new Product(
            null,
            'Chips'
        );

        $menuClientMock->expects($this->once())
            ->method('updateProductByMenu')
            ->willReturn($productDTO);

        $menuModel = new Menu($menuClientMock);
        $product = $menuModel->updateProductName(7, 84, $productDTO);
        $this->assertSame('Chips', $product->name);
    }
}
