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
    // --- NUEVO: Relación con Pagos ---
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    // --- TRUCO PRO: Calcular cuánto ha pagado ---
    // Esto permite usar $sale->paid_amount en cualquier lado
    public function getPaidAmountAttribute()
    {
        return $this->payments->sum('amount');
    }

    // --- TRUCO PRO: Calcular el saldo (Deuda) ---
    // Esto permite usar $sale->due_amount
    public function getDueAmountAttribute()
    {
        return $this->total - $this->paid_amount;
    }
}