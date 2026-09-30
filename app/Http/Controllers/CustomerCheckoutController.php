<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerCheckoutController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'table_number' => ['required', 'string', 'max:50'],
            'items' => ['required', 'array'],
            'items.*' => ['integer', 'min:0'],
        ]);

        $items = collect($validated['items'] ?? [])
            ->filter(fn ($quantity) => (int) $quantity > 0)
            ->all();

        if ($items === []) {
            return back()->withErrors(['items' => 'Pilih minimal 1 menu dengan jumlah lebih dari 0.']);
        }

        $foodItems = \App\Models\Food::query()->whereIn('id', array_keys($items))->get()->keyBy('id');

        $total = 0;
        $orderItems = [];

        foreach ($items as $foodId => $quantity) {
            $food = $foodItems->get($foodId);

            if (! $food) {
                continue;
            }

            $subtotal = $food->price * (int) $quantity;
            $total += $subtotal;

            $orderItems[] = [
                'food_id' => (int) $foodId,
                'quantity' => (int) $quantity,
                'subtotal' => $subtotal,
            ];
        }

        if ($orderItems === []) {
            return back()->withErrors(['items' => 'Pilih minimal 1 menu yang valid untuk dipesan.']);
        }

        try {
            DB::transaction(function () use ($validated, $total, $orderItems) {
                $order = Order::query()->create([
                    'customer_name' => $validated['customer_name'],
                    'table_number' => $validated['table_number'],
                    'total_price' => $total,
                    'status' => 'pending',
                ]);

                foreach ($orderItems as $item) {
                    $order->items()->create($item);
                }
            });
        } catch (\Throwable $th) {
            return back()->withErrors(['items' => 'Pesanan gagal diproses. Silakan coba lagi.']);
        }

        return redirect()->route('home')->with('success', 'Pesanan berhasil dikirim. Terima kasih!');
    }
}
