
<script>
    //"sparteSpeziell.php" Knopffunktionen
    $('.spec_b').click(function(){
        var clickBtnValue = $(this).val();

        //Anzahl der verfügbaren Gerichte und Name der Sparte
        var sparte = "<?php echo $_POST['sparte'];?>";
        var ger_anz = "<?php echo $gerichte_anz; ?>";
        

        if(clickBtnValue=="back"){
            //Wenn zurück gedrückt wird, sollen die Bestellungen mitgegeben werden
            var data =  {'spec_b': clickBtnValue, 'bestellung': getBestellungen(sparte, ger_anz)};
        } else {
            //Bei Abbruch wird nur zurückgegangen
            var data =  {'spec_b': clickBtnValue};
        }

        $.post("code.php", data, function (response) {
            // Response sind die Sparten die generiert werden.
            $('#sparten').html(response);   //Die Sparten werden hier wieder hergeschrieben
        });
    });
    
    function getBestellungen(sparte, anz){
        //Die Bestellungen werden in die Liste eingetragen
        var bes_liste = [sparte];
        for(var i = 0;i<anz;i++){
            //Mit den IDs werden die Daten ausgelesen
            var id = i.toString() + "-counter";
            var labelid = i.toString() + "-label";
            var cnt = document.getElementById(id).value;
            
            if(cnt!=0){ //Nur das was bestellt wurde wird mitgeloggt
                var gericht = document.getElementById(labelid).innerHTML;
                //Die Bestellung wird gespeichert und in die Liste geschrieben. Aufbau der Bestellung = Name:Anzahl
                var bes = gericht + ":" + cnt;
                bes_liste.push(bes);
            }
        }
        //Die Bestellung wird als Array zurückgegeben und an die Seite "code.php" gesendet
        return bes_liste;
    }
    
    //Knopffunktion "Abbruch" für die Hauptauswahl
    $("#abort_table").click(function(){
        $.post("code.php", {'clear_session': true}, function(data){
        window.location.replace("\Tischauswahl\\auswahl.php");
        });
    });
    
    
    //Knopffunktion für das Abschicken der Bestellung
    $("#send_order").click(function(){
        $.post("code.php" , {'send_order':true}, function(data){
            //Bekommt die Bestellung als String zurück
            alert(data);
            var bestellung = data.split(","); //Die einzelnen Gerichte werden getrennt
            
            createList(bestellung);
            
            
        });
        alert("Hier die Bestellung schicken lassen");
    });
    
    function createList(gerichte){
        //Liste durch Tabelle ersetzen
        var liste = "<ul>";
        
        for(var i=0;i<gerichte.length;i++){
            if(gerichte[i].split(":")[1]==undefined){
                alert(gerichte[i]);
            } else {
                var listelements = gerichte[i].split(":");
                liste = liste + "<li>" + listelements[0] + "    " + listelements[1] + "</li>";
            }
        }
        
        liste = liste + "</ul>";
        $("#liste").html(liste);
    }
</script>
