//Abbrechen-Funktion für "sparteSpeziell.php"
$('.spec_b').click(function(){
    var clickBtnValue = $(this).val();
    var ajaxurl = "code.php";
    
    var dab = $buttons;
    alert(dab);
    
    
    
    
    
    
    
    
    if(clickBtnValue=="back"){
        var data =  {'spec_b': clickBtnValue, 'bestellung': "Bestellung"};
    } else {
        var data =  {'spec_b': clickBtnValue};
    }
        
    $.post(ajaxurl, data, function (response) {
        // Response sind die Sparten die generiert werden.
        $('#red').html(response);   //Die Sparten werden hier wieder hergeschrieben
    });
});
