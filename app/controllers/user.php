<?php

class User extends Controller
{
	private $_userDAO;

	public function __construct()
	{	
		//$this->_userDAO = $this->model('UserDAO');
	}

	/*load sign in form*/
	public function index()
	{
		if(!isset($_SESSION['user']))
		{
 			$data = array(
				'title'   => "SportGear-User Sign In",
				'mainView'=> 'signIn',
				'user'    => 'user',
				'info'    => null
				);
			$this->view('page', $data);

		}
		else
		{
			//redirect to user profile
		}
	}
}