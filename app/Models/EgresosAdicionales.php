<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EgresosAdicionales extends Model
{
    use HasFactory;
    protected $table = 'egresos_adicionales';
    protected $fillable = array(
                            'empresa_id',
                            'descripcion',
                            'costo',
                            'fecha_egreso'
                        );
    protected $primaryKey = 'id';
    protected $hidden = [
        'created_at', 'updated_at','deleted_at'
    ];
    public function empresa(){
        return $this->belongsTo(Empresa::class,'empresa_id','id');
    }
}
