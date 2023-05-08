<?php

namespace App\Http\Controllers;

use App\Http\Requests\PriceRequest;
use App\Models\Repositories\PriceRepositoryInterface;
use Illuminate\Http\Request;

class PriceController extends Controller
{
    protected $priceRepository;

    public function __construct(PriceRepositoryInterface $priceRepository)
    {
        $this->priceRepository = $priceRepository;
    }

    public function create($productId)
    {
        $product = $this->priceRepository->getById($productId);
        return view('prices.create', compact('product'));
    }

    public function store(PriceRequest $request, $productId)
    {
        $this->priceRepository->create($productId, $request->validated());
        return redirect()->route('products.show', $productId)->with('success', 'Price added successfully.');
    }

    public function edit($productId, $priceId)
    {
        $price = $this->priceRepository->getById($priceId);
        return view('prices.edit', compact('price'));
    }

    // public function update(PriceRequest $request, $productId, $priceId)
    // {
    //     $this->priceRepository->update($priceId, $request->validated());
    //     return redirect()->route('products.show', $productId)->with('success', 'Price updated successfully.');
    // }

    public function destroy($productId, $priceId)
    {
        $this->priceRepository->delete($priceId);
        return redirect()->route('products.show', $productId)->with('success', 'Price deleted successfully.');
    }
}
