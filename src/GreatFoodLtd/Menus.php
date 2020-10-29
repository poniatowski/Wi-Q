<?php declare(strict_types = 1);

namespace App\GreatFoodLtd;

use App\DTO\Menu;
use App\DTO\Product;
use GuzzleHttp\Exception\GuzzleException;

class Menus extends Client
{
    public function getMenus(): ?array
    {
        try {
            $response = $this->client->request('GET', '/menus', [
                'headers' => [
                    'Authorization' => $this->getAuthHeader()
                ]
            ]);

            $menus = json_decode($response->getContents(), true);

            $response = [];
            foreach ($menus['data'] as $menu) {
                $response[] = new Menu(
                    $menu['id'],
                    $menu['name']
                );
            }

            return $response;
        } catch (GuzzleException $e) {
        }

        return null;
    }

    public function getMenuProducts(int $menuId): ?array
    {
        try {
            $uri = sprintf('/menus/%d/products', $menuId);

            $response = $this->client->request('GET', $uri, [
                'headers' => [
                    'Authorization' => $this->getAuthHeader()
                ]
            ]);

            $products = json_decode($response->getContents(), true);

            $response = [];
            foreach ($products['data'] as $product) {
                $response[] = new Product(
                    $product['id'],
                    $product['name']
                );
            }

            return $response;
        } catch (GuzzleException $e) {
        }

        return null;
    }

    public function updateProductByMenu(int $menuId, int $productId, Product $product): ?Product
    {
        try {
            $uri = sprintf('/menus/%d/product/%d', $menuId, $productId);

            $this->client->request('PUT', $uri, [
                'headers' => [
                    'Authorization' => $this->getAuthHeader()
                ],
                'json' => [
                    'name' => $product->name
                ]
            ]);

            return $product;
        } catch (GuzzleException $e) {
        }
    }
}
