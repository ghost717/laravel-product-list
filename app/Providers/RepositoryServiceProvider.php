<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Repositories\ProductRepositoryInterface;
use App\Models\Repositories\PriceRepositoryInterface;
use App\Models\Repositories\ProductRepository;
use App\Models\Repositories\PriceRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(PriceRepositoryInterface::class, PriceRepository::class);
    }
}
