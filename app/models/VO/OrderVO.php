<?php 

class OrderVO
{
	private $_id;
	private $_firstname;
	private $_lastname;
	private $_address;
	private $_phone;
	private $_email;
	private $_creditcard;
	private $_expiry;
	private $_name; // name on credit card
	private $_CSV;

	public function __construct($firstname, $lastname, $address, $phone, $email, $creditcard, $expire, $name, $CSV, $id = 0)
	{
		$this->_firstname = $firstname;
		$this->_lastname  = $lastname;
		$this->_address   = $address;
		$this->_phone     = $phone;
		$this->_email     = $email;
		$this->_creditcard= $creditcard;
		$this->_expiry    = $expire;
		$this->_name      = $name;
		$this->_CSV       = $CSV;
		$this->_id        = $id;
	}

	public function getId()
	{
		return $this->_id;
	}

	public function getFirstname()
	{
		return $this->_firstname;
	}

	public function getLastname()
	{
		return $this->_lastname;
	}

	public function getAddress()
	{
		return $this->_address;
	}

	public function getPhone()
	{
		return $this->_phone;
	}

	public function getEmail()
	{
		return $this->_email;
	}

	public function getCreditcard()
	{
		return $this->_creditcard;
	}

	public function getExpire()
	{
		return $this->_expire;
	}

	public function getName()
	{
		return $this->_name;
	}

	public function getCSV()
	{
		return $this->_CSV;
	}

}

?>