<?php
session_start();

include_once './conexao.php';

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

//Converter a data e hora do formato brasileiro para o formato do Banco de Dados
$data_start = str_replace('/', '-', $dados['start']);
$data_start_conv = date("Y-m-d H:i:s", strtotime($data_start));

$query_event = "UPDATE events SET title=:title, description=:description, color=:color, start=:start WHERE id=:id";

$update_event = $conn->prepare($query_event);
$update_event->bindParam(':title', $dados['title']);
$update_event->bindParam(':description', $dados['description']);
$update_event->bindParam(':color', $dados['color']);
$update_event->bindParam(':start', $data_start_conv);
$update_event->bindParam(':id', $dados['id']);

if ($update_event->execute()) {
    $retorna = ['sit' => true, 'msg' => '<div class="alert alert-success" role="alert">Agendamento editado com sucesso!</div>'];
    $_SESSION['msg'] = '<div class="alert alert-success" role="alert">Agendamento editado com sucesso!</div>';
} else {
    $retorna = ['sit' => false, 'msg' => '<div class="alert alert-danger" role="alert">Erro: Agendamento não foi editado com sucesso!</div>'];
}


header('Content-Type: application/json');
echo json_encode($retorna);
