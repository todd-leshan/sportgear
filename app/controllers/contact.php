<?php

class Contact extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data = array(
			'title'     => "SportGear-Contact us",
			'mainView'  => 'contact',
			'brands'    => $this->_brands,
			'sportTypes'=> $this->_sports,
			'gearTypes' => $this->_gears
			);

		$this->view('page', $data);
	}

	public function sendMail()
	{
		$data = array(
			'title'     => "SportGear-send mail",
			'mainView'  => 'sendMail',
			'brands'    => $this->_brands,
			'sportTypes'=> $this->_sports,
			'gearTypes' => $this->_gears
			);

		$this->view('page', $data);
	}
}