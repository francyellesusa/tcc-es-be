<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Login_Controller extends CI_Controller {
  function __construct(){
    parent::__construct();

        //carrega a model de acesso aos dados do aluno no construtor da classe
    $this->load->model('api/Aluno_DAO','ad');
  }

    //método que valida os dados do aluno no banco de dados
  public function validar()
  {
        //dados recebidos via post
    $email = $this->input->post('email');
        $senha = $this->input->post('senha'); // a senha do aluno vem criptografada do front-end

        //valida os dados do aluno no banco
        $result = $this->ad->validarLogin($email, $senha);

        // verifica se os dados informados foram encontrados no banco
        if (!empty($result)) {
          $message = [
            'status' => TRUE,
            'message' => 'Dados válidos',
            'cpf' => $result[0]->cpf
          ];
        }else{
          $message = [
            'status' => FALSE,
            'message' => 'Dados inválidos',
            'cpf' => null
          ];
        }


        //retorna status ao app
        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($message));

      }

    //método que busca os dados do aluno no banco de dados para autenticar o acesso
      public function autenticar($cpf)
      {
        //verifica se o cpf não é vazio
        if (empty($cpf)) {
          $message = [
            'status' => FALSE,
            'message' => 'Falha no autenticação dos dados'
          ];
        }else{
            //busca os dados do aluno por cpf
          $result = $this->ad->getDadosAluno($cpf);

          if (empty($result)) {
            $message = [
              'status' => FALSE,
              'message' => 'Erro ao buscar dados do aluno'
            ];
          }else{
              //cria sessões
            $dados_aluno = [
              'nome' => $result[0]->nome,
              'email' => $result[0]->email,
              'cpf' => $result[0]->cpf
            ];

            $this->session->set_userdata('aluno', $dados_aluno);

              //retorna os dados do aluno para o app
            $message = [
              'status' => TRUE,
              'message' => 'Usuário '.$result[0]->nome.' autenticado',
              'nome' => $result[0]->nome,
              'email' => $result[0]->email,
              'cpf' => $result[0]->cpf
            ];
          }

        }
        $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($message));

      }

    }
