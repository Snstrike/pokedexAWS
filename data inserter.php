<?php

$pokemonCounter = 1;

while ($pokemonCounter <= 150) {
    $pokeGET2 = 'https://pokeapi.co/api/v2/pokemon/' . $pokemonCounter;
    $pokeread = file_get_contents($pokeGET2);

    if ($pokeread === FALSE) {
        echo "Error al leer datos de la API para el Pokémon con ID $pokemonCounter.<br>";
        $pokemonCounter++;
        continue;
    }

    $pokeConvert = json_decode($pokeread, TRUE);

    if ($pokeConvert === null) {
        echo "Error al decodificar JSON para el Pokémon con ID $pokemonCounter.<br>";
        $pokemonCounter++;
        continue;
    }

    // Convertir el nombre y los tipos del Pokémon a mayúsculas
    $pokemonName = strtoupper($pokeConvert['name']);
    $pokemonType = isset($pokeConvert['types'][0]['type']['name']) ? strtoupper($pokeConvert['types'][0]['type']['name']) : "(NONE)";
    $pokemonType2 = isset($pokeConvert['types'][1]['type']['name']) ? strtoupper($pokeConvert['types'][1]['type']['name']) : "(NONE)";
    $pokemonHP = isset($pokeConvert['stats'][0]['base_stat']) ? $pokeConvert['stats'][0]['base_stat'] : 0;
    $pokemonAttack = isset($pokeConvert['stats'][1]['base_stat']) ? $pokeConvert['stats'][1]['base_stat'] : 0;
    $pokemonDefense = isset($pokeConvert['stats'][2]['base_stat']) ? $pokeConvert['stats'][2]['base_stat'] : 0;
    $pokemonSpA = isset($pokeConvert['stats'][3]['base_stat']) ? $pokeConvert['stats'][3]['base_stat'] : 0;
    $pokemonSpD = isset($pokeConvert['stats'][4]['base_stat']) ? $pokeConvert['stats'][4]['base_stat'] : 0;
    $pokemonSpeed = isset($pokeConvert['stats'][5]['base_stat']) ? $pokeConvert['stats'][5]['base_stat'] : 0;
    $pokemonWeight = isset($pokeConvert['weight']) ? $pokeConvert['weight'] : 0;
    $pokemonHeight = isset($pokeConvert['height']) ? $pokeConvert['height'] * 10 : 0; // Convertir de decímetros a centímetros
    $pokemonImage = $pokeConvert['sprites']['other']['official-artwork']['front_default'];

    // Conexión MySQLi
    $mysqli = new mysqli('pokedex-db.chn9qxfrvjsc.us-east-1.rds.amazonaws.com', 'admin','password', 'pokedex-db');

    if ($mysqli->connect_error) {
        die("Error de conexión: " . $mysqli->connect_error);
    }

    $stmt = $mysqli->prepare("INSERT INTO pokemon (no, name, type, type2, height, weight, hp, attack, defense, spattack, spdefense, speed, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('isssiiiiiiiss', 
        $pokemonCounter, 
        $pokemonName, 
        $pokemonType, 
        $pokemonType2, 
        $pokemonHeight, 
        $pokemonWeight, 
        $pokemonHP, 
        $pokemonAttack, 
        $pokemonDefense, 
        $pokemonSpA, 
        $pokemonSpD, 
        $pokemonSpeed,
        $pokemonImage
    );

    if (!$stmt->execute()) {
        echo "Error: " . $stmt->error . "<br>";
    } else {
        echo "Éxito: Insertado Pokémon ID $pokemonCounter<br>";
    }

    $stmt->close();
    $mysqli->close();

    $pokemonCounter++;
}

?>
