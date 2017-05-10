<html>
    
    <?php
    //Bestellung Aufbau: 2 Typen
    //Typ1 = Spartenname - ignorieren
    //Typ2 = Bestellung Name:Anz:Preis - ausgeben
    //Noch auszugeben: Tischnummer, Uhrzeit, Kellner
    
    

    ?>
    
    
    <head>
        <h3>Ausgabe Belege</h3>
    </head>

    <body>
        
        <form name="form" method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
             <div id = "tabelle">
                
                 
                <?php
                    date_default_timezone_set("Europe/Berlin");
                    $zeit = date("h:i:sa");
                    $order = array("Analkoholisches", "Cola:3" , "Bier:12" , "St. Magdalener:13");
                    
                    $host = "192.168.1.99";
                    $port = 1234;
                    set_time_limit(0);
                
                    $socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket");   
                    $result = socket_bind($socket, $host, $port) or die("Could not bind to socket");
                    $result = socket_listen($socket, 3) or die("Could not set up socket listenern");
                    $spawn = socket_accept($socket) or die("Could not accept incoming connection");
                 
                 
                 
                    //http://www.devshed.com/c/a/php/socket-programming-with-php/
                 
                    for($i=0; $i<2; $i++){
                        createTable("10", $zeit, "Hans", $order); 
                        
                    }
                        function createTable($t_nr, $time, $kelln, $order){
                            echo "<table border=1px>
                                          <tr>
                                            <th>Tischnummer</th>
                                            <th>Uhrzeit</th> 
                                            <th>Kellner</th>
                                            <th>Bestellung</th>

                                          </tr>";
                                echo "<tr>";
                                   echo"<td>".$t_nr."</td>";
                                   echo"<td>".$time."</td>";
                                   echo"<td>".$kelln."</td>";
                                   echo "<td>";
                                        for($i=0;$i<=count($order);$i++){
                                            $NameAnz = explode(":",$order[$i]);
                                            if($NameAnz[1]!=""){
                                                //$NameAnz[0] = Name
                                                //$NameAnz[1] = Anzahl
                                                //$NameAnz[2] = Preis
                                                
                                                echo $NameAnz[0] . " x " . $NameAnz[1] . "<br>";

                                            }
                                        }
                                echo "</td>";

                                echo"</tr>";
                             echo "</table>";  
                        }

                ?>


            </div>
            
        </form>
    </body>




</html>