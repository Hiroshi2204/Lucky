<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    protected $table = 'producto';
    protected $fillable = array(
                            'nom_producto',
                            'cod_producto',
                            'color',
                            //'lote',
                            'origen',
                            'peso_neto',
                            //'marca_id',
                            'estado_registro',
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    // public function marca(){
    //     return $this->belongsTo(Marca::class,'marca_id','id');
    // }
    public function registro_entreda_detalle(){
        return $this->belongsTo(RegistroEntradaDetalle::class,'id','producto_id');
    }
}
