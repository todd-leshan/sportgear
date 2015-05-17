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

	public function updateCart()
	{
		if(isset($_POST['updateItem']))
		{
			unset($_POST['updateItem']);

			if(!isset($_POST['productID']))
			{
				$info = 'No product select, please try again!<br>';
				$this->showCart($info);
				exit;
			}

			if(!isset($_POST['updateItem-qty']) || (int)$_POST['updateItem-qty'] <= 0)
			{
				$info = "Please enter a valid quantity to continue!<br>";
				$this->showCart($info);
				exit;
			}

			$productID = $_POST['productID'];
			$qty       = $_POST['updateItem-qty'];

			$_SESSION['cart'][$productID] = $qty;
			header('Location: ' . $_SERVER['HTTP_REFERER']);
		}

		if(isset($_POST['deleteItem']))
		{
			unset($_POST['deleteItem']);

			if(!isset($_POST['productID']))
			{
				$info = 'No product select, please try again!<br>';
				$this->showCart($info);
				exit;
			}

			$productID = $_POST['productID'];

			unset($_SESSION['cart'][$productID]);
			header('Location: ' . $_SERVER['HTTP_REFERER']);
		}
	}

	public function showCart($info = null)
	{
		if(!isset($_SESSION['cart']))
		{
			$data = array(
			'title'     => "SportGear-Shopping Cart Review",
			'mainView'  => 'itemInCart',
			'brands'    => $this->_brands,
			'sportTypes'=> $this->_sports,
			'gearTypes' => $this->_gears,
			'info'      => $info,
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
			'info'      => $info,
			'itemsInCart'=> $productsInCart
			);  

		$this->view('page', $data);
	}

	public function checkout()
	{
		$info = null;

		if(isset($_POST['checkoutButton']))
		{
			$requiredFields = array("checkout_firstname", "checkout_lastname", "checkout_address", "checkout_phone", "checkout_email", "checkout_ccNo", "checkout_name", "checkout_csv", "checkout_expire");

			foreach($requiredFields as $requiredField)
			{
				if(!isset($_POST[$requiredField]))
				{
					$info = "Please fill all compulsory fields!";
					$this->loadCheckoutView($info);
					exit;
				}

				${$requiredField} = $_POST[$requiredField];
			}

			$isValid = true;

			if(!$this->patternMatch($checkout_phone, "/^04[0-9]{2}[ -]?[0-9]{3}[ -]?[0-9]{3}$/") && 
				!$this->patternMatch($checkout_phone, "/^[3-9]{1}[0-9]{3}[ -]?[0-9]{4}$/") && 
				!$this->patternMatch($checkout_phone, "/^0[2,3,7,8]{1}[ -]?[3-9]{1}[0-9]{3}[ -]?[0-9]{4}$/")
				)
			{
				$info .= "Please enter a valid Australia phone number!<br>";
				$isValid = false;
			}

			if(!$this->patternMatch($checkout_email, "/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/"))
			{
				$info .= "Please enter a valid email address.!<br>";
				$isValid = false;
			}
/*
			if($this->patternMatch($checkout_ccNo, "/^[0-9]{16}$/"))
			{
				$info .= "Please enter a valid credit card number!<br>";
				$isValid = false;
			}

			if($this->patternMatch($checkout_csv, "/^[0-9]{3}$/"))
			{
				$info .= "Please enter a valid credit card CSV!<br>";
				$isValid = false;
			}
*/
			$currentDate = date("Y-m");
			if($checkout_expire < $currentDate)
			{
				$info .= "Your credit card expired!<br>";
				$isValid = false;
			}

			if(!$isValid)
			{
				$this->loadCheckoutView($info);
				exit();
			}

			$orderDAO = $this->model("OrderDAO");
			$orderID  = $this->randomString(10);

			$order = array(
				'id'        => $orderID,
				'firstname' => $checkout_firstname,
				'lastname'  => $checkout_lastname,
				'address'   => $checkout_address,
				'phone'     => $checkout_phone,
				'email'     => $checkout_email,
				'creditcard'=> $checkout_ccNo,
				'expiry'    => $checkout_expire,
				'name'      => $checkout_name,
				'CSV'       => $checkout_csv
				);

			//check whether this orderID exists,,skip this now

			$newOrderID = $orderDAO->insert('sportgear.order', $order);
/*
			if($newOrderID != $orderID)
			{
				$info = "System Error, please try again later!";
				$this->loadCheckoutView($info);
				exit;
			}
*/
			$itemsInCart = $_SESSION['cart'];
			$itemDAO = $this->model("OrderedProductDAO");

			foreach($itemsInCart as $productID=>$qty)
			{
				$data = array(
					'productID' => $productID,
					'orderID'   => $orderID,
					'quantity'  => $qty
				);

				$itemDAO->insert('orderedproduct', $data);
			}

			unset($_SESSION['cart']);
			$this->thankyou($checkout_firstname, $checkout_lastname, $orderID);
						
		}

		$this->loadCheckoutView($info);
	}

	public function patternMatch($field, $pattern)
	{
		preg_match($pattern, $field) ? $isValid=true : $isValid=false;
		return $isValid;
	}

	public function loadCheckoutView($info = null)
	{
		$data = array(
			'title'     => "SportGear-Shopping Cart Review",
			'mainView'  => 'checkout',
			'brands'    => $this->_brands,
			'sportTypes'=> $this->_sports,
			'gearTypes' => $this->_gears,
			'info'      => $info
			);  

		$this->view('page', $data);
	}

	public function thankyou($firstname, $lastname, $orderID)
	{
		$data = array(
			'title'     => "SportGear-Shopping Cart Review",
			'mainView'  => 'thankyou',
			'brands'    => $this->_brands,
			'sportTypes'=> $this->_sports,
			'gearTypes' => $this->_gears,
			'customer'  => $firstname.' '.$lastname,
			'orderNo'   => $orderID
			);  

		$this->view('page', $data);
	}

	public function randomString($length)
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    	$charactersLength = strlen($characters);
    	$randomString = '';
    	for ($i = 0; $i < $length; $i++) 
    	{
        	$randomString .= $characters[rand(0, $charactersLength - 1)];
    	}
    	return $randomString;
	}
}

?>