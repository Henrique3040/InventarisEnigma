<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Producten extends Model
{
    use HasFactory;

    public function category()
    {
    return $this->belongsTo(Category::class);
    }
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'producten';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_name',
        'quantity',
        'category_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'quantity' => 'integer',
    ];
}
