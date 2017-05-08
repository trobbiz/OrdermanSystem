<?php include_once("code.php"); ?>  

<html>
    <head>
        <title>SpartenTest</title>
    </head>
    <body>    
        <div style="background-color: red" id="sparten"><?php createSparten(null); ?></div>
        <div style="background-color: cyan" id="liste">Hier wird die Liste angezeigt</div>
        <div style="background-color: green" id="rechnung">
            <button id="send_order">Senden</button>
            <button id="abort_table">Abbrechen</button>
            <br>
            <button id="rechnung_btn">Rechnung gesamt</button>
            <button id="rechnung_getrennt">Rechnung getrennt</button>
        </div>
    </body>
</html>

<?php include_once("ajax.php"); ?>