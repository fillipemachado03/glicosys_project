<?php
declare(strict_types=1);

require_once 'registrar_refeicao_model.inc.php';

function normalize_array(array $alimentos_i, array $porcoes): array
{
    $alimentos = [];

    foreach ($alimentos_i as $index => $id_alimento) {
        $alimentos[] = [
            'id' => (int) $id_alimento,
            'porcao' => (float) ($porcoes[$index] ?? 0)
        ];
    }

    return $alimentos;
}

function create_meal($pdo, $user_id, $titulo, $obs, $data, $alimentos){
    $cg =(int)get_total_cg($pdo, $alimentos);
set_meal($pdo, $user_id, $titulo, $obs, $cg, $data, $alimentos);
}

function get_total_cg(PDO $pdo, array $alimentos): float
{
    $res = get_each_ig_carbs($pdo, $alimentos);

    $dados_alimentos = [];

    foreach ($res as $dados) {
        $dados_alimentos[$dados['id_alimentos']] = $dados;
    }

    $cg = 0.0;

    foreach ($alimentos as $alimento) {

        $id = $alimento['id'];

        if (!isset($dados_alimentos[$id])) {
            continue;
        }

        $ig = (float) $dados_alimentos[$id]['ig'];
        $carb_per_gram = (float) $dados_alimentos[$id]['carb_por_grama'];
        $porcao = (float) $alimento['porcao'];

        $carboidratos = $carb_per_gram * $porcao;

        $cg_alimento = ($ig * $carboidratos) / 100;

        $cg += $cg_alimento;
    }

    return $cg;
}