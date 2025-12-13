<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $fillable = ['name'];

    // Relación: Una categoría TIENE MUCHOS productos
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
