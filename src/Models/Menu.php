<?php declare(strict_types = 1);

namespace App\Models;

use App\DTO\Menu as MenuDTO;
use App\DTO\Product as ProductDTO;
use App\GreatFoodLtd\Menus;

final class Menu
{
    private Menus $menuClient;

    public function __construct(Menus $menus)
    {
        $this->menuClient = $menus;
    }

    protected function getMenuByMenuName(string $menuName): ?MenuDTO
    {
        $menus = $this->menuClient->getMenus();

        if ($menus === null) {
            return null;
        }

        foreach ($menus as $menu) {
            if ($menuName === $menu->name) {
                return $menu;
            }
        }

        return null;
    }

    public function getProductsByMenuName(string $menuName): ?array
    {
        $ourMenu = $this->getMenuByMenuName($menuName);

        if ($ourMenu === null) {
            return null;
        }

        $products = $this->menuClient->getMenuProducts($ourMenu->id);

        return $products ?? null;
    }

    public function updateProductName(int $menuId, int $productId, ProductDTO $product): ?ProductDTO
    {
        return $this->menuClient->updateProductByMenu($menuId, $productId, $product);
    }
}
