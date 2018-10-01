<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Aluno_DAO extends CI_Model {	
    public function __construct(){
      parent::__construct();
    }
	
	public function validarLogin($email, $senha)
	{			
		$this->db->select('cpf');
		$this->db->from('Alunos');
		$this->db->where(['email'=>$email, 'senha'=>$senha]);
		$query = $this->db->get();
		
		return $query->result();	
	}

	public function getDadosAluno($cpf)
	{			
		$this->db->select('nome, email, cpf');
		$this->db->from('Alunos');
		$this->db->where('cpf', $cpf);
		$query = $this->db->get();
		
		return $query->result();	
	}
 }
?>