<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        // 'image_url',
        'image_path',
    ];

    protected $appends = ['image_url'];


    public function getImageUrlAttribute(): ?string
    {
        if ($this->image_path) {
            // Menggunakan Storage facade 
            return Storage::url($this->image_path);
        }
        return null;
    }
}
