<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Owner;
use App\Models\Product;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'filename',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class);
    }

    public function product(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
