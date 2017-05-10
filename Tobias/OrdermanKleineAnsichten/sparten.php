<?php include_once("code.php"); ?>  

<html>
    <head>
        <title>SpartenTest</title>
    </head>
    <body>    
        
        <div>
            <div>
                <p>Tisch Nr: <?php getTableNumber(); ?></p>
            </div>
            <div>
                <p>Gesamtbetrag: 1000 €</p>
            </div>
        </div>
        
        
        <div style="background-color: red" id="sparten"><?php createSparten(null); ?></div>
        
        <div style="background-color: cyan" id="liste">
            <table>
                <tr>
                    <td>Name</td>
                    <td>Anzahl</td>
                    <td>Preis</td>
                </tr>
            </table>
        </div>
        
        <div style="background-color: green" id="rechnung">
            <button id="send_order">Senden</button>
            <button id="abort_table">Abbrechen</button>
            <br>
            <button id="rechnung_btn">Rechnung gesamt</button>
            <button id="rechnung_getrennt">Rechnung getrennt</button>
        </div>
        
    </body>
</html>

<?php
    
    function getTableNumber(){
        if(isSet($_POST["choose_table"])){
            $sessionname = "tisch" . $_POST["tische"];
            $_SESSION[$sessionname]=null;
            
            echo "<label id='table_number'>" . $_POST["tische"] . "</label>";
        }
    }

?>

<script src="buttonsHauptauswahl.js" type="text/javascript"></script>