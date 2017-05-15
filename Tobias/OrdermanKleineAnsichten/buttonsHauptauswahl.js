//Rechnung gesamt
     $("#rechnung_btn").click(function(){
        alert("Rechnung gesamt");
    });

//Knopffunktion für das Abschicken der Bestellung
    $("#send_order").click(function(){
            $.post("code.php" , {'send_order':true}, function(data){
                //Bekommt die Bestellung als String zurück
                if(data.length>2){  //Wenn nichts drinnen steht, wird nichts gemacht
                    var bestellung = data.split(","); //Die einzelnen Gerichte werden getrennt
                    createList(bestellung);

                    //Auszubauen
                    //sendOrder(bestellung);
                    $.post("code.php", {'clear_session': true});
                }
            });
            alert("Hier die Bestellung schicken lassen");
    });

//Liste wird angezeigt mit dem was bestellt wurde
    function createList(gerichte){
        //Liste durch Tabelle ersetzen
        var liste = "<table><tr><td>Name</td><td>Anzahl</td><td>Preis</td></tr>";
        
        for(var i=0;i<gerichte.length;i++){
            if(gerichte[i].split(":")[1]!=undefined){
                //Spartennamen werden ignoriert
                var listelements = gerichte[i].split(":");
                
                listelements[2] = listelements[2].slice(0,-1);
                
                
                liste = liste + "<tr><td>" + listelements[0] + "</td><td>" + listelements[1] + "</td><td>"+ parseFloat(listelements[2])*parseInt(listelements[1])  +" €</td></tr>";
                
                //Das Gericht und seine Anzahl werden in eine Tabelle geschrieben
            }
        }
        
        var tablenumber = document.getElementById("table_number").innerHTML;
        
        $.post("code.php", {'table_number': tablenumber, 'liste':gerichte}, function(data){
            //Hier die neue Bestellung mit der Liste vergleichen und die Liste dementsprechend aktualisieren
        });
        
        liste = liste + "</table>";
        $("#liste").html(liste);
    };


//Knopffunktion "Abbruch" für die Hauptauswahl
    $("#abort_table").click(function(){
        $.post("code.php", {'clear_session': true}, function(data){
        window.location.replace("\Tischauswahl\\auswahl.php");
        });
    });