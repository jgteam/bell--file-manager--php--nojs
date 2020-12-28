<?php

// Funktionen und MySQL-Connection laden
require_once("./../functions.php");

session_start();
// Startet die Session, damit wir auf die $_SESSION Variable zugreifen können

$file = (isset($_FILES['file'])) ? $_FILES['file'] : null;

if($file === null || $_FILES['file']['size'] == 0) {
    // Datei wurde nicht übergeben

    // Error-Antwort erstellen
    jsonResponse(400, [
        'status' => false,
        'message' => 'No file uploaded'
    ]);
}

// fileid generieren
$fileid = uniqueID();

// https://www.php.net/manual/de/features.file-upload.post-method.php

// Absoluter Pfad zum Upload-Ordner
$uploaddir = dirname(dirname(__FILE__)) . '/filestorage/';
// Absoluter Pfad zur (noch nicht) hochgeladenen Datei
$uploadfile = $uploaddir . $fileid;
// Dateiname
$filename = basename($file['name']);

// Datei in dem/den Ordner filestorage mit der fileid als Dateinamen speichern/verschieben
move_uploaded_file($file['tmp_name'], $uploadfile);

// fileid und filename in die Datenbank aufnehmen
$sql = "INSERT INTO files_php (id, filename) VALUES ('" . mysqli_real_escape_string($con, $fileid) . "', '" . mysqli_real_escape_string($con, $filename) . "')";
mysqli_query($con, $sql);

// Erfolgs-Antwort erstellen (-> REST-API)
/*jsonResponse(200, [
    'status' => true,
    'filename' => $filename,
    'download' => getFileDownloadURL($fileid)
]);*/


// Erfolgs-Antwort nur speichern und Nutzer wieder zum Formular weiterleiten
storeUpload([
    'status' => true,
    'filename' => $filename,
    'download' => getFileDownloadURL($fileid)
]);
header("Location: " . ROOTURL);
