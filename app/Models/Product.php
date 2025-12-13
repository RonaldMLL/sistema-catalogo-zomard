<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // ESTA ES LA LÍNEA QUE TE FALTA:
    // Aquí autorizamos qué campos se pueden guardar desde el formulario
    protected $fillable = [
        'name', 
        'description', 
        'price', 
        'stock', 
        'image_path',
        'category_id'
    ];
    // 2. Relación: Un producto PERTENECE A una categoría
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}