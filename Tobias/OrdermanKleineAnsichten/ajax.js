
    $('#back').click(function(){
        var clickBtnValue = $(this).val();
        var ajaxurl = "code.php",
        data =  {'action': clickBtnValue};
        
        $.post(ajaxurl, data, function (response) {
            // Response sind die Sparten die generiert werden.
            $('#red').html(response);   //Die Sparten werden hier wieder hergeschrieben
        });
    });
