<?php
session_name("mi_app"); // ⬅️ CAMBIAR nombre
session_start();

// ========== INCLUDES ==========
require_once 'controller/UsuarioController.php';
require_once 'controller/EntidadController.php';  // ⬅️ CAMBIAR nombre
require_once 'controller/RelacionController.php'; // ⬅️ CAMBIAR nombre

// ========== OBTENER USUARIO LOGUEADO ==========
$usuario = null;
if(isset($_SESSION['usuario'])){
    $usuario = unserialize($_SESSION['usuario']);
}

// ========== ENRUTAMIENTO ==========
$accion = $_GET['accion'] ?? 'inicio';

switch($accion){
    // --- LOGIN/LOGOUT ---
    case 'login':
        $error = UsuarioController::login();
        require_once 'vista/login.php';
        break;
        
    case 'logout':
        UsuarioController::logout();
        break;
    
    // --- MENU ---
    case 'menu':
        if(!$usuario){
            header("Location: index.php?accion=login&msg=Debe loguearse");
            exit();
        }
        require_once 'vista/menu.php';
        break;
    
    // --- LISTADOS (requieren login) ---
    case 'listado_principal': // ⬅️ CAMBIAR nombre
        if(!$usuario){
            header("Location: index.php?accion=login&msg=Debe loguearse");
            exit();
        }
        require_once 'vista/listado_principal.php';
        break;
    
    case 'mis_items': // ⬅️ CAMBIAR nombre
        if(!$usuario){
            header("Location: index.php?accion=login&msg=Debe loguearse");
            exit();
        }
        $mensaje = RelacionController::accion(); // ⬅️ CAMBIAR
        require_once 'vista/mis_items.php';
        break;
    
    // --- ADMIN (solo admin) ---
    case 'crear_item': // ⬅️ CAMBIAR nombre
        if(!$usuario || $usuario->Tipo != 'admin'){
            header("Location: index.php");
            exit();
        }
        $mensaje = EntidadController::crear();
        require_once 'vista/crear_item.php';
        break;
    
    case 'modificar_item':
        if(!$usuario || $usuario->Tipo != 'admin'){
            header("Location: index.php");
            exit();
        }
        $mensaje = EntidadController::modificar();
        require_once 'vista/modificar_item.php';
        break;
    
    case 'eliminar_item':
        if(!$usuario || $usuario->Tipo != 'admin'){
            header("Location: index.php");
            exit();
        }
        $mensaje = EntidadController::eliminar();
        require_once 'vista/eliminar_item.php';
        break;
    
    // --- INICIO (sin login) ---
    default:
        require_once 'vista/inicio.php';
        break;
}
?>