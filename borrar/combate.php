<!DOCTYPE html>
<html>
<head>
    <style>
        .battle-container {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
            border-style: solid;
        }

        .pokemon-info {
            text-align: center;
        }

        .attack-log {
            margin-top: 20px;
            padding: 10px;
            border-style: double;
        }

        h2{
            text-align: center;
        }
    </style>
</head>
<body>
<?php
class Pokemon
{
    private $name;
    private $hp;
    private $type;
    private $attacks;

    public function __construct($name, $hp, $type, $attacks)
    {
        $this->name = $name;
        $this->hp = $hp;
        $this->type = $type;
        $this->attacks = $attacks;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getHP()
    {
        return $this->hp;
    }

    public function getType()
    {
        return $this->type;
    }

    public function takeDamage($damage)
    {
        $this->hp -= $damage;
    }

    public function isAlive()
    {
        return $this->hp > 0;
    }

    public function attack($opponent, $attackIndex)
    {
        $attack = $this->attacks[$attackIndex];
        $damage = $attack['damage'];
        $attackName = $attack['name'];
        $attackType = $attack['type'];

        // Efectos de tipo
        $typeEffectiveness = $this->getTypeEffectiveness($attackType, $opponent->getType());
        $damage *= $typeEffectiveness;

        $opponent->takeDamage($damage);
        $log = "{$this->name} ataca a {$opponent->getName()} con {$attackName} ({$attackType}) y le hace {$damage} de daño.";
        echo "<div class='attack-log'>$log</div>";

    }

    private function getTypeEffectiveness($attackType, $opponentType)
    {
        $typeChart = [
            'fuego' => ['planta' => 2, 'agua' => 0.5, 'fuego' => 0.5],
            'agua' => ['fuego' => 2, 'planta' => 0.5, 'agua' => 0.5],
            'planta' => ['agua' => 2, 'fuego' => 0.5, 'planta' => 0.5],
        ];

        return $typeChart[$attackType][$opponentType] ?? 1;
    }
}

function displayHP($pokemon)
{
    echo "<div class='pokemon-info'>{$pokemon->getName()}: {$pokemon->getHP()} HP</div>";
}

$pokemonName = $_POST['pokemon'];

$pokemon1Attacks = [
    ['name' => 'Llamarada', 'damage' => 20, 'type' => 'fuego'],
    ['name' => 'Arañazo', 'damage' => 10, 'type' => 'normal'],
    ['name' => 'Embestida', 'damage' => 15, 'type' => 'normal'],
];

$pokemon2Attacks = [
    ['name' => 'Placaje', 'damage' => 15, 'type' => 'normal'],
    ['name' => 'Hoja Afilada', 'damage' => 18, 'type' => 'planta'],
    ['name' => 'Latigazo', 'damage' => 12, 'type' => 'planta'],
];

$pokemon3Attacks = [
    ['name' => 'Pistola Agua', 'damage' => 20, 'type' => 'agua'],
    ['name' => 'Gruñido', 'damage' => 10, 'type' => 'normal'],
    ['name' => 'Burbuja', 'damage' => 15, 'type' => 'agua'],
];

$pokemons = [
    'charmander' => new Pokemon("Charmander", 100, 'fuego', $pokemon1Attacks),
    'bulbasaur' => new Pokemon("Bulbasaur", 120, 'planta', $pokemon2Attacks),
    'squirtle' => new Pokemon("Squirtle", 110, 'agua', $pokemon3Attacks),
];

$selectedPokemon = $pokemons[$pokemonName];
?>

<div class="battle-container">
    <div>
        <h2><?php echo $selectedPokemon->getName(); ?></h2>
        <img src="<?php echo $pokemonName; ?>.png" alt="<?php echo $selectedPokemon->getName(); ?>">
        <?php displayHP($selectedPokemon); ?>
    </div>
    <div>
        <h2>Enemigo</h2>
        <?php
        $opponentName = array_rand($pokemons);
        while ($opponentName === $pokemonName) {
            $opponentName = array_rand($pokemons);
        }
        $opponent = $pokemons[$opponentName];
        ?>
        <img src="<?php echo $opponentName; ?>.png" alt="<?php echo $opponent->getName(); ?>">
        <?php displayHP($opponent); ?>
    </div>
</div>

<div class="attack-log">
    <h3>Registro de Ataques:</h3>
</div>

<?php
while ($selectedPokemon->isAlive() && $opponent->isAlive()) {
    $attackIndex1 = rand(0, count($pokemon1Attacks) - 1);
    $attackIndex2 = rand(0, count($pokemon2Attacks) - 1);

    $selectedPokemon->attack($opponent, $attackIndex1);
    if (!$opponent->isAlive()) {
        echo "<br>{$opponent->getName()} ha sido derrotado. {$selectedPokemon->getName()} gana la batalla!<br>";
        break;
    }

    $opponent->attack($selectedPokemon, $attackIndex2);
    if (!$selectedPokemon->isAlive()) {
        echo "<br>{$selectedPokemon->getName()} ha sido derrotado. {$opponent->getName()} gana la batalla!<br>";
        break;
    }
}
?>
<form action="combate.php" method="post">
    <input type="hidden" name="pokemon" value="<?php echo $pokemonName; ?>">
    <input type="submit" value="Repetir el Combate">
</form>

<form action="seleccionar_pokemon.php">
    <input type="submit" value="Volver a la Página Principal">
</form>
</body>
</html>
