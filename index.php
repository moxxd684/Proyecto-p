<?php

// Definir la URL de la API correctamente
const API_URL = "https://whenisthenextmcufilm.com/api";

// Inicializar una nueva sesión de CURL
$ch = curl_init(API_URL);

// Configurar opciones de CURL
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Ejecutar la petición y guardar el resultado
$result = curl_exec($ch);

// Verificar si hubo un error en la petición
if (curl_errno($ch)) {
    die("Error al obtener los datos de la API: " . curl_error($ch));
}

// Cerrar la sesión de CURL
curl_close($ch);

// Decodificar el JSON recibido en un array asociativo
$data = json_decode($result, true);

// Validar si la API devolvió datos válidos
if (!$data || !isset($data["title"], $data["poster_url"], $data["release_date"], $data["days_until"], $data["following_production"]["title"])) {
    die("Error: No se pudieron obtener los datos correctamente.");
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La próxima película de Marvel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="text-bg-dark p-3 text-center">
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <section>
        <h1 class="text-center mx-auto p-2">¿Cuál es la siguiente película de Marvel?</h1>
        <div class="text-center">
            <img src="<?= htmlspecialchars($data["poster_url"]) ?>" class="rounded img-fluid" width="400" 
                alt="Cartel de estreno de <?= htmlspecialchars($data["title"]) ?>">
        </div>
    </section>

    <hgroup class="text-center">
        <h2 class="mx-auto p-2"><?= htmlspecialchars($data["title"]) ?> se estrena en <?= (int)$data["days_until"] ?> días</h2>
        <p class="text-center lead h6">Fecha de estreno: <?= htmlspecialchars($data["release_date"]) ?></p>
        <p class="text-center lead h6">La siguiente película es: <?= htmlspecialchars($data["following_production"]["title"]) ?></p>
    </hgroup>

</body>
</html>
