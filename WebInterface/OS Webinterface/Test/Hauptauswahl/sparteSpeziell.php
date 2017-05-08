<?php include_once("code.php"); ?>

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
    <?php $gerichte_anz = showDishes($_POST["sparte"]); ?>
</table>
<button value="back" class="spec_b">Zurück</button>
<button  value="abort" class="spec_b">Abbrechen</button>

<?php include("ajax.php"); ?>
    

    
    