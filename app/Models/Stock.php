<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'product', // Add the 'product' field here
        'price',
        'service',
        'date',
        'Quantity',
        'desc',
    ];

    public $timestamps = false;
    public function demande(): BelongsTo
    {
        return $this->belongsTo(Stock::class);
    }
}
