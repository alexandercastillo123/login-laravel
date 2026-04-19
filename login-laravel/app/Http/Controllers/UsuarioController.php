<?php

namespace App\Http\Controllers;
// :(
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\RecuperacionMail;
use Laravel\Socialite\Facades\Socialite;

class UsuarioController extends Controller
{
    public function registrar(Request $request)
    {
        try {
            // Reglas de negocio: Validar duplicados
            $existeEmail = DB::table('usuarios')->where('email', $request->email)->exists();
            if ($existeEmail) {
                return response()->json(['res' => false, 'msg' => 'El correo electrónico ya se encuentra registrado'], 400);
            }

            $existeDNI = DB::table('usuarios')->where('dni', $request->dni)->exists();
            if ($existeDNI) {
                return response()->json(['res' => false, 'msg' => 'El DNI ya se encuentra registrado'], 400);
            }

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
            $usuario = $resultado[0];
            session(['usuario' => $usuario]);
            
            return response()->json(['res' => true, 'usuario' => $usuario]);
        }
        return response()->json(['res' => false, 'msg' => 'Credenciales incorrectas'], 401);
    }

    public function listar()
    {
        $usuarios = DB::select('CALL sp_ListarUsuarios()');
        return response()->json($usuarios);
    }

    public function obtenerPerfil(Request $request)
    {
        $usuario = session('usuario');
        if (!$usuario) {
            return response()->json(['msg' => 'No autorizado'], 401);
        }

        $id = null;
        if (is_object($usuario)) {
            $id = $usuario->id ?? $usuario->idUsuario ?? null;
        } else if (is_array($usuario)) {
            $id = $usuario['id'] ?? $usuario['idUsuario'] ?? null;
        }

        if (!$id) {
            return response()->json(['msg' => 'ID de sesión no encontrado'], 401);
        }

        $datos = DB::select('CALL sp_ObtenerUsuario(?)', [$id]);
        
        if (!empty($datos)) {
            $resultado = (array)$datos[0];
            $resultado['id'] = $id;
            return response()->json($resultado);
        }
        return response()->json(['msg' => 'Usuario no encontrado'], 404);
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
            $usuarioSession = session('usuario');
            $idSesion = isset($usuarioSession->id) ? $usuarioSession->id : ($usuarioSession->idUsuario ?? null);
            
            $idActualizar = (!empty($id) && $id != "undefined") ? $id : $idSesion;

            if (!$idActualizar) {
                return response()->json(['res' => false, 'msg' => 'ID de usuario no identificado.']);
            }

            $usuarioActual = DB::table('usuarios')->where('id', $idActualizar)->first();
            if (!$usuarioActual) {
                return response()->json(['res' => false, 'msg' => 'Usuario no encontrado en la base de datos (ID: '.$idActualizar.')']);
            }

            $password = !empty($request->pass) ? $request->pass : $usuarioActual->pass;

            DB::select('CALL sp_ActualizarUsuario(?, ?, ?, ?, ?, ?)', [
                $idActualizar,
                $request->nombres,
                $request->apellidos,
                $request->dni,
                $request->email,
                $password
            ]);
            return response()->json(['res' => true]);
        } catch (\Exception $e) {
            return response()->json(['res' => false, 'msg' => $e->getMessage()], 500);
        }
    }

    public function generarCodigo(Request $request)
    {
        $resultado = DB::select('CALL sp_GenerarCodigoRecuperacion(?, ?)', [
            $request->email,
            $request->codigo
        ]);

        if ($resultado[0]->resultado == 1) {
            try {
                Mail::to($request->email)->send(new RecuperacionMail($request->codigo));
            } catch (\Exception $e) {
                return response()->json(['resultado' => 1, 'email_error' => $e->getMessage()]);
            }
        }

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

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $usuario = DB::table('usuarios')
                ->where('google_id', $googleUser->id)
                ->orWhere('email', $googleUser->email)
                ->first();

            if ($usuario) {
                if (!$usuario->google_id) {
                    DB::table('usuarios')
                        ->where('id', $usuario->id)
                        ->update(['google_id' => $googleUser->id]);
                }
            } else {
                $partesNombre = explode(' ', $googleUser->name, 2);
                $nombres = $partesNombre[0];
                $apellidos = $partesNombre[1] ?? ' ';

                $idNuevo = DB::table('usuarios')->insertGetId([
                    'nombres' => $nombres,
                    'apellidos' => $apellidos,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'dni' => null,
                    'pass' => null
                ]);

                $usuario = DB::table('usuarios')->where('id', $idNuevo)->first();
            }

            session(['usuario' => $usuario]);

            return redirect('/home');

        } catch (\Exception $e) {
            return redirect('/')->with('error', 'Error al autenticar con Google: ' . $e->getMessage());
        }
    }
}
