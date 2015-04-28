<?php

class Home extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data = array(
			'title'     => "SportGear-Professional Tennis&amp;Badminton equipments store",
			'mainView'  => 'index',
			'brands'    => $this->_brands,
			'sportTypes'=> $this->_sports,
			'gearTypes' => $this->_gears
			);  

		$this->view('page', $data);
	}
}