<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    // ESTA ES LA LÍNEA QUE FALTA O ESTÁ INCOMPLETA:
    protected $fillable = ['client_id', 'sale_date', 'status', 'total'];

    // Relación con Cliente
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // Relación con Detalles
    public function details()
    {
        return $this->hasMany(SaleDetail::class);
    }
}