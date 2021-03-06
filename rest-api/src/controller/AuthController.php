<?php 

class AuthController{

	public function index() {
		echo 'Auth Controller';
	}

	public function getUserInfo() {
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
		require_once('src/models/auth/authentication.php');
		require_once('src/config/Header.php');
		require_once('src/security/jwt_handler.php');
		$jwt = new JwtController();
		$token = $jwt->getToken();
		if($jwt->verification($token)){
			$userInfo = $jwt->verification($token);
			echo json_encode($userInfo);
		}else {
			echo json_encode(['request' => 'invalide token please try to login again!']);
		}
	}

	// Signin Methods
	public function signin()
	{
		if($_SERVER['REQUEST_METHOD'] === 'POST')
		{
			ini_set('display_errors', 1);
			ini_set('display_startup_errors', 1);
			error_reporting(E_ALL);
			require_once('src/models/auth/authentication.php');
			require_once('src/config/Header.php');
			require_once('src/security/jwt_handler.php');
			// echo 'maska';die;
			$jwt = new JwtController();
			$auth =  new Authentication();
			$data = json_decode(file_get_contents("php://input"));
			$email = $data->email;
			$password = $data->password;
			$result = $auth->signin($email, $password);
			if(!empty($result)){
				unset($result['password']);
				$token = $jwt->authorization($result);
				echo Authentication::message('200', $token, false);
			}else {
				echo Authentication::message('invalide email or password', null, null, true);
			}
		}
	}

	// Sign up Methods
	public function signup() {
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
		require_once('src/models/auth/authentication.php');
		require_once('src/config/Header.php');
		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			$data = json_decode(file_get_contents("php://input"));
			$full_name = $data->full_name;
			$email = $data->email;
			$password = $data->password;
			
			if (!empty($email) && !empty($full_name) && !empty($password)){
					$auth =  new Authentication();
					$result = $auth->signup($full_name, $email, $password);
					echo $result;
			} else {
				echo Authentication::message('Empty InputField!', null, null, true);
			}

		} else {
			echo Authentication::message('Internal server issue please contact the support Team',null ,true);
		}
	}

	//Delete User Methods
	public function deleteUser(){
		require_once('src/models/auth/authentication.php');
		require_once('src/config/Header.php');
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			ini_set('display_errors', 1);
			ini_set('display_startup_errors', 1);
			error_reporting(E_ALL);
			$user_id = $_POST['user_id'];
			if(!empty($user_id)){
				$auth = new Authentication();
				echo $auth->deleteUser($user_id);
			}else{
				echo Authentication::message('invalide request please contact support', null, true);
			}
		}
	}
}
