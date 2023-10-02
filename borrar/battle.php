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
            text-align:center;
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

$pokemon1 = new Pokemon("Charmander", 100, 'fuego', $pokemon1Attacks);
$pokemon2 = new Pokemon("Bulbasaur", 120, 'planta', $pokemon2Attacks);
$pokemon3 = new Pokemon("Squirtle", 110, 'agua', $pokemon3Attacks);

$pokemons = [$pokemon1, $pokemon2, $pokemon3];
shuffle($pokemons);
$pokemon1 = $pokemons[0];
$poke1_img = $pokemon1->getName().".png";
$pokemon2 = $pokemons[1];
$poke2_img = $pokemon2->getName().".png";
?>


<div class="battle-container">
    <div>
        <h2><?php echo $pokemon1->getName(); ?></h2>
        <img src="<?php echo $poke1_img;?>">
        <?php displayHP($pokemon1); ?>
    </div>
    <div>
        <h2><?php echo $pokemon2->getName(); ?></h2>
        <img src="<?php echo $poke2_img;?>">
        <?php displayHP($pokemon2); ?>
    </div>
</div>

<div class="attack-log">
    <h3>Registro de Ataques:</h3>
</div>

<?php
while ($pokemon1->isAlive() && $pokemon2->isAlive()) {
    $attackIndex1 = rand(0, count($pokemon1Attacks) - 1);
    $attackIndex2 = rand(0, count($pokemon2Attacks) - 1);

    $pokemon1->attack($pokemon2, $attackIndex1);
    if (!$pokemon2->isAlive()) {
        echo "<br>{$pokemon2->getName()} ha sido derrotado. {$pokemon1->getName()} gana la batalla!<br>";
        break;
    }

    $pokemon2->attack($pokemon1, $attackIndex2);
    if (!$pokemon1->isAlive()) {
        echo "<br>{$pokemon1->getName()} ha sido derrotado. {$pokemon2->getName()} gana la batalla!<br>";
        break;
    }
}
?>
</body>
</html>
