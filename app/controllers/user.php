<?php

class User extends Controller
{
	private $_userDAO;

	public function __construct()
	{	
		//$this->_userDAO = $this->model('UserDAO');
		parent::__construct();
	}

	/*load sign in form*/
	public function index()
	{
		if(!isset($_SESSION['user']))
		{
 			$data = array(
				'title'     => "SportGear-User Sign In",
				'mainView'  => 'signIn',
				'brands'    => $this->_brands,
				'sportTypes'=> $this->_sports,
				'gearTypes' => $this->_gears,
				'user'      => 'user',
				'info'      => null
				);
			$this->view('page', $data);

		}
		else
		{
			//redirect to user profile
		}
	}

	public function signUp($info = null)
	{
		$data = array(
				'title'     => "SportGear-User Sign Up",
				'mainView'  => 'signUp',
				'brands'    => $this->_brands,
				'sportTypes'=> $this->_sports,
				'gearTypes' => $this->_gears,
				'user'      => 'user',
				'info'      => $info
				);
		$this->view('page', $data);
	}

	public function signUpProcess()
	{
		$requiredFields = array('username', 'password1', 'password2', 'email');

		$info = '';
		$isValid = true;

		foreach($requiredFields as $requiredField)
		{
			if (!isset($_POST[$requiredField]) || !$_POST[$requiredField])
			{
				$info .= "$requiredField is required!<br>";
				$isValid = false; 
			}
		}
		$username = $_POST['username'];
		$password1= $_POST['password1'];
		$password2= $_POST['password2'];
		$email    = $_POST['email'];

		$pattern = '/^[a-zA-Z0-9_-]*$/';
		if(!preg_match($pattern, $username))
		{
			$info .= "Username can only contain \"a-zA-Z0-9_-\"!<br>";
			$isValid = false;
		}

		if(strlen($username) < 3)
		{
			$info .= "Username must be at least 3 characters!<br>";
			$isValid = false;
		}

		if(strlen($password1) < 8)
		{
			$info .= "Password must be at least 8 characters!<br>";
			$isValid = false;
		}

		if(!preg_match($pattern, $password1))
		{
			$info .= "Password can only contain \"a-zA-Z0-9_-\"!<br>";
			$isValid = false;
		}

		if($password1 != $password2)
		{
			$info .= "Passwords must match!<br>";
			$isValid = false;
		}

		if(!$this->validateEmail($email))
		{
			$info .= "Please provide a valid email address to receive activate email!<br>";
			$isValid = false;
		}

		if(!$isValid)
		{
			$this->signUp($info);
		}


	}

	public function validateEmail($email)
	{
		$regex = '/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/';

		if(preg_match($regex, $email))
		{
			return true;
		}

		return false;
	}


}