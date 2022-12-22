<?php
namespace Controllers;

use Model\Usuario;
use MVC\Router;
use Classes\Email;



class LoginController
{
    public static function login(Router $router)
    {
        
        $auth = new Usuario;
        if($_SERVER['REQUEST_METHOD']==='POST'){
            $auth = new Usuario($_POST);
            $alertas=$auth->validarLogin();
            
            if(empty($alertas)){
                //Comprobar que exista el usuario
                $usuario = Usuario::where('email', $auth->email);

                if($usuario){
                    //verificar el pasword
                    if($usuario->comporbarPasswordAndVerificado($auth->password)){
                        session_start();
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;

                        //Redireccinamiento
                        if($usuario->admin==="1"){
                            $_SESSION['admin'] = $usuario->admin ?? null;
                            header("Location: /admin");
                        }else{
                            header("Location: /cita");
                        }
                    }
                }else{
                    Usuario::setAlerta('error', 'Usuario no encontrado');
                }
            }
        }

        $alertas = Usuario::getAlertas();
        $router->render('auth/login',['alertas'=>$alertas]);
    }

    public static function logout()
    {
        session_start();
        $_SESSION = [];
        header('Location: /');
    }

    public static function olvide(Router $router)
    {
        $alertas = [];
        if($_SERVER['REQUEST_METHOD']==='POST'){
            $auth = new Usuario($_POST);
            $alertas = $auth->validarEmail();
            if(empty($alertas)){
                $usuario = Usuario::where('email', $auth->email);
                if($usuario && $usuario->confirmado==="1"){
                    //Generar un token
                    $usuario->crearToken();
                    $usuario->guardar();
                    //enviar el E-mail
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarInstrucciones();
                    //Alerta de exito
                    Usuario::setAlerta('exito', 'Revisa tu E-mail0');
                   
                }else{
                    Usuario::setAlerta('error', 'El usuario no existe o no esta confirmado');
                    
                }
            }
        }
        $alertas = Usuario::getAlertas();
        $router->render('auth/olvide-password',['alertas'=>$alertas]);
    }

    public static function recuperar(Router $router)
    {
        $alertas = [];
        $error = false;
        $token = s($_GET['token']);
        //Buscar Uusario por token
        $usuario = Usuario::where('token', $token);
        if(empty($usuario)){
            Usuario::setAlerta('error', 'Token no valido');
            $error=true;
        }

        if($_SERVER['REQUEST_METHOD']==='POST'){
            //Leer el nuevo password y guardarlo
            $password = new Usuario($_POST);
            $password->validarPaassword();

            if(empty($alertas)){
                $usuario->password = null;
                $usuario->password = $password->password;
                $usuario->hashPassword();
                $usuario->token = null;
               $resultado= $usuario->guardar();
               if($resultado){
                    header('Location: /');
               }
            }
        }

        $alertas = Usuario::getAlertas();
        $router->render('auth/recuperar-password',['alertas'=>$alertas,'error'=>$error]);
    }

    public static function crear(Router $router)
    {
        $usuario = new Usuario;
        //alertasv vacias
        $alertas = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();

            //revisar que alerta este vacio
            if (empty($alertas)) {
                //verificar que usuario no este registrado
                $resultado = $usuario->existeUsuario();
                if ($resultado->num_rows) {
                    $alertas = Usuario::getAlertas();
                } else {
                    //Hasear el Password
                    $usuario->hashPassword();

                    //Generar un Token único
                    $usuario->crearToken();

                    //Eniar el email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarConfirmacion();

                    //Crear el usuario
                    $resultado = $usuario->guardar();
                    if ($resultado) {
                        header('Location: /mensaje');


                    }

                }
            }
        }
        $router->render('auth/crear-cuenta', ['usuario' => $usuario, 'alertas' => $alertas]);
    }
    public static function mensaje(Router $router)
    {
        $router->render('auth/mensaje');
    }

    public static function confirmar(Router $router)
    {
        $alertas = [];
        //Sanitiza el token para no aceptar codigo malicioso
        $token = s($_GET['token']);

        $usuario = Usuario::where('token', $token);
        if (empty($usuario)) {
            //Mostrar error 
            Usuario::setAlerta('error', 'Token no valido');

        } else {
            //Modificar a usuario confirmado
            $usuario->confirmado = "1";
            $usuario->token = null;
            $usuario->guardar();
            Usuario::setAlerta('exito', 'Cuenta comprobada Correctamente');
        }
        //Obtener alertas
        $alertas = Usuario::getAlertas();
        //Renderizar la vista
        $router->render('auth/confirmar-cuenta', ['alertas' => $alertas]);

    }

}