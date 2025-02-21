<html lang="de">
    <head>

        <meta charset="utf-8">
        <title>HTML Upload Form</title>

    </head>
    <body>

        <h1>HTML Upload Form (Stack: PHP ohne JavaScript)</h1>

        <!-- Links zu den Verläufen -->
        <hr/>
        <a href="history?upload">&uparrow; Upload History</a> &verbar; <a href="history?download">&downarrow; Download History</a>
        <hr/>

        <!-- Formular, für den Dateiupload: -->
        <form id="uploadform" action="upload" method="post" enctype="multipart/form-data">
            <fieldset>
                <legend>Form</legend>
                <label>File: (text/*)<input id="file" name="file" type="file" size="50" accept="text/*"></label>
                <button>Über HTML-Form senden</button>
            </fieldset>
        </form>

        <!-- Tabelle, in welche zukünftige Antworten geschrieben werden -->
        <table id="responses" border="1">
            <tr>
                <th>Responses (Upload History):</th>
            </tr>

            <?php

            include_once("functions.php");

            $uploads = getUploadHistory() ;
            // Array mit allen Uploads

            if($uploads !== null):
            // Prüft ob Uploads vorhanden sind

            foreach($uploads as $upload) {
                // Alle Uploads mit der Foreach-Schleife durchgehen

                if($upload['status']) {
                    // Erfolgreicher Upload
                    echo "<tr><td>" . stripslashes(json_encode($upload)) . "</td></tr>";
                } else {
                    // Nicht erfolgreicher Upload
                    echo "<tr><td style='color:red;'>" . json_encode($upload) . "</td></tr>";
                }
            }

            endif;
            ?>

        </table>

    </body>
</html>