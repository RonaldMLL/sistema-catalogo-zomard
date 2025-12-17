<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'provider_id', 
        'product_id', 
        'quantity', 
        'unit_cost', 
        'purchase_date'
    ];

    // Relación: Una compra pertenece a un Proveedor
    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    // Relación: Una compra es de un Producto
    public function product()
    {
        // Usamos withTrashed por si compraste un producto que luego borraste
        return $this->belongsTo(Product::class)->withTrashed();
    }
}