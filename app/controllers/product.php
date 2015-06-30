<?php

class Product extends Controller
{
	private $_productDAO;
	private $_brandDAO;
	private $_gearTypeDAO;
	private $_sportTypeDAO;

	public function __construct()
	{
		parent::__construct();

		$this->_productDAO  = $this->model('ProductDAO');
		$this->_brandDAO    = $this->model('BrandDAO');
		$this->_gearTypeDAO = $this->model('GearTypeDAO');
		$this->_sportTypeDAO= $this->model('SportTypeDAO');
	}

	public function index()
	{
		//need to make changes to paginator function in DAO
		//alternative
		$this->tennis();
	}

	/*for product management, check sign in status*/
	public function isStaff()
	{
		if(!isset($_SESSION['staff']))
		{
 			$data = array(
				'title'     => "SportGear-Staff Sign In",
				'mainView'  => 'signIn',
				'brands'    => $this->_brands,
				'sportTypes'=> $this->_sports,
				'gearTypes' => $this->_gears, 
				'user'      => 'staff',
				'info'      => null
				);

			$this->view('page', $data);
		}
	}

	//get all products by sport type
	public function tennis($gearType = null, $page = 1)
	{
		$data = array();

		$sportTypeID = $this->getIdByName($this->_sports, 'tennis');

		$param['sportTypeID'] = $sportTypeID;
		
		if($gearType != null && $gearType != 'all')
		{
			$gearTypeID = $this->getIdByName($this->_gears, $gearType);
			
			$param['gearTypeID'] = $gearTypeID;
		}
		
		$limit = 6;
		$products = $this->_productDAO->paginator($page, $limit, $param);

		/*******************/
		$total = $this->_productDAO->total('products', $param);
		($gearType==null) ? $param2='all' : $param2=$gearType;
		
		$pagination = $this->generatePagination($total, $page, $limit, 'product','tennis', $param2);
		/*******************/
		//$products = $paginator->products;

		if(sizeof($products) > 0) 
		{
			$data = array(
				'title'     => "SportGear-tennis products",
				'mainView'  => 'products',
				'brands'    => $this->_brands,
				'sportTypes'=> $this->_sports,
				'gearTypes' => $this->_gears,
				'products'  => $products,
				'sport'     => 'tennis',
				'pagination'=> $pagination,
				'message'   => $this->message
			);

			$this->view('page', $data);
		}
		else
		{
			$this->message = 'Sorry, We don\'t have any products now.';
			$this->error($this->message);
		}
	}

	public function badminton($gearType = null, $page = 1)
	{
		$data = array();

		//$brands    = $this->_brandDAO->getBrands();
		//$gearTypes = $this->_gearTypeDAO->getGearTypes();
		//$sportTypes= $this->_sportTypeDAO->getSportTypes();

		$sportTypeID = $this->getIdByName($this->_sports, 'badminton');

		$param['sportTypeID'] = $sportTypeID;
		
		if($gearType != null && $gearType != 'all')
		{
			$gearTypeID = $this->getIdByName($this->_gears, $gearType);

			$param['gearTypeID'] = $gearTypeID;
		}
			//$products = $this->_productDAO->getProductBy($param);
			//how to write different sql???	
		
		$limit = 6;
		$products = $this->_productDAO->paginator($page, $limit, $param);
		/*******************/
		$total = $this->_productDAO->total('products', $param);
		($gearType==null) ? $param2='all' : $param2=$gearType;
		$pagination = $this->generatePagination($total, $page, $limit, 'product','badminton', $param2);
		/*******************/
		//$products = $paginator->products;

		if(sizeof($products) > 0) 
		{
			$data = array(
				'title'     => "SportGear-badminton products",
				'mainView'  => 'products',
				'brands'    => $this->_brands,
				'sportTypes'=> $this->_sports,
				'gearTypes' => $this->_gears,
				'products'  => $products,
				'sport'     => 'badminton',
				'pagination'=> $pagination,
				'message'   => $this->message
			);

			$this->view('page', $data);
		}
		else
		{
			$this->message = 'Sorry, We don\'t have any products now.';
			$this->error($this->message);
		}
	}

	//display a product
	public function product($productID)
	{
		if(!is_numeric($productID))
		{
			$this->tennis();
		}

		$param['id'] = $productID;


		$results = $this->_productDAO->getProductBy($param);
		if(sizeof($results) < 1)
		{
			//do sth here
		}

		$product = $results[$productID];

		$data = array(
				'title'     => $product->getName(),
				'mainView'  => 'product',
				'brands'    => $this->_brands,
				'sportTypes'=> $this->_sports,
				'gearTypes' => $this->_gears,
				'product'   => $product
			);

		$this->view('page', $data);
	}

	public function getIdByName($objects, $name)
	{

		foreach($objects as $object)
		{
			if($object->getName() == $name)
			{
				return $object->getId();
			}
		}

		//do we need to set default id here?
		return $id = 1;	
	}
	/*
	*browse products by brands
	*/
	public function brand($brandName, $page = 1)
	{
		if($brandName == null)
		{
			$this->index(); //load all products
		}

		$data = array();

		$brandID = $this->getIdByName($this->_brands, $brandName);

		$param['brandID'] = $brandID;
		
		$limit = 6;
		$products = $this->_productDAO->paginator($page, $limit, $param);

		/*******************/
		$total = $this->_productDAO->total('products', $param);

		$pagination = $this->generatePagination($total, $page, $limit, 'product','brand', $brandName);
		/*******************/
		//$products = $paginator->products;

		if(sizeof($products) > 0) 
		{
			$data = array(
				'title'     => "SportGear-$brandName products",
				'mainView'  => 'products',
				'brands'    => $this->_brands,
				'sportTypes'=> $this->_sports,
				'gearTypes' => $this->_gears,
				'products'  => $products,
				'sport'     => '',
				'pagination'=> $pagination,
				'message'   => $this->message
			);

			$this->view('page', $data);
		}
		else
		{
			$this->message = 'Sorry, We don\'t have any products now.';
			$this->error($this->message);
		}
	}

	public function category($gearType, $page=1)
	{
		if($gearType == null)
		{
			$this->index(); //load all products
		}

		$data = array();

		$gearTypeID = $this->getIdByName($this->_gears, $gearType);

		$param['gearTypeID'] = $gearTypeID;
		
		$limit = 6;
		$products = $this->_productDAO->paginator($page, $limit, $param);

		/*******************/
		$total = $this->_productDAO->total('products', $param);

		$pagination = $this->generatePagination($total, $page, $limit, 'product','category', $gearType);
		/*******************/
		//$products = $paginator->products;

		if(sizeof($products) > 0) 
		{
			$data = array(
				'title'     => "SportGear-$gearType",
				'mainView'  => 'products',
				'brands'    => $this->_brands,
				'sportTypes'=> $this->_sports,
				'gearTypes' => $this->_gears,
				'products'  => $products,
				'sport'     => '',
				'pagination'=> $pagination,
				'message'   => $this->message
			);

			$this->view('page', $data);
		}
		else
		{
			$this->message = 'Sorry, We don\'t have any products now.';
			$this->error($this->message);
		}
	}

	/*search by keywords*/
	public function search($keyword = null, $page = 1)
	{
		if(isset($_POST['site-search']))
		{
			$keyword = $_POST['site-search'];
		}
		
		if($keyword == null)
		{
			$this->message = 'Sorry, We don\'t have any products now.';
			$this->error($this->message);
		}

		$limit = 6;
		$products = $this->_productDAO->searchProduct($keyword, $page, $limit);
		
		/*******************/
		//in order to use the same pagination function, this part has some changes
		$total = $this->_productDAO->searchProductTotal($keyword);

		$pagination = $this->generatePagination($total, $page, $limit, 'product','search', $keyword);
		/*******************/
		if(sizeof($products) > 0) 
		{
			$data = array(
				'title'     => "SportGear-search products",
				'mainView'  => 'products',
				'brands'    => $this->_brands,
				'sportTypes'=> $this->_sports,
				'gearTypes' => $this->_gears,
				'products'  => $products,
				'sport'     => 'search',
				'pagination'=> $pagination,
				'message'   => $this->message
			);

			$this->view('page', $data);
		}
		else
		{
			$this->message = 'Sorry, We don\'t have any products now.';
			$this->error($this->message);
		}
	}
}