<?php

include_once("functions.php");

// $mode gibt an, ob der upload- oder download-Verlauf eingesehen wird
$mode = null;
if(isset($_GET["upload"])) $mode = "upload";
if(isset($_GET["download"])) $mode = "download";

?>

<html lang="de">
    <head>

        <meta charset="utf-8">
        <title>History</title>

        <!-- jQuery import. Wird genutzt um über AJAX das Formular abzuschicken und anschließend die Antwort in die Tabelle zu schreiben-->
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

    </head>
    <body>

        <!-- Zurück-Link -->
        <a href="./">&larr; Back</a>

        <!-- Dynamischer Titel -->
        <h1><?php if ($mode !== null) { echo ucfirst($mode) . " "; } ?>History</h1>

        <!-- Wechsel zwischen Upload-/Download-Verläufen -->
        <hr/>
        <a href="history?upload">&uparrow; Upload History</a> &verbar; <a href="history?download">&downarrow; Download History</a>
        <hr/>

        <!-- Tabelle mit Upload/Download verlauf -->
        <table id="history" border="1">
            <tr>
                <th>History:</th>
            </tr>

            <?php

            $history = null;

            // Verlauf abrufen
            if ($mode == "upload")
                $history = getUploadHistory();
            if ($mode == "download")
                $history = getDownloadHistory();

            if ($mode !== null) {

                if ($history === null) {
                    // Falls den Verlauf leer sein sollte

                    echo "<tr><td style='color:red;'>No history found.</td></tr>";

                } else {
                    // Wenn der Verlauf Inhalt hat

                    foreach ($history as $entry) {
                        // Jeden Eintrag einzel darstellen

                        echo "<tr><td>" . stripslashes(json_encode($entry)) . "</td></tr>";

                    }

                }

            }


            ?>

        </table>

    </body>
</html>