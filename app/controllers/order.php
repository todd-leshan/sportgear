<?php 

class Order extends Controller
{
	private $_productDAO;

	public function __construct()
	{
		parent::__construct();
		$this->_productDAO  = $this->model('ProductDAO');
	}

	public function clear()
	{
		session_destroy();
	}

	public function addToCart()
	{
		if(isset($_POST['productID']) && isset($_POST['qty']))
		{
			$productID = $_POST['productID'];
			$qty       = (int)$_POST['qty'];

			unset($_POST['productID']);
			unset($_POST['qty']);

			if(isset($_SESSION['cart']))
			{
				$isNew = true;
			
				if(isset($_SESSION['cart'][$productID]))
				{
					$_SESSION['cart'][$productID] = (int)$_SESSION['cart'][$productID]+$qty;
					$isNew = false;
				}

				if($isNew)
				{
					$_SESSION['cart'][$productID] = $qty;
				}
			}
			else
			{
				$_SESSION['cart'][$productID] = $qty;
			}
		}

		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}

	public function showCart()
	{
		if(!isset($_SESSION['cart']))
		{
			$data = array(
			'title'     => "SportGear-Shopping Cart Review",
			'mainView'  => 'itemInCart',
			'brands'    => $this->_brands,
			'sportTypes'=> $this->_sports,
			'gearTypes' => $this->_gears,
			'itemsInCart'=> array()
			);  

			$this->view('page', $data);
			exit();
		}

		$productsInCart = array();
		$itemsInCart = $_SESSION['cart'];

		foreach($itemsInCart as $productID=>$qty)
		{
			$data = array(
				'id' => $productID
				);

			$rows = $this->_productDAO->getProductBy($data);

			$itemInCart = array($rows[$productID], $qty);

			array_push($productsInCart, $itemInCart);
		}

		$data = array(
			'title'     => "SportGear-Shopping Cart Review",
			'mainView'  => 'itemInCart',
			'brands'    => $this->_brands,
			'sportTypes'=> $this->_sports,
			'gearTypes' => $this->_gears,
			'itemsInCart'=> $productsInCart
			);  

			$this->view('page', $data);
	}
}

?>