<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;


class product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'unit_type',
        'price',
        'discount_percentage',
        'discount_amount',
        'discount_start_date',
        'discount_end_date',
        'tax_percentage',
        'tax_amount',
    ];

    public function stockEntries()
    {
        return $this->hasOne(StockEntry::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
