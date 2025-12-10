<?php
session_name("alquiler");
session_start();

require_once 'controller/ClienteController.php';
require_once 'controller/JuegoController.php';
require_once 'controller/AlquilerController.php';

// Obtener cliente si está logueado
$cliente = null;
if(isset($_SESSION['cliente'])){
    $cliente = unserialize($_SESSION['cliente']);
}

// Procesar acciones
$accion = isset($_GET['accion']) ? $_GET['accion'] : 'inicio';

switch($accion){
    case 'login':
        $error = ClienteController::login();
        require_once 'vista/login.php';
        break;
        
    case 'logout':
        ClienteController::logout();
        break;
        
    case 'menu':
        if(!$cliente){
            header("Location: index.php?accion=login&mensaje=Debe loguearse primero");
            exit();
        }
        require_once 'vista/menu.php';
        break;
        
    case 'listado_juegos':
        if(!$cliente){
            header("Location: index.php?accion=login&mensaje=Debe loguearse primero");
            exit();
        }
        require_once 'vista/listado_juegos.php';
        break;
        
    case 'juegos_alquilados':
        if(!$cliente){
            header("Location: index.php?accion=login&mensaje=Debe loguearse primero");
            exit();
        }
        require_once 'vista/juegos_alquilados.php';
        break;
        
    case 'juegos_no_alquilados':
        if(!$cliente){
            header("Location: index.php?accion=login&mensaje=Debe loguearse primero");
            exit();
        }
        require_once 'vista/juegos_no_alquilados.php';
        break;
        
    case 'mis_alquileres':
        if(!$cliente){
            header("Location: index.php?accion=login&mensaje=Debe loguearse primero");
            exit();
        }
        $mensaje = AlquilerController::devolver();
        require_once 'vista/mis_alquileres.php';
        break;
        
    case 'detalle':
        $mensaje = AlquilerController::alquilar();
        require_once 'vista/detalle_juego.php';
        break;
        
    case 'nuevo_juego':
        if(!$cliente || $cliente->Tipo != 'admin'){
            header("Location: index.php");
            exit();
        }
        $mensaje = JuegoController::crear();
        require_once 'vista/nuevo_juego.php';
        break;
        
    case 'modificar_juego':
        if(!$cliente || $cliente->Tipo != 'admin'){
            header("Location: index.php");
            exit();
        }
        $mensaje = JuegoController::modificar();
        require_once 'vista/modificar_juego.php';
        break;
        
    case 'eliminar_juego':
        if(!$cliente || $cliente->Tipo != 'admin'){
            header("Location: index.php");
            exit();
        }
        $mensaje = JuegoController::eliminar();
        require_once 'vista/eliminar_juego.php';
        break;
        
    default:
        require_once 'vista/inicio.php';
        break;
}
?>