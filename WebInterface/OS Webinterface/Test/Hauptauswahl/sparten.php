<?php include_once("code.php"); ?>
<html>
    <head>
        <meta id="meta" name="viewport" content="width=device-width; initial-scale=1.0" />
        <title>SpartenTest</title>
        
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <div class="haupt-title">
            <h1>Orderman System<br>Hauptauswahl</h1>
        </div>
        
        
        <div class="form-module">
          <div>
            <p>Tisch Nr.: 3</p>
          </div>
          <div>
            <p>Gesamtbetrag: 15,00 $</p>
          </div>
          <div id="sparten" class="box-select">
            <?php createSparten(null); ?> 
          </div>

            <textarea></textarea>

            <div class="btns">
                <button value="back" class="spec_b">Zurück</button>
                <button  value="send" class="spec_b">Senden</button>
            </div>
            
            <div class="btns">
                <input type="button" name="gesamt" value="Rechnung gesamt">
                <input type="button" name="getrennt" value="Rechnung getrennt">
            </div>
        </div>
    </body>
</html>