<?php
    //verificar que el usuario este logueado
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fundamentos2122.github.io/framework-css-gamadelgado60/css/framework.css">
    <title>Document</title>
</head>
<body class="container">
    <?php include("banner.php") ?>
    <div class="w-25">
        <img src="" id="foto_alumno">
        <p id="nombres"></p>
    </div>
    
    <script>
        const id_alumno = "" + <?php echo $_GET["id"]?> + "";
    
        getAlumno();

        function getAlumno()
        {
            var xhttp = new XMLHttpRequest();
            xhttp.open("GET", "../controllers/alumnosController.php?id=" + id_alumno,false);

            xhttp.onreadystatechange = function()
            {
                if(this.readyState == 4){
                    var alumno = JSON.parse(this.responseText);
                    
                    console.log(this.responseText);

                    var img_element = document.getElementById("foto_alumno");
                    var nombresA = document.getElementById("nombres");
                    img_element.src = "data:image/jpeg;base64," + alumno.foto;
                    nombresA = alumno.nombre_completo ;
                }
            };
            
            xhttp.send();
        }
    </script>
</body>
</html>