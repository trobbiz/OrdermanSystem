<?php
    function getTable(){
        $dsn="mysql:host=linuxserver;dbname=DB3_stleitob";  //PDO mit diesen Daten erstellen
        $userpdo="stleitob";
        $pass="mypass";
        $pdo = new PDO($dsn,$userpdo,$pass);
        
        $stmt = $pdo->prepare("SELECT * FROM Benutzer"); //Geld von der Source abziehen
        $stmt->execute();
        $result=$stmt->fetch(PDO::FETCH_ASSOC);
        
        for($i=0;$i<=$stmt->rowCount();$i++){
            $name = $result["name"];
            $passw = $result["password"];
            $kat = $result["kategorie"];
            echo "<tr>";
                echo"<td>$name</td>";
                echo"<td>$passw</td>";
                echo"<td>$kat</td>";
            echo "</tr>";
            
            $result=$stmt->fetch(PDO::FETCH_ASSOC);
        }
    }
?>
        <table>
            <th>Name</th>
            <th>Password</th>
            <th>Kategorie</th>
            <?php getTable(); ?>
            <input type="button" id="next" value="Next">
        </table>


   