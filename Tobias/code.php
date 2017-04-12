 <?php
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
            $stmt->bindParam($i, $param_array, PDO::PARAM_STR);
        }
        
        $stmt->execute();
        
        return $stmt;
    }
?>