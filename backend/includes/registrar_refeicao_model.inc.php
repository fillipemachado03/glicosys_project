<?php
declare(strict_types=1);


function get_food_name(PDO $pdo, array $alimento) :int {
$query='SELECT nome from alimentos where id_alimentos = :id'; 
$stmt= $pdo->prepare($query);
$stmt->bindParam(':id', $alimento['id']);
$stmt->execute();
$results = $stmt->fetch(PDO::FETCH_ASSOC);

return $results ? $results['nome'] : null;
}

function set_meal(PDO $pdo, int $user_id, string $titulo, string $observacao, int $cg, string $data, array $alimentos){
$query = 'INSERT into refeicoes(user_fk, titulo, observacao, cg, data_horario) values(:user, :titulo, :obs, :cg, :dataI);';
$stmt = $pdo->prepare($query);

$stmt->bindParam(':user', $user_id);
$stmt->bindParam(':titulo', $titulo);
$stmt->bindParam(':obs', $observacao);
$stmt->bindParam(':cg', $cg);
$stmt->bindParam(':dataI', $data);

$result = $stmt->execute();
$meal_id = (int) $pdo->lastInsertId();


set_food_rel($pdo, $alimentos, $meal_id);
}



function set_food_rel(PDO $pdo, array $alimentos, int $meal_id){

// $query='INSERT into alimentos_refeicoes(alimentos_fk, refeicoes_fk, porcao_gramas) values';
// $i=1;
// foreach($alimentos as $Alimento){
// $alimento_id = get_food_id($pdo, $Alimento)['id_alimentos'];
// if($i<count($alimentos)){
//     $query = $query. '(:alimentos_fk, :refeicoes_fk, :porcao),';
// }else{
// $query = $query. '(:alimentos_fk, :refeicoes_fk, :porcao);';
// }
// $i++;
// $stmt = $pdo->prepare($query);
// $stmt->bindParam('alimentos_fk', $alimento_id);
// $stmt->bindParam('refeicoes_fk', $meal_id);
// $stmt->bindParam('porcao', $Alimento['porcao']);
// }
// $stmt->execute();

    $values = [];
    $params = [];

    foreach ($alimentos as $i => $Alimento) {
        $values[] = "(:alimento_$i, :refeicao_$i, :porcao_$i)";

        $params[":alimento_$i"] = $Alimento['id'];
        $params[":refeicao_$i"] = $meal_id;
        $params[":porcao_$i"] = $Alimento['porcao'];
    }

    $query = 'INSERT INTO alimentos_refeicoes
              (alimentos_fk, refeicoes_fk, porcao_gramas)
              VALUES ' . implode(', ', $values);

    $stmt = $pdo->prepare($query);
    $stmt->execute($params);

}

function get_each_ig_carbs(PDO $pdo, array $alimentos): array
{
    $placeholders = [];
    $params = [];

        foreach ($alimentos as $i => $alimento) {

            $placeholder = ":id_$i";

            $placeholders[] = $placeholder;

            $params[$placeholder] = $alimento['id'];
        }

        $query = 'SELECT id_alimentos, ig, carb_por_grama
                FROM alimentos
                WHERE id_alimentos IN (' . implode(', ', $placeholders) . ')';

        $stmt = $pdo->prepare($query);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
