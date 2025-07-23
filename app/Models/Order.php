<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'total_amount',
        'status',
        'payment_method',
    ];

    /**
     * Mendefinisikan relasi "belongsTo" ke model User.
     * Setiap order dimiliki oleh satu user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mendefinisikan relasi "hasMany" ke model OrderDetail.
     * Setiap order memiliki banyak detail item.
     */
    public function details(): HasMany
    {
        return $this->hasMany(OrderDetail::class);
    }
}
