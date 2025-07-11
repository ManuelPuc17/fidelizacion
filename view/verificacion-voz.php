<?php
session_start();

if (!isset($_SESSION['usuario_id']) || !isset($_SESSION['verificacion_voz_pendiente'])) {
    header('Location: ../pages/login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Verificación por Voz</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light">
    <div class="container mt-5" style="max-width: 500px;">
        <div class="bg-white p-4 rounded shadow text-center">
            <h2>Verificación por Voz</h2>
            <p class="mb-3">Por favor, diga: <strong>"acceso autorizado"</strong></p>
            <button class="btn btn-primary" onclick="iniciarReconocimiento()">Iniciar Reconocimiento</button>
            <p id="resultado" class="mt-3 text-muted"></p>
        </div>
    </div>

    <script>
        function iniciarReconocimiento() {
            const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
            if (!SpeechRecognition) {
                alert('Tu navegador no soporta reconocimiento de voz.');
                return;
            }

            const reconocimiento = new SpeechRecognition();
            reconocimiento.lang = 'es-ES';
            reconocimiento.start();

            reconocimiento.onresult = function(event) {
                const resultado = event.results[0][0].transcript.toLowerCase();
                document.getElementById('resultado').innerText = `Detectado: "${resultado}"`;

                if (resultado.includes('acceso autorizado')) {
                    // Redirigir al dashboard según el rol
                    const rol = "<?= $_SESSION['usuario_rol'] ?>";
                    // Limpia bandera
                    fetch('../process/confirmar_verificacion.php').then(() => {
                        if (rol === 'admin') {
                            window.location.href = 'admin/dashboard.php';
                        } else {
                            window.location.href = 'cliente/dashboard.php';
                        }
                    });
                } else {
                    alert('Frase incorrecta. Intenta nuevamente.');
                }
            };

            reconocimiento.onerror = function(event) {
                alert('Error en el reconocimiento: ' + event.error);
            };
        }
    </script>
</body>
</html>
