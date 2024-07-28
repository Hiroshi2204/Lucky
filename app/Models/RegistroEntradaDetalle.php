<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroEntradaDetalle extends Model
{
    use HasFactory;
    protected $table = 'registro_entrada_detalle';
    protected $fillable = array(
                            'producto_id',
                            //'origen',
                            'peso_neto',
                            'precio',
                            'largo',
                            'lote',
                            'registro_entrada_id'
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function producto(){
        return $this->belongsTo(Producto::class,'producto_id','id');
    }
    public function registro_entrada(){
        return $this->belongsTo(RegistroEntrada::class,'registro_entrada_id','id');
    }
}
