<?php

define("SECRETKEY", "Csecraay"); // Clé secrète pour le hash

function generateCSRFToken() {
    $time = time();
    $data = session_id() . $time; // On concatène la session_id et le timestamp
    $hash = hash_hmac('sha256',$data,SECRETKEY) . $time; // On hash le résultat puis on y concatène le même timestamp
    setcookie('csrf_token', $hash, 0, '', '', false, true);
    return $hash;
}

function checkCSRFToken(String $csrf_token = '') {    
    $timestampToken = substr($csrf_token,-10); // On récupère le timestamp du token à vérifier
    $data = session_id() . $timestampToken; // On concatène la session_id et le timestamp récupéré
    $hash = hash_hmac('sha256',$data,SECRETKEY); // On hash le résultat de la même manière qu'a la génération

    return hash_equals($csrf_token, $hash.$timestampToken); // On compare les deux hash de manière SECURISE (timing attack)

}