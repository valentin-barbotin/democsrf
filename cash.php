<?php
session_start();
require("functions.php"); // Nos fonctions CSRF (basiques)

$protection = true; // Protection CSRF activée ou pas
if ($protection) {
    $mode = $_COOKIE;

    $csrf_token = isset($mode['csrf_token']) ? $mode['csrf_token'] : '';
    
    if (!checkCSRFToken($csrf_token)) { // Si le jeton n'est pas bon, on arrête tout
        die("CSRF token is invalid");
    }

    $csrftoken = generateCSRFToken(); // A chaque affichage de la page, on génère un nouveau token

}


$filename = "data.txt";
$file = fopen($filename, "r+") or die("Unable to open file!");
$dataoriginal = fgets($file, filesize($filename)+1); // Lit le fichier
ftruncate($file, 0); // Vide le fichier
rewind($file);

echo "Argent: $dataoriginal"; // Affiche l'argent

$money = intval($dataoriginal) + 100; // Ajoute 100 à l'argent
fwrite($file, $money);
fclose($file);