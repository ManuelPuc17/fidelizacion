<?php
session_start();
unset($_SESSION['verificacion_voz_pendiente']);
http_response_code(200);
