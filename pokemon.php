<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>DWES 9 JGM</title>
        <style>@import url(estilo.css);</style>
    </head>
    <body>
        <header>
            <div id="header">
                <img src="logo.png" id="logo">
                <div id="titulo">
                    <h1>Pokédex</h1>
                </div>
            </div>
        </header>
        <hr>

        <div id="buscar">
            <!-- Creación del HTML que envía los datos a este script PHP a través de GET-->                    
            <form action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>" method="get">
                <label for="id">Introduzca el id del pokemon (1 - 898): </label>
                <input id="id" name="id" type="text">
                <input type="submit" value="Buscar">
            </form>
        </div>
        <hr>
        <section class="contenido">
            <?php
            $url = "";
            // Si pasamos un id por GET
            if(isset($_GET["id"])){
                $id = $_GET["id"];
                // Si el id es mayor que cero y menor que 899
                if ($id > 0 && $id < 899){
                    // Cargamos en una variable la api pokemon
                    $url = "https://pokeapi.co/api/v2/pokemon/" . $id;
                    // Obtenemos el contenido en formato JSON
                    $infoPokemon = file_get_contents($url);
                    // Decodificamos el JSON y obtenemos un array asociativo en PHP
                    $infoPokemon = json_decode($infoPokemon, true);
            ?>        
                <div id="poke">
                    <?php
                    // De la Info cargada, obtenemos las imagenes según detalla la API
                    $imagen = $infoPokemon["sprites"]["other"]["official-artwork"]["front_default"];
                    echo "Normal: <br>";
                    echo "<img  src = '" . $imagen . "' /> <br>";                  

                    $imagen2 = $infoPokemon["sprites"]["other"]["official-artwork"]["front_shiny"];
                    echo "Shiny: <br>";
                    echo "<img src = '" . $imagen2 . "' /> <br>";
                    ?>
                </div>
            <?php 
                    // Recuperamos la información            
                    echo "ID: " . $infoPokemon["id"] . "<br>";
                    echo "Nombre: " . ucfirst($infoPokemon["name"]) . "<br>";
                    echo "Altura: " . $infoPokemon["height"]. " cm<br>";
                    echo "Peso: " . $infoPokemon["weight"] . " gr<br>";

                    $tipos = $infoPokemon["types"];
                    // Si hay más de uno tipos si no tipo
                    if(count($tipos)>1) {
                        echo "Tipos: ";
                    } else {
                        echo "Tipo: ";
                    }
                    // Para cada tipo, se obtiene la URL correspondiente a la API de PokeAPI para ese tipo.
                    foreach ($tipos as $tipo){
                        $url = $tipo["type"]["url"];
                        $infoTipo = file_get_contents($url);
                        $infoTipo = json_decode($infoTipo, true);
                        // La variable contiene el tipo especificado y con names 5 seleccionamos idioma español y cargamos en name.
                        echo $infoTipo["names"]["5"]["name"] . " ";    
                    }
                    echo "<br>";
                }else {
                            echo "El ID no es correcto, debe ser un número entre 1-898";
                }            
            }         
            ?>
        </section>
        <hr>
        <footer id="footer">
            <div>Joaquim Gisbert Montserrat</div>
            <div>Basado en la Api de Pokemon</div>
        </footer>
    </body>
</html>