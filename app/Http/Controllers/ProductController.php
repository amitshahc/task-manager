<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * The file where products are stored.
     * This file is used to read and write product data.
     * @var string
     * It must be storage/app/private by default
     */
    private $file = 'products.json';

    /**
     * Display a listing of the products.
     * This method is used to retrieve and display all products.
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $products = [];

        if (Storage::exists($this->file)) {
            $fileContents = Storage::get($this->file);
            $products = json_decode($fileContents, true) ?? [];
        }

        usort($products, function ($a, $b) {
            return strtotime($b['datetime']) <=> strtotime($a['datetime']);
        });

        return view('product', compact('products'));
    }

    /**
     * Store a newly created product in storage.
     * This method is used to add a new product entry.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string',
            'quantity' => 'required|integer|min:0',
            'price'    => 'required|numeric|min:0',
        ]);

        $entry = [
            'id'       => uniqid(),
            'name'     => $request->input('name'),
            'quantity' => (int) $request->input('quantity'),
            'price'    => (float) $request->input('price'),
            'datetime' => now()->toDateTimeString(),
        ];
        $entry['total'] = $entry['quantity'] * $entry['price'];

        $allEntries = [];

        if (Storage::exists($this->file)) {
            $existing = Storage::get($this->file);
            $allEntries = json_decode($existing, true) ?? [];
        }

        $allEntries[] = $entry;

        Storage::put($this->file, json_encode($allEntries, JSON_PRETTY_PRINT));

        return response()->json(['success' => true, 'data' => $entry]);
    }

    // Not implemented in the UI yet, but available for API usage
    /**
     * Update an existing product.
     * @param Request $request
     * @param int $id
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'     => 'required|string',
            'quantity' => 'required|integer|min:0',
            'price'    => 'required|numeric|min:0',
        ]);

        if (!Storage::exists($this->file)) {
            return response()->json(['error' => 'No data file found.'], 404);
        }

        $products = json_decode(Storage::get($this->file), true) ?? [];

        foreach ($products as &$product) {
            if ($product['id'] === $id) {
                $product['name']     = $request->input('name');
                $product['quantity'] = (int) $request->input('quantity');
                $product['price']    = (float) $request->input('price');
                $product['total']    = $product['quantity'] * $product['price'];
                $product['datetime'] = now()->toDateTimeString();
                break;
            }
        }

        Storage::put($this->file, json_encode($products, JSON_PRETTY_PRINT));

        return response()->json(['success' => true, 'data' => $products]);
    }
}
