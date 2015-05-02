<?php

class GearTypeVO
{
	private $_id;
	private $_name;
	private $_status;

	public function __construct($id, $name, $status)
	{
		$this->_id     = $id;
		$this->_name   = $name;
		$this->_status = $status;
	}

	public function getId()
	{
		return $this->_id;
	}
	
	public function getName()
	{
		return $this->_name;
	}

	public function getStatus()
	{
		return $this->_status;
	}
}