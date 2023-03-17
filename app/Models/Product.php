<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\SecondaryCategory;
use App\Models\Shop;
use App\Models\Image;
use App\Models\Stock;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [

    ];

    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(SecondaryCategory::class, 'secondary_category_id');
    }

    public function imageFirst(): BelongsTo
    {
        return $this->belongsTo(Image::class, 'image1', 'id');
    }

    public function stock(): HasMany
    {
        return $this->hasMany(Stock::class);
    }
}