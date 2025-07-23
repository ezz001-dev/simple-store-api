<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderDetail extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
    ];

    /**
     * Mendefinisikan relasi "belongsTo" ke model Order.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Mendefinisikan relasi "belongsTo" ke model Product.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
