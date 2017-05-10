<!DOCTYPE html>
<?php include("../code.php"); ?>
<html>
  <head>
    <meta id="meta" name="viewport" content="width=device-width; initial-scale=1.0" />
    <title>OrdermanSystem Tischauswahl</title>

    <link rel="stylesheet" href="css/style.css">
  </head>
  <body>
    <div class="tisch-title">
      <h1>Orderman System<br>Tischauswahl</h1>
    </div>
    <div class="form-module">
      <form action="../sparten.php" method="POST">
        <div>
            <p>Tisch Nr.:</p>
          <select name="tische" size="1">
            <?php createSelect(); ?>
          </select>
        </div>
        <input type="submit" name="choose_table" value="Auswaehlen">
        <input type="submit" name="open_tables" value="Offene Tische">
      </form>
    </div>
  </body>
</html>




<?php

    function createSelect(){
        $pdo = getPDO();
        
        $stmt = executeStatement($pdo, "SELECT * FROM tisch");
        
        for($i=1;$i<=$stmt->rowCount();$i++){
            $result=$stmt->fetch(PDO::FETCH_ASSOC);
            $tischnr = $result["t_id"];
            
            echo "<option value='$tischnr'>$tischnr</option>";
        }
    }

?>