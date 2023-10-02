<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h1>Selecciona tu Pokémon</h1>
    <form action="combate.php" method="post">
        <div class="container">
            <label for="pokemon-charmander">
                <input type="radio" id="pokemon-charmander" name="pokemon" value="charmander" required>
                <div class="pokemon-selection">
                    <img src="charmander.png" alt="Charmander">
                    <h2>Charmander</h2>
                </div>
            </label>
            <label for="pokemon-bulbasaur">
                <input type="radio" id="pokemon-bulbasaur" name="pokemon" value="bulbasaur" required>
                <div class="pokemon-selection">
                    <img src="bulbasaur.png" alt="Bulbasaur">
                    <h2>Bulbasaur</h2>
                </div>
            </label>
            <label for="pokemon-squirtle">
                <input type="radio" id="pokemon-squirtle" name="pokemon" value="squirtle" required>
                <div class="pokemon-selection">
                    <img src="squirtle.png" alt="Squirtle">
                    <h2>Squirtle</h2>
                </div>
            </label>
        </div>
        <input type="submit" value="Comenzar el Combate">
    </form>
</body>
</html>
