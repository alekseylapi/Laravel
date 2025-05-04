<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $name
 * @property float $price
 * @property Carbon $deleted_at
 */
class Product extends Model
{
    use SoftDeletes;
}
