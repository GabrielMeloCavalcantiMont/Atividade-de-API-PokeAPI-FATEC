<!-- Acabei me animando demais com a atividade e fiz coisas além do enunciado, espero que não seja um problema.  -->

<?php
    $pokemon = null;
    $erro = "";

    if (isset($_GET["nome"]) && trim($_GET["nome"]) != "") {
        $nome = strtolower(trim($_GET["nome"]));
        $url = "https://pokeapi.co/api/v2/pokemon/" . urlencode($nome);

        $resposta = @file_get_contents($url);

        if ($resposta === false) {
            $erro = "Pokémon não encontrado. Confira se o nome digitado está correto e tente novamente.";
        } else {
            $dados = json_decode($resposta, true);

            $pokemon = [
                "nome"        => ucfirst($dados["name"]),
                "id"          => $dados["id"],
                "altura"      => $dados["height"] / 10,
                "peso"        => $dados["weight"] / 10,
                "foto"        => $dados["sprites"]["other"]["official-artwork"]["front_default"],
                "tipos"       => [],
                "habilidades" => []
            ];

            foreach ($dados["types"] as $t) {
                $pokemon["tipos"][] = ucfirst($t["type"]["name"]);
            }
            foreach ($dados["abilities"] as $a) {
                $pokemon["habilidades"][] = ucfirst($a["ability"]["name"]);
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Atividade da PokéAPI - Gabriel Melo Cavalcanti Monteiro</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #8bbaff;
            margin: 0;
            padding: 40px 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        h1 {
            margin-bottom: 8px;
        }

        input[type="text"] {
            padding: 10px 14px;
            font-size: 16px;
            border: 2px solid #ccc;
            border-radius: 8px;
            width: 260px;
        }

        form {
            display: flex;
            gap: 8px;
            margin: 20px 0;
        }

        button {
            padding: 10px 20px;
            font-size: 16px;
            background: #e63946;
            color: #fff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        button:hover {
            background: #c92d3a;
        }

        .card {
            display: flex;
            align-items: center;
            gap: 40px;
            background: #fff;
            padding: 30px 40px;
            border-radius: 16px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
            margin-top: 20px;
            text-align: left;
        }

        .card img {
            width: 500px;
            height: 500px;
            object-fit: contain;
        }

        .card h2 {
            margin-top: 0;
            font-size: 28px;
        }

        .card p {
            font-size: 18px;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <h1><strong>Buscar Pokémon</strong></h1>
    <p>Digite o nome ou número do Pokémon que deseja buscar:</p>
    <br>

    <form method="GET">
        <input type="text" name="nome" placeholder="Ex: pikachu, charizard, 25">
        <button type="submit">Buscar</button>
    </form>

    <?php if ($erro): ?>
        <p style="color: red;"><?= $erro ?></p>
    <?php endif; ?>

    <?php if ($pokemon): ?>
        <div class="card">
            <img src="<?= $pokemon["foto"] ?>" alt="<?= $pokemon["nome"] ?>">
            
            <div class="info">
                <h2>#<?= $pokemon["id"] ?> - <?= $pokemon["nome"] ?></h2>
                <p><strong>Altura:</strong> <?= $pokemon["altura"] ?> m</p>
                <p><strong>Peso:</strong> <?= $pokemon["peso"] ?> kg</p>
                <p><strong>Tipo:</strong> <?= implode(", ", $pokemon["tipos"]) ?></p>
                <p><strong>Habilidades:</strong> <?= implode(", ", $pokemon["habilidades"]) ?></p>
            </div>
        </div>
    <?php endif; ?>
</body>
</html>