<?php 

class OrderedProductVO
{
	private $_productID;
	private $_orderID;
	private $_qty;

	public function __construct($productID, $orderID, $qty)
	{
		$this->_productID = $productID;
		$this->_orderID   = $orderID;
		$this->_qty       = $qty;
	}

	public function getProductID()
	{
		return $this->_productID;
	}

	public function getOrderID()
	{
		return $this->_orderID;
	}

	public function getQty()
	{
		return $this->_qty;
	}
}

?>