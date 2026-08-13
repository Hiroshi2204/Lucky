<?php

namespace App\Http\Controllers;

use App\Models\AlmacenProducto;
use App\Models\Destinatario;
use App\Models\EgresosAdicionales;
use App\Models\Persona;
use App\Models\Producto;
use App\Models\ProductoDetalle;
use App\Models\Proveedor;
use App\Models\RegistroEntrada;
use App\Models\RegistroEntradaDetalle;
use App\Models\RegistroSalida;
use App\Models\RegistroSalidaDetalle;
use App\Models\Trabajador;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
//use Auth;
use Illuminate\Support\Facades\Auth as Auth;
use Illuminate\Support\Facades\DB;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth as FacadesJWTAuth;
use PHPOpenSourceSaver\JWTAuth\JWTAuth;

class LoginController extends Controller
{
    

}
