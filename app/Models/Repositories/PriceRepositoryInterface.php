<?php

namespace App\Models\Repositories;

use Illuminate\Database\Eloquent\Collection;
use App\Models\Price;

interface PriceRepositoryInterface
{
    public function getAll(): Collection;
    public function getById(int $id): ?Price;
    public function create(Price $price): bool;
    // public function create(array $data): Price;
    public function delete(Price $price): bool;
}
