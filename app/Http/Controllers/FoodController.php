<?php

namespace App\Http\Controllers;

use App\Models\Food;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    public function index()
    {
        $foods = Food::latest()->paginate(10);

        return view('foods.index', compact('foods'));
    }

    public function create()
    {
        return view('foods.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'integer', 'min:0'],
            'description' => ['required', 'string'],
            'image' => ['nullable', 'string', 'max:255'],
            'category' => ['required', 'in:Makanan,Minuman,Cemilan'],
        ]);

        Food::create($validated);

        return redirect()->route('dashboard')->with('success', 'Data makanan berhasil ditambahkan.');
    }

    public function show(Food $food)
    {
        return view('foods.show', compact('food'));
    }

    public function edit(Food $food)
    {
        return view('foods.edit', compact('food'));
    }

    public function update(Request $request, Food $food)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'integer', 'min:0'],
            'description' => ['required', 'string'],
            'image' => ['nullable', 'string', 'max:255'],
            'category' => ['required', 'in:Makanan,Minuman,Cemilan'],
        ]);

        $food->update($validated);

        return redirect()->route('dashboard')->with('success', 'Data makanan berhasil diperbarui.');
    }

    public function destroy(Food $food)
    {
        $food->delete();

        return redirect()->route('dashboard')->with('success', 'Data makanan berhasil dihapus.');
    }
}
