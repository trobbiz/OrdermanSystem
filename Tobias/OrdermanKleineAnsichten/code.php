
<?php
    session_start(); //Session um die Bestellung zu speichern
    //Hier ist der Abschnitt, der als ajax/Javascript Schnittstelle fungieren soll

    //Aufruf bei Knopfdruck in "sparteSpeziell.php"
    if(isSet($_POST['spec_b'])){
        switch ($_POST["spec_b"]){
            case "back": //Zurück Button
            
            //Wenn nur der Spartenname zurückkommt, wurde nichts bestellt, also wird auch nichts geschrieben
            if(count($_POST["bestellung"])!=1){
                if($_SESSION["bestellung"]!=null){
                    //Wenn eine Bestellung vorhanden ist, wird die neue angehängt
                    addOrder($_POST["bestellung"]);
                } else {
                    //Sonst ist es die erste Bestellung
                $_SESSION["bestellung"]=$_POST["bestellung"];
                }
            }
                
            createSparten(null); break;
            //Abbruch Button
            case "abort": createSparten(null); break;
        }
        exit;
    }

    //Das Bestellte wird in eine Session variable gespeichert
    if(isSet($_POST["table_number"])){
        
        $sessionname = "tisch" . $_POST["table_number"];
        
        if(isSet($_SESSION[$sessionname])){
            if($_SESSION[$sessionname]==null){
                $_SESSION[$sessionname]=$_POST["liste"];
                
                echo "Die Liste beinhaltet: <br>" . var_dump($_SESSION[$sessionname]);
            }
        }
        die("AAAALDA");
    }

    //Für Abbruch der Hauptauswahl
    if(isSet($_POST["clear_session"])){
        session_unset();
    }

    //Für Senden der Bestellung
    if(isSet($_POST["send_order"])){
        $bestellung = $_SESSION["bestellung"];
        die(implode(",",$bestellung));
    }

    //Hilfsfunktion für das Bestellungsarray
    function addOrder($toAdd){
        //Die Sparte von der Bestellung auslesen
        $sparte = $toAdd[0];
        $alteBestellung = $_SESSION["bestellung"];
        //Dann alles innerhalb dieser Sparte vonn der Session löschen
        $old = false;   //Bool um zu wissen ob man sich innerhalb der Sparte befindet
        $indexe = array(); //Indexe die gelöscht werden sollen werden gespeichert
        
        for($i=0;$i<count($alteBestellung);$i++){
            $spartenanfang = false;
            if($alteBestellung[$i]==$sparte){   //Anfang der Sparte ist der Spartenname
               $old=true;   //Man ist nun innehalb der Sparte
                $spartenanfang=true;
                array_push($indexe, $i);    //Der Spartennamenindex wird gespeichert
            } 
            
            if($old==true && $spartenanfang==false){ //Wenn man am Spartennamen vorbei ist
                if(explode(":", $alteBestellung[$i])[1]==''){
                    //Hier beginnt eine andere Sparte
                    $old = false;
                    break;
                } else {
                    //Sonst werden die alten Bestellungsindexe gespeichert
                    array_push($indexe, $i);
                }
            }
        }
        //Diese Schleife löscht alle indexe aus $indexe
        if(count($indexe)>0){   //Sonst wird ein Index immer gelöscht
            for($i=count($indexe)-1;$i>=0;$i--){
                array_splice($alteBestellung, $indexe[$i],1);
            }
        }
        
        //Die neue Bestellung anfügen
        $_SESSION["bestellung"] = array_merge($alteBestellung, $toAdd);
    }


    //Hier endet der AJAX/JS-Abschnitt

    
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
            
            for($i=0;$i<count($bestellung);$i++){
                if($bestellung[$i]==$sparte){  //Der Name der Sparte wird in der Bestellung gesucht
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
                echo "<td><label id='$i-label'>".$result["name"]."</label></td>";
                echo "<td id='$i-price'>".$result["preis"]."€</td>";
                echo "<td><input type='button' value='-' id='$i-'><input type='text' readonly value=0 style='text-align: center' id='$i-counter'><input type='button' value='+' id='$i-p'></td>";
            echo "</tr>";
            $anz = $i+1;
        }
        if($new==false){    //Wenn schon eine Bestellung für diese Sparte vorliegt, wird die Anzahl der Gerichte verändert
            showOldOrder($bestellung, $indexOfSparte,$anz);
        }
        return $anz;
    }

    function showOldOrder($bestellung, $index,$anz){
        for ($i=0;$i<$anz;$i++){
            echo "<script>(function(){";    //Start
            //Alle Labels durchgehen und mit der Bestellung vergleichen
            
            echo "var label = document.getElementById('$i-label').innerHTML;";    //Label auslesen
            
            //Für jedes Label alle Inhalte der Bestellung durchgehen
            for($j=$index+1;$j<count($bestellung);$j++){
                $NameAnz = explode(":",$bestellung[$j]);
                if($NameAnz[1]!=''){    //Wenn die neue Sparte anfängt, wird abgebrochen um Zeit zu sparen
                    echo "if(label=='$NameAnz[0]'){
                        document.getElementById('$i-counter').value = '$NameAnz[1]';
                    }";
                } else {
                    break;
                }
            }
            echo "})();</script>";   //Ende
        }
        
    }

    //Ende der PHP Funktionen
?>