<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property string $name
 * @property Carbon $deleted_at
 * @property Collection|Product[] $products
 */
class Category extends Model
{
    use SoftDeletes;

    public function products(): HasMany
    {
        return $this->HasMany(Product::class);
    }
}
