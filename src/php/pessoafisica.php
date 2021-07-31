<?php 
require "conexao.php";
//$pdo = mysqlConnect();

$nome = $datanasc = $sexo = $cpf = $email = $telefone = "";
$cep = $logradouro = $cidade = $estado = $senha = "";
if (isset($_POST["nome"])) $nome = $_POST["nome"];
if (isset($_POST["datanasc"])) $datanasc = $_POST["datanasc"];
if (isset($_POST["sexo"])) $sexo = $_POST["sexo"];
if (isset($_POST["cpf"])) $cpf = $_POST["cpf"];
if (isset($_POST["email"])) $email = $_POST["email"];
if (isset($_POST["telefone"])) $telefone = $_POST["telefone"];
if (isset($_POST["cep"])) $cep = $_POST["cep"];
if (isset($_POST["logradouro"])) $logradouro = $_POST["logradouro"];
if (isset($_POST["cidade"])) $cidade = $_POST["cidade"];
if (isset($_POST["estado"])) $estado = $_POST["estado"];
if (isset($_POST["senha"])) $senha = $_POST["senha"];

$senhaHash = password_hash($senha, PASSWORD_DEFAULT);

$sql = <<<SQL
  INSERT INTO pessoafisica (nome, senhaHash, datanasc, sexo, cpf, email, telefone, 
                      cep, logradouro, cidade, estado, id)
  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
  SQL;

  try{
    
    $id_pessoafisica = $pdo->lastInsertId();
      
    $stmt = $pdo->prepare($sql);
    if (!$stmt->execute([
      $nome, $senhaHash, $datanasc, $sexo, $cpf, $email, $telefone,
      $cep, $logradouro, $cidade, $estado, $id_pessoafisica
    ])) throw new Exception('Falha na inserção');

    $pdo->commit();
  }
  catch (Exception $e) {
    $pdo->rollBack();
    if ($e->errorInfo[1] === 1062)
      exit('Dados duplicados: ' . $e->getMessage());
    else
      exit('Falha ao cadastrar os dados: ' . $e->getMessage());
  }

?>