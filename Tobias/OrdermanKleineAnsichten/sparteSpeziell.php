<?php include_once("code.php"); ?>

<script src="ajax.js" type="text/javascript">
</script>

<table>
    <tr>
        <th>
            Name
        </th>
        <th>
            Preis
        </th>
        <th>
            Anzahl
        </th>
    </tr>
    <?php showDishes($_POST["sparte"]); ?>
</table>
<button id='back' value="back">Zurück</button>
<button  value="Abbrechen">Abbrechen</button>

    

    
    