<?php
	
	class Usuario {

		// Campos da tabela usuario
		private $idusuario;
		private $deslogin;
		private $dessenha;
		private $dtcadastro;

		// Getters
		public function getIdusuario(){
			return $this->idusuario;
		}

		public function getDeslogin(){
			return $this->deslogin;
		}

		public function getDessenha(){
			return $this->dessenha;
		}

		public function getDtcadastro(){
			return $this->dtcadastro;
		}

		// Setters
		public function setIdusuario($value){
			return $this->idusuario = $value;	
		}

		public function setDeslogin($value){
			return $this->deslogin = $value;
		}

		public function setDessenha($value){
			return $this->dessenha = $value;
		}

		public function setDtcadastro($value){
			return $this->dtcadastro = $value;
		}

		// Método construtor
		// OBS: Como estamos passando uma string vazia como valor para os dois parâmetros, não se torna obrigatorio passar o login e senha quando se instância a classe
 		public function __construct($login = "", $password = ""){
			$this->setDeslogin($login);
			$this->setDessenha($password);
		}

		// Método para selecionar dados de um Id de usuário
		public function loadById($id){
			$sql = new Sql();
			$results = $sql->select("SELECT * FROM tb_usuarios WHERE idusuario = :ID", array(
				":ID"=>$id
			));

			// Verificando se existe dados do ID pesquisado
			if(count($results) > 0){
				// Setando os dados associativos que foram passados pelo array
				$this->setData($results[0]);
			}
		}

		// Retorna lista de todos os usuários da tabela
		public static function getList(){
			$sql = new Sql();
			// Retornando lista de todos os usuários ordenado pelo campo deslogin
			return $sql->select("SELECT * FROM tb_usuarios ORDER BY deslogin");
		}

		// Retorna usuário(s) referente a um login
		public static function search($login){
			$sql = new Sql();
			// Retornando um usuário pelo login
			return $sql->select("SELECT * FROM tb_usuarios WHERE deslogin LIKE :SEARCH ORDER BY deslogin", array(
				":SEARCH"=>"%".$login."%"
			));
		}

		// Autenticando usuário
		public function login($login, $password){
			$sql = new Sql();
			$results = $sql->select("SELECT * FROM tb_usuarios WHERE deslogin = :LOGIN and dessenha = :PASS ", array(
				":LOGIN"=>$login,
				":PASS"=>$password
			));

			// Verificando se existe dados do ID pesquisado
			if(count($results) > 0){
				// Setando os dados associativos que foram passados pelo array
				$this->setData($results[0]);
			}else
				// Tratando se login e/ou senhas estiverem incorretos
				throw new Exception("Login e/ou senha incorretos");
		}	

		// 
		public function setData($data){
			// Setando os dados associativos que foram passados pelo array
			$this->setIdusuario($data['idusuario']);
			$this->setDeslogin($data['deslogin']);
			$this->setDessenha($data['dessenha']);
			$this->setDtcadastro(new DateTime($data['dtcadastro']));
		}


		// Inserir novo usuário 
		public function insert(){
			$sql = new Sql();

			$results = $sql->select("CALL sp_usuarios_insert(:LOGIN, :PASSWORD)", array(
				":LOGIN"=>$this->getDeslogin(),
				":PASSWORD"=>$this->getDessenha()
			));

			if(count($results) > 0){
				// Setando os dados associativos que foram passados pelo array
				$this->setData($results[0]);
			}

		}

		// Atualizar lonig e senha
		public function update($login, $passsword){
			
			$this->setDeslogin($login);
			$this->setDessenha($passsword);

			$sql = new Sql();

			$sql->query("UPDATE tb_usaurios SET deslogin = :LOGIN, dessenha = :PASSWORD where idusuario = :ID", array(
				":LOGIN"=>$this->getDeslogin(),
				":PASSWORD"=>$this->getDessenha(),
				":ID"=>$this->getIdusuario()
			));
		}

		// Deletar usuário
		public function delete(){
			$sql = new Sql();
			$sql->query("DELETE FROM tb_usuarios WHERE idusuario = :ID",array(
				":ID"=>$this->getIdusuario()
			));

			// Apagar dados da memória do objeto
			$this->setIdusuario(NULL);
			$this->setDeslogin(NULL);
			$this->setDessenha(NULL);
			$this->setDtcadastro(NULL);
		}

		// Exibindo dados em json
		public function __toString(){

			return json_encode(array(
				"idusuario"=>$this->getIdusuario(),
				"deslogin"=>$this->getDeslogin(),
				"dessenha"=>$this->getDessenha(),
				"dtcadastro"=>$this->getDtcadastro()->format("d/m/Y H:i:s")
			));
		}


	}	
	
?>