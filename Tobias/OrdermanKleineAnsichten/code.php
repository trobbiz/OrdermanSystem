
<?php
    
    $pageStart='<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>';//Script wird eingefügt
    print $pageStart;
    
    function getPDO(){
        $dsn="mysql:host=linuxserver;dbname=DB3_stleitob";  //PDO mit diesen Daten erstellen
        $userpdo="stleitob";
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

    function createSparten(){
        $pdo = getPDO();
        
        $stmt = executeStatement($pdo, "SELECT name FROM sparte");
        
        for($i=1;$i<=$stmt->rowCount();$i++){
            $result=$stmt->fetch(PDO::FETCH_ASSOC);
            $name = $result["name"];
            echo "<input type='button' value='$name' name='$name'>";
        }
    }
?>