<?php

$cuentas = [
    '12345678' => ['contraseña' => 'password123', 'saldo' => 5000000],
    '87654321' => ['contraseña' => 'contraseña456', 'saldo' => 750000]
];

// Función para validar tarjeta y contraseña
function validarTarjeta($numeroTarjeta, $contraseña) {
    global $cuentas;
    return isset($cuentas[$numeroTarjeta]) && $cuentas[$numeroTarjeta]['contraseña'] === $contraseña;
}

// Función para mostrar el menú principal
function mostrarMenu() {
    echo "Seleccione una opción:\n";
    echo "1. Retirar dinero\n";
    echo "2. Enviar dinero\n";
    echo "3. Ver saldo disponible\n";
    echo "4. Salir\n";
}

// Función para mostrar opciones de monto
function mostrarMontos() {
    echo "Seleccione un monto a retirar o enviar:\n";
    echo "1. 10,000\n";
    echo "2. 50,000\n";
    echo "3. 100,000\n";
    echo "4. 150,000\n";
    echo "5. 200,000\n";
    echo "6. Otro monto\n";
}

// Función para ver saldo
function verSaldo($numeroTarjeta) {
    global $cuentas;
    echo "Su saldo disponible es: " . $cuentas[$numeroTarjeta]['saldo'] . "\n";
}

// Función para realizar una transacción (retiro o envío)
function realizarTransaccion($numeroTarjeta, $monto, $tipo) {
    global $cuentas;

    if ($monto > $cuentas[$numeroTarjeta]['saldo']) {
        echo "Saldo insuficiente.\n";
    } else {
        $cuentas[$numeroTarjeta]['saldo'] -= $monto;

        if ($tipo === 'retiro') {
            echo "Has retirado $monto. Tu nuevo saldo es: " . $cuentas[$numeroTarjeta]['saldo'] . "\n";
        } elseif ($tipo === 'envio') {
            echo "Has enviado $monto. Tu nuevo saldo es: " . $cuentas[$numeroTarjeta]['saldo'] . "\n";
        }
    }
}

// Simulación del proceso del cajero automático
function iniciarCajero() {
    global $cuentas;

    // Solicitar número de tarjeta y contraseña
    echo "Ingrese su número de tarjeta: ";
    $numeroTarjeta = trim(fgets(STDIN));

    echo "Ingrese su contraseña: ";
    $contraseña = trim(fgets(STDIN));

    // Validar tarjeta y contraseña
    if (validarTarjeta($numeroTarjeta, $contraseña)) {
        echo "Acceso concedido.\n";

        while (true) {
            mostrarMenu();
            $opcion = trim(fgets(STDIN));

            if ($opcion == '1' || $opcion == '2') {
                mostrarMontos();
                $montoOpcion = trim(fgets(STDIN));

                switch ($montoOpcion) {
                    case '1':
                        $monto = 10000;
                        break;
                    case '2':
                        $monto = 50000;
                        break;
                    case '3':
                        $monto = 100000;
                        break;
                    case '4':
                        $monto = 150000;
                        break;
                    case '5':
                        $monto = 200000;
                        break;
                    case '6':
                        echo "Ingrese el monto deseado: ";
                        $monto = trim(fgets(STDIN));
                        break;
                    default:
                        echo "Opción no válida. Intente de nuevo.\n";
                        continue 2; // Volver a mostrar el menú principal
                }

                if ($opcion == '1') {
                    realizarTransaccion($numeroTarjeta, $monto, 'retiro');
                } elseif ($opcion == '2') {
                    echo "Ingrese el número de tarjeta del destinatario: ";
                    $numeroTarjetaDestino = trim(fgets(STDIN));
                    realizarTransaccion($numeroTarjeta, $monto, 'envio');
                }
            } elseif ($opcion == '3') {
                verSaldo($numeroTarjeta);
            } elseif ($opcion == '4') {
                echo "Gracias por usar el cajero automático. ¡Adiós!\n";
                break;
            } else {
                echo "Opción no válida. Intente de nuevo.\n";
            }
        }
    } else {
        echo "Número de tarjeta o contraseña incorrectos.\n";
    }
}

// Iniciar el cajero automático
iniciarCajero();

?>