<?php
require_once 'database.php';

$pdo = getDbConnection();
$limit = 25;
$sql = "
    SELECT * 
    FROM pokemons 
    ORDER BY weight DESC 
    LIMIT :limit
";
$stmt = $pdo->prepare($sql);
$stmt->execute([':limit' => $limit]);
$heavierPokemons = $stmt->fetchAll();

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokedex del Profesor Oak</title>
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>
    <div class="container">
        <header>
            <h1>Pokedex</h1>
            <button id="newPokemonBtn" class="btn">Nuevo Pokemon</button>
        </header>

        <main>
            <table>
                <thead>
                    <tr>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Salud</th>
                        <th>Altura</th>
                        <th>Peso</th>
                        <th>Número</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($heavierPokemons as $heavierPokemon): ?>
                        <tr>
                            <td style="text-align: center;">
                                <img src="<?= $heavierPokemon['url']; ?>" class="pokemon-sprite">
                            </td>
                            <td style="text-align: center;">
                                <?= $heavierPokemon['name']; ?>
                            </td>
                            <td style="text-align: center;">
                                <?= $heavierPokemon['health']; ?>
                            </td>
                            <td style="text-align: center;">
                                <?= $heavierPokemon['height']; ?>
                            </td>
                            <td style="text-align: center;">
                                <?= $heavierPokemon['weight']; ?>
                            </td>
                            <td style="text-align: center;">
                                <?= $heavierPokemon['number']; ?>
                            </td>
                        </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </main>
    </div>

    <div id="pokemonModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Registrar Nuevo Pokemon</h2>
            <form id="newPokemonForm">
                <div class="form-group">
                    <label for="name">Nombre:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="image">Imagen (url):</label>
                    <input type="text" id="image" name="image" required>
                </div>
                <div class="form-group">
                    <label for="health">Salud:</label>
                    <input type="number" id="health" name="health" required>
                </div>
                <div class="form-group">
                    <label for="height">Altura:</label>
                    <input type="number" id="height" name="height" required>
                </div>
                <div class="form-group">
                    <label for="weight">Peso:</label>
                    <input type="number" id="weight" name="weight" required>
                </div>
                <div class="form-group">
                    <label for="number">Número:</label>
                    <input type="number" id="number" name="number" required>
                </div>
                <button type="submit" class="btn">Guardar</button>
            </form>
        </div>
    </div>

    <script>
        var modal = document.getElementById("pokemonModal");
        var btn = document.getElementById("newPokemonBtn");
        var span = document.getElementsByClassName("close")[0];

        btn.onclick = function() {
            modal.style.display = "block";
        }

        span.onclick = function () {
            modal.style.display = "none";
        }

        document.getElementById('newPokemonForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch('pokemonAdd.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Pokemon añadido correctamente!');
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        })
    </script>
</body>

</html>