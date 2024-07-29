<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroSalidaDetalle extends Model
{
    use HasFactory;
    protected $table = 'registro_salida_detalle';
    protected $fillable = array(
                            'producto_id',
                            //'peso_neto',
                            'precio',
                            'largo',
                            'registro_salida_id'
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function producto(){
        return $this->belongsTo(Producto::class,'producto_id','id');
    }
    public function registro_salida(){
        return $this->belongsTo(RegistroSalida::class,'registro_salida_id','id');
    }
}
