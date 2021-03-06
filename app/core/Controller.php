<?php
//announce access methods like view and model  to load models and render views
class Controller
{
	protected $_brands;
	protected $_gears;
	protected $_sports;

	public function __construct()
	{
		// server should keep session data for AT LEAST 1 hour
		ini_set('session.gc_maxlifetime', 3600);

		// each client should remember their session id for EXACTLY 1 hour
		session_set_cookie_params(3600);
		session_start();
		define("BASE","http://localhost/sportgear/");
		//define("BASE","http://nimingli.com/sportgear/");

		$brandDAO    = $this->model('BrandDAO');
		$gearTypeDAO = $this->model('GearTypeDAO');
		$sportTypeDAO= $this->model('SportTypeDAO');

		$this->_brands = $brandDAO->getBrands();
		$this->_gears  = $gearTypeDAO->getGearTypes();
		$this->_sports = $sportTypeDAO->getSportTypes();

	}

	protected $message = null;
	//define kinds of error message here, then maybe we can use them again
	
	public function model($model)
	{
		require_once __DIR__ . '/../models/DAO/'.$model.'.php';
		return new $model();
	}

	public function view($view, $data = [])
	{
		/*
		foreach ($data as $key => $value) 
		{
			${$key} = $value;
		}
		*/

		extract($data);
		
		require_once __DIR__ . '/../views/'.$view.'.php';
	}

	public function loadView($title, $mainView, $info)
	{
		$this->view($mainView);
	}

	/*
	*load error page, if sth goes wrong
	*we don't actually need this?
	*/
	public function error($message)
	{
		$data = array(
				'title'   => "SportGear-Error",
				'mainView'=> 'error',
				'message' => $message,
				'brands'    => $this->_brands,
				'sportTypes'=> $this->_sports,
				'gearTypes' => $this->_gears,
			);

		$this->view('page', $data);
	}

	public function generatePagination($total, $currentPage, $limit, $controller, $function, $param)
	{
		$pagination = new stdClass();
		$pagination->total       = $total;
		$pagination->currentPage = $currentPage;
		$pagination->limit       = $limit;
		$pagination->controller  = $controller;
		$pagination->function    = $function;
		$pagination->param       = $param;

		return $pagination;
	}
}