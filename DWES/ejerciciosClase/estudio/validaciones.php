<?php
// Validaciones.php

class Validaciones {
    // validar iban
    $iban ='/^[A-Z]{2}[0-9]{2}[A-Z0-9]{1,30}$/';
    
    // Validar que no esté vacío
    public static function noVacio($campo) {
        return !empty(trim($campo));
    }
    
    // Validar DNI español (8 números + letra)
    public static function validarDNI($dni) {
        $patron = '/^[0-9]{8}[A-Z]$/';
        if (!preg_match($patron, strtoupper($dni))) {
            return false;
        }
        
        $letras = "TRWAGMYFPDXBNJZSQVHLCKE";
        $numero = substr($dni, 0, 8);
        $letra = strtoupper(substr($dni, 8, 1));
        
        return $letra === $letras[$numero % 23];
    }
    
    // Validar Email
    public static function validarEmail($email) {
        $patron = '/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/';
        return preg_match($patron, $email);
    }
    
    // Validar Teléfono español (9 dígitos)
    public static function validarTelefono($telefono) {
        $patron = '/^[6-9][0-9]{8}$/';
        return preg_match($patron, $telefono);
    }
    
    // Validar Contraseña fuerte (mínimo 8 caracteres, 1 mayúscula, 1 minúscula, 1 número)
    public static function validarPassword($password) {
        $patron = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/';
        return preg_match($patron, $password);
    }
    
    // Validar Código Postal español
    public static function validarCodigoPostal($cp) {
        $patron = '/^[0-5][0-9]{4}$/';
        return preg_match($patron, $cp);
    }
    
    // Validar Nombre (solo letras y espacios)
    public static function validarNombre($nombre) {
        $patron = '/^[a-záéíóúñA-ZÁÉÍÓÚÑ\s]+$/u';
        return preg_match($patron, $nombre);
    }
    
    // Validar Precio (número decimal)
    public static function validarPrecio($precio) {
        $patron = '/^\d+(\.\d{1,2})?$/';
        return preg_match($patron, $precio);
    }
    
    // Validar Año (4 dígitos)
    public static function validarAnio($anio) {
        $patron = '/^(19|20)\d{2}$/';
        return preg_match($patron, $anio) && $anio <= date('Y');
    }
    
    // Limpiar entrada (prevenir inyecciones)
    public static function limpiarEntrada($dato) {
        return trim(strip_tags($dato));
    }
    
    // Validar archivo imagen
    public static function validarImagen($archivo) {
        $extensionesPermitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $extension = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));
        
        if (!in_array($extension, $extensionesPermitidas)) {
            return false;
        }
        
        $tiposMime = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!in_array($archivo['type'], $tiposMime)) {
            return false;
        }
        
        // Validar tamaño (máximo 5MB)
        if ($archivo['size'] > 5242880) {
            return false;
        }
        
        return true;
    }
    
    // Validar todos los campos de un array
    public static function validarCamposNoVacios($campos) {
        foreach ($campos as $campo) {
            if (!self::noVacio($campo)) {
                return false;
            }
        }
        return true;
    }


    // Validar Matrícula española (Formatos actual y antiguo)
    public static function validarMatricula($matricula) {
        // Convertimos a mayúsculas y eliminamos guiones o espacios para la comprobación
        $matricula = strtoupper(str_replace([' ', '-'], '', $matricula));

        // PATRÓN 1: Formato Actual (post-2000): 4 números + 3 letras
        // Nota: En el sistema actual NO se usan vocales, ni la Ñ, ni la Q.
        // Letras permitidas: B, C, D, F, G, H, J, K, L, M, N, P, R, S, T, V, W, X, Y, Z
        $patronActual = '/^[0-9]{4}[BCDFGHJKLMNPRSTVWXYZ]{3}$/';

        // PATRÓN 2: Formato Provincial (pre-2000): 1-2 letras + 4 números + 0-2 letras
        // Ejemplo: M1234AB, B1234, SE1234C
        $patronAntiguo = '/^[A-Z]{1,2}[0-9]{4}[A-Z]{0,2}$/';

        // Comprobamos si coincide con alguno de los dos
        return preg_match($patronActual, $matricula) || preg_match($patronAntiguo, $matricula);
    }

}
