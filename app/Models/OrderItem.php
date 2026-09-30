<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    protected $table = 'order_items';

    protected $fillable = [
        'order_id',
        'food_id',
        'quantity',
        'subtotal',
    ];

    public function food(): BelongsTo
    {
        return $this->belongsTo(Food::class);
    }
}
