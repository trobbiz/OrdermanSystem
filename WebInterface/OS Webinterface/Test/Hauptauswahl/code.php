
<?php
    session_start(); //Session um die Bestellung zu speichern
    //Hier ist der Abschnitt, der als ajax Schnittstelle fungieren soll

    //Aufruf bei Knopfdruck in "sparteSpeziell.php"
    if(isSet($_POST['spec_b'])){
        switch ($_POST["spec_b"]){
            case "back": //Zurück Button
            
            //Wenn nur der Spartenname zurückkommt, wurde nichts bestellt, also wird auch nichts geschrieben
            if(count($_POST["bestellung"])!=1){
                $_SESSION["bestellung"]=$_POST["bestellung"];
            }
                
            createSparten(null); break;
            //Abbruch Button
            case "abort": createSparten(null); break;
        }
        exit;
    }
    //Hier endet der AJAX-Abschnitt

    
    $pageStart='<script src="jquery.js"></script>';//Script wird eingefügt
    print $pageStart;
    

    //PHP Funktionen für das OrdermanSystem
    function getPDO(){
        $dsn="mysql:host=linuxserver;dbname=DB2_stlarleo";  //PDO mit diesen Daten erstellen
        $userpdo="stlarleo";
        $pass="mypass";
        $pdo = new PDO($dsn,$userpdo,$pass);
        
        return $pdo;    //PDO zurückgeben
    }

    function executePreparedStatement($pdo, $query, $param_array){
        //Ein Statement wird für die PDO erstellt, mit dem Befehl, der in $query steht und den Parametern die in $param_array stehen
        $stmt = $pdo->prepare($query);  //Das Statement wird vorbereitet
        
        for($i=0;$i<count($param_array);$i++){  //Jeder Wert im Array wird in den Befehl eingebracht
            $stmt->bindParam($i+1, $param_array[$i], PDO::PARAM_STR);
        }
        
        $stmt->execute();
        
        return $stmt;
    }

    function executeStatement($pdo, $query){    //Das selbe wie oben, nur ohne Parameter. Also für simple Statements die vom Programm vorgegeben sind
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        
        return $stmt;
    }

    function createSparten($bestellung){
        /*if($bestellung!=null){
            //Net sicho obs des braucht, obo mir schaugen
        }*/
        
        $pdo = getPDO();
        
        $stmt = executeStatement($pdo, "SELECT name FROM sparte");
        
        for($i=1;$i<=$stmt->rowCount();$i++){
            $result=$stmt->fetch(PDO::FETCH_ASSOC);
            $name = $result["name"];
            echo "<input type='button' value='$name' id='$name'>";
            echo "<script> $(document).ready(function(){
            $('#$name').click(function(){
                $('#sparten').load('sparteSpeziell.php',{ sparte: '$name' });
                $('#sparten').removeClass('box-main').addClass('box-select');
            });
            });</script>";
        }
    }

    function getSpartenID($pdo, $sparte){
        $query = "SELECT s_id FROM sparte WHERE name = ?";
        $param_array[0] = $sparte;
        
        $stmt = executePreparedStatement($pdo, $query, $param_array);
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result["s_id"];
    }

    function showDishes($sparte){
        
        $new = true;    //Neue Bestellung
        
        if(isSet($_SESSION["bestellung"])){
            $bestellung = $_SESSION["bestellung"];
            var_dump($bestellung);
            
            for($i=0;$i<count($bestellung);$i++){
                if($bestellung[$i]==$sparte){  //Der Name der Sparte wird in der Bestellung gesucht
                    echo "Für diese Sparte liegt eine Bestellung vor";
                    $new = false;   //Keine neue Bestellung
                    $indexOfSparte = $i;    //Index in der die Sparte steht wird gespeichert
                    break;
                }
            }
        }
        
        $pdo = getPDO();   
        
        $sparte = getSpartenID($pdo, $sparte);  //ID von der Sparte holen

        $param_array[0] = $sparte;  //Parameterarray wird geamcht, anders nicht lösbar
    
        $query = "SELECT name, preis FROM artikel WHERE sparten_id = ?";    //Der Befehl wird erstellt
    
        $stmt = executePreparedStatement($pdo, $query, $param_array);    //Statement wird ausgeführt
    
        //In der for-schleife wird dynamisches Script erzeugt
        for($i=0;$i<$stmt->rowCount();$i++){
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            echo "<tr class='table-ro
            w'>";
                echo"<script> 
                    $('#$i-').click(function(){
                        var val = document.getElementById('$i-counter').value;
                        val = parseInt(val,10) - 1;
                        if(val<0){
                            val = 0;
                        }
                        document.getElementById('$i-counter').value = val;
                    });
                    
                    $('#$i-p').click(function(){
                        var val = document.getElementById('$i-counter').value;
                        val = parseInt(val,10) + 1;
                        if(val<0){
                            val = 0;
                        }
                        document.getElementById('$i-counter').value = val;
                    });
                </script>";
                echo "<td class='product'><label id='$i-label'>".$result["name"]."</label></td>";
                echo "<td class='amount'>".$result["preis"]."€</td>";
                echo "<td class='selection'><input type='button' value='-' id='$i-'><input class='counter' type='text' readonly value=0 id='$i-counter'><input type='button' value='+' id='$i-p'></td>";
            echo "</tr>";
            $anz = $i+1;
        }
        if($new==false){    //Wenn schon eine Bestellung für diese Sparte vorliegt, wird die Anzahl der Gerichte verändert
            showOldOrder($bestellung, $indexOfSparte,$anz-1);
        }
        return $anz;
    }

    function showOldOrder($bestellung, $index,$anz){
        //Hier einfügen irgendwie die Anzahl richtig verändern und immer schauen, ob die Sparte schon zu ende ist.
        for ($i=0;$i<$anz;$i++){
            //Alle Labels durchgehen
        }
    }
























    //Ende der PHP Funktionen
?>