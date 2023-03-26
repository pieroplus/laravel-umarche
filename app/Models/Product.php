<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\SecondaryCategory;
use App\Models\Shop;
use App\Models\Image;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop_id',
        'name',
        'information',
        'price',
        'is_selling',
        'sort_order',
        'secondary_category_id',
        'image1',
        'image2',
        'image3',
        'image4',
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

    public function imageSecond()
    {
        return $this->belongsTo(Image::class, 'image2', 'id');
    }

    public function imageThird()
    {
        return $this->belongsTo(Image::class, 'image3', 'id');
    }

    public function imageFourth()
    {
        return $this->belongsTo(Image::class, 'image4', 'id');
    }

    public function stock(): HasMany
    {
        return $this->hasMany(Stock::class);
    }

public function users(): BelongsToMany
{
    return $this->belongsToMany(User::class, 'carts')
        ->withPivot(['id', 'quantity']);
}
}
