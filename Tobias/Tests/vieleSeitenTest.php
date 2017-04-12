<html>
    <head>
        <script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
        <script>
                $(document).ready(function(){
                    alert("Alda");
                    $("#next").click(function(){
                        $("#blue").load("next.php");
                    });
                });
            </script>
        <title>Viele Seiten in einer Seite</title>
    </head>
    <body>    
        <div style="background-color: red">
            Sparten
        <?php //include("ansicht.php") ?>
        </div>
         <div style="background-color: blue" id="blue">
             Rechnung
        <?php include("ansicht.php") ?>
        </div>
         <div style="background-color: green">
             Rest (Abbrechen, Senden, usw.)
        <?php //include_once("ansicht.php") ?>
        </div>
    </body>
</html>