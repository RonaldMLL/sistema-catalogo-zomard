<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model
{
    use HasFactory;

    protected $fillable = ['sale_id', 'product_id', 'quantity', 'price'];

    // --- ESTA ES LA PARTE QUE TE FALTA O TIENE ERROR ---
    public function product()
    {
        //return $this->belongsTo(Product::class);
        return $this->belongsTo(Product::class)->withTrashed();
    }
}