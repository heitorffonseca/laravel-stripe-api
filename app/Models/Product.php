<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Laravel\Cashier\Cashier;
use Stripe\Exception\ApiErrorException;
use Stripe\Price;

/**
 * Class Product
 * @package App\Models
 *
 * @property string $sid
 * @property string $name
 * @property string $description
 * @property string $pid
 * @property array $price
 * @property boolean $active
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'sid',
        'name',
        'description',
        'pid',
        'active'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * @throws ApiErrorException
     */
    public function getPriceAttribute(): Price
    {
        return Cashier::stripe()
            ->prices
            ->retrieve($this->pid);
    }
}
