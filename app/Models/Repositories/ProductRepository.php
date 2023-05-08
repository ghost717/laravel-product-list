<?php

namespace App\Models\Repositories;

use App\Models\Price;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Repositories\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    protected float $price = 0; 

    public function getAll(): Collection
    {
        return Product::all();
    }

    public function getById(int $id): ?Product
    {
        return Product::find($id);
    }

    public function create(array $data): Product
    {
        $newProduct = [
            'name' => $data['name'],
            'description' => (isset($data['description'])) ? $data['description'] : '',
        ];
        $product = Product::create($newProduct);

        if (isset($data['price'])) {
            Price::create([
                'product_id' => $product->id,
                'price' => number_format(floatval($data['price']), 2),
            ]);
        }

        return $product;
    }

    public function update(int $id, array $data): Product
    {
        $product = Product::find($id);
        $product->name = $data['name'];
        $product->description = (isset($data['description'])) ? $data['description'] : '';
        $product->save();

        $this->price = 0;
        if (isset($data['price'])) {
            $this->price = number_format(floatval($data['price']), 2);
            $priceObj = Price::where([['product_id', '=', $product->id], ['price', '=', $this->price]])->exists();

            if (!$priceObj) {
                $price = new Price();
                $price->product_id = $product->id;
                $price->price = $this->price;
                $price->save();
            }
        }

        return $product;
    }

    public function delete(int $id): bool
    {
        $product = new Product();
        return $product->where('id', $id)->delete();
    }
}
