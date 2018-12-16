<?php
require_once("config.php");

// Carrega um usuário
//$usuario = new Usuario();
//$usuario->loadById(3);
//echo $usuario;

// Carrega uma lista de usuários
//$lista = Usuario::getList();
//echo json_encode($lista);

// Carrega um usuário pelo login
//$search = Usuario::search("marc");
//echo json_encode($search);

// Carrega um usuário pelo login e senha
//$login = new Usuario();
//$login->login("marcus","**hahaa*");
//echo $login;

// Inserir um usuário
//$aluno = new Usuario("anonimo", "%sdadsa¨$#");
//$aluno->insert();
//echo $aluno;

// Atualiar login e senha 
//$usuario = new Usuario();
//$usuario->loadById(7);
//$usuario->update("professor","lalalal");
//echo $usuario;

// Deletar usuário
$usuario = new Usuario();
$usuario->loadById(13);
$usuario->delete();
echo $usuario;

?>