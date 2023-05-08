<?php

namespace App\Models\Repositories;

use App\Models\Price;
use App\Models\Repositories\PriceRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class PriceRepository implements PriceRepositoryInterface
{
    public function getAll(): Collection
    {
        return Price::all();
    }

    public function getById(int $id): ?Price
    {
        return Price::find($id);
    }

    public function create(Price $price): bool
    {
        return $price->save();
    }

    public function delete(Price $price): bool
    {
        return $price->delete();
    }
}
