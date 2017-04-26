
<?php

    //Hier ist der Abschnitt, der als ajax Schnittstelle fungieren soll

    if(isSet($_POST['action'])){
        createSparten(null);
        exit;
    }
    //Hier endet er

    
    $pageStart='<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>';//Script wird eingefügt
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
                $('#red').load('sparteSpeziell.php',{ sparte: '$name' });
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
        $pdo = getPDO();   
        
        $sparte = getSpartenID($pdo, $sparte);  //ID von der Sparte holen

        $param_array[0] = $sparte;  //Parameterarray wird geamcht, anders nicht lösbar
    
        $query = "SELECT name, preis FROM artikel WHERE sparten_id = ?";    //Der Befehl wird erstellt
    
        $stmt = executePreparedStatement($pdo, $query, $param_array);    //Statement wird ausgeführt
    
        //In der for-schleife wird dynamisches Script erzeugt
        for($i=0;$i<$stmt->rowCount();$i++){
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            echo "<tr>";
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
                echo "<td>".$result["name"]."</td>";
                echo "<td>".$result["preis"]."€</td>";
                echo "<td><input type='button' value='-' id='$i-'><input type='text' readonly value=0 style='text-align: center' id='$i-counter'><input type='button' value='+' id='$i-p'></td>";
            echo "</tr>";
        }
    }

    //Ende der PHP Funktionen
?>