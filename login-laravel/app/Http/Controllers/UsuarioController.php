<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class UsuarioController extends Controller
{
    public function registrar(Request $request)
    {
        try {
            DB::select('CALL sp_RegistrarUsuario(?, ?, ?, ?, ?)', [
                $request->nombres,
                $request->apellidos,
                $request->dni,
                $request->email,
                $request->pass
            ]);
            return response()->json(['res' => true, 'msg' => 'Registrado correctamente']);
        } catch (\Exception $e) {
            return response()->json(['res' => false, 'msg' => $e->getMessage()], 500);
        }
    }

    public function login(Request $request)
    {
        $resultado = DB::select('CALL sp_Logeandote(?, ?)', [
            $request->email,
            $request->pass
        ]);

        if (!empty($resultado)) {
            return response()->json(['res' => true, 'usuario' => $resultado[0]]);
        }
        return response()->json(['res' => false, 'msg' => 'Credenciales incorrectas'], 401);
    }

    public function listar()
    {
        $usuarios = DB::select('CALL sp_ListarUsuarios()');
        return response()->json($usuarios);
    }

    public function obtenerPorId($id)
    {
        $usuario = DB::select('CALL sp_ObtenerUsuario(?)', [$id]);
        if (!empty($usuario)) {
            return response()->json($usuario[0]);
        }
        return response()->json(['msg' => 'No encontrado'], 404);
    }

    public function actualizar(Request $request, $id)
    {
        try {
            DB::select('CALL sp_ActualizarUsuario(?, ?, ?, ?, ?, ?)', [
                $id,
                $request->nombres,
                $request->apellidos,
                $request->dni,
                $request->email,
                $request->pass
            ]);
            return response()->json(['res' => true]);
        } catch (\Exception $e) {
            return response()->json(['res' => false], 500);
        }
    }

    public function generarCodigo(Request $request)
    {
        $resultado = DB::select('CALL sp_GenerarCodigoRecuperacion(?, ?)', [
            $request->email,
            $request->codigo
        ]);
        return response()->json(['resultado' => $resultado[0]->resultado]);
    }

    public function restablecer(Request $request)
    {
        $resultado = DB::select('CALL sp_RestablecerPass(?, ?, ?)', [
            $request->email,
            $request->codigo,
            $request->nuevaPass
        ]);
        return response()->json(['resultado' => $resultado[0]->resultado]);
    }

    public function cerrar_sesion(Request $request)
    {
        $request->session()->flush();

        return response()->json(['res' => true,'msg' => 'Sesión cerrada']);
    }
}
