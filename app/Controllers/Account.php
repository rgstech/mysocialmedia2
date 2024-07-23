<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use CodeIgniter\I18n\Time;

class Account extends BaseController
{

    private $usuariosModel;

	
	function __construct()
	{
		helper('form');

		$this->usuariosModel = new UserModel();
	}


	public function signup()
	{

		if (session()->isLoggedIn == true) { //se ja tive logado vai para home / if user is already logged got to home page

			return redirect()->to('/');
		}

		return view('account/signup');
	}

	public function createAccount()
	{


		$validationRule = [
			'userfile'  => [
				'label' => 'Image File',
				'rules' => 'uploaded[arquivo]'
					. '|is_image[arquivo]'
					. '|mime_in[arquivo,image/jpg,image/jpeg]'
					. '|max_size[arquivo,30]'
					. '|max_dims[arquivo,200,200]',
			],
			'nome'     => 'required|min_length[3]',
			'username' => 'required|min_length[5]',
			'password' => 'required|min_length[8]',
			'passconf' => 'required|matches[password]',
			'email'    => 'required|valid_email',
			'phone'    => 'min_length[8]|numeric',
			'gender'   => 'required'
		];



		$data = $this->request->getPost(); //pega todos os campos

		if (count($data) == 0) { // array vazio significa que o usuario chamou o metodo fora do form ou com dados vazios 
			// entao volta para a home 
			// empty array means the user call method outside form or with empty data so it return to home 

			return redirect()->to('/');
		}

		$arquivo  = ($this->request->getFile('arquivo')) ? $this->request->getFile('arquivo') : null; //verficar se o arquivo valido/ verify if file is valid
		$filePath = '';


		$myTime = new Time('now', 'America/Recife', 'pt_BR');

		$gender = null;

		switch ((string)($data['gender'])) {

			case 'm':

				$gender = 'm';
				break;

			case 'f':

				$gender = 'f';
				break;

			default:

				$gender = null;
				break;
		}


		if (!$this->validate($validationRule)) { // inicio if validação 

			$data = ['errors' => $this->validator->getErrors()];
			return view('account/signup', $data);

		} else {


			$dados = [
				'infoArquivo' => []
			];


			if ($arquivo && !$arquivo->isValid()) {

		
				return view('account/signup');

				

			} elseif ($arquivo && $arquivo->isValid() && !$arquivo->hasMoved()) {

				$arquivo->move(ROOTPATH . 'public/images', (string)$data['username'] . '.' . $arquivo->getClientExtension());

				$filePath = 'images/' . (string)$data['username'] . '.' . $arquivo->getClientExtension();

			}


			
			$dataToSave = [
				'usu_login'  => (string)$data['username'],
				'usu_senha'  => password_hash((string)$data['password'], PASSWORD_DEFAULT),
				'usu_nome'   => $data['nome'],
				'usu_email'  => $data['email'],
				'usu_tel'    => ($data['phone'] ? $data['phone'] : null),
				'usu_img'    => (string)$filePath,
				'usu_dt_cad' => ((array)$myTime)['date'],
				'usu_sexo'   => $gender,
				'usu_bio'    => $data['bio']
			];


			$result = $this->usuariosModel->save($dataToSave);


			return view('account/sucessful_created');
		} // end  else validation 

	} //end createAccount

} //end class
