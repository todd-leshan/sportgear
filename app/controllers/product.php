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
		$this->_gearTypeDAO = $this->model('gearTypeDAO');
		$this->_sportTypeDAO= $this->model('sportTypeDAO');
	}

	//load all products...maybe should do sth else with index()
	/*
	public function index()
	{
		$productModel = $this->model("ProductModel");

		$products = $productModel->getAll('products');
		$photos   = $productModel->getAll2('photos','photoID', array('name', 'alt'));
		$brands   = $productModel->getAll2('brands', 'brandID', array('brandName'));
		$category1= $productModel->getAll2('category1', 'cate1ID', array('cate1'));
		$category2= $productModel->getAll2('category2', 'cate2ID', array('cate2'));

		if(sizeof($products) > 0) 
		{
			$data = array(
				'title'    => "SportGear-All products",
				'mainView' => 'products',
				'products' => $products,
				'photos'   => $photos,
				'brands'   => $brands,
				'category1'=> $category1,
				'category2'=> $category2,
				'message'  => $this->message
			);

			$this->view('page', $data);
		}
		else
		{
			$this->message = 'Sorry, We don\'t have any products now.';
			$this->error($this->message);
		}
	}
	*/

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

	//load products by category1

	//load products by category2

	//load products by searching

	//how to load products by combining limit

	//get all products by sport type
	public function tennis($gearType = null, $page = 1)
	{
		//die('1='.$gearType.'||2='.$page);
		//var_dump($page);
		//echo "<hr>";
		$data = array();

		//$brands    = $this->_brandDAO->getBrands();
		$gearTypes = $this->_gearTypeDAO->getGearTypes();
		$sportTypes= $this->_sportTypeDAO->getSportTypes();

		//$sportTypeID = $this->getIdByName($sportTypes, 'tennis');
		$sportTypeID = $this->getIdByName($this->_sports, 'tennis');

		$param['sportTypeID'] = $sportTypeID;
		
		if($gearType != null && $gearType != 'all')
		{
			//$gearTypeID = $this->getIdByName($gearTypes, $gearType);
			$gearTypeID = $this->getIdByName($this->_gears, $gearType);
			
			$param['gearTypeID'] = $gearTypeID;
		}
			//$products = $this->_productDAO->getProductBy($param);
			//how to write different sql???	
		
		$limit = 6;
		$products = $this->_productDAO->paginator($page, $limit, $param);

		/*******************/
		$total = $this->_productDAO->total('products', $param);

		$pagination = new stdClass();
		$pagination->total = $total;
		$pagination->currentPage = $page;
		$pagination->limit = $limit;
		$pagination->sport = 'tennis';
		($gearType==null) ? $pagination->gear='all' : $pagination->gear=$gearType;

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

		$brands    = $this->_brandDAO->getBrands();
		$gearTypes = $this->_gearTypeDAO->getGearTypes();
		$sportTypes= $this->_sportTypeDAO->getSportTypes();

		$sportTypeID = $this->getIdByName($sportTypes, 'badminton');

		$param['sportTypeID'] = $sportTypeID;
		
		if($gearType != null && $gearType != 'all')
		{
			$gearTypeID = $this->getIdByName($gearTypes, $gearType);

			$param['gearTypeID'] = $gearTypeID;
		}
			//$products = $this->_productDAO->getProductBy($param);
			//how to write different sql???	
		
		$limit = 6;
		$products = $this->_productDAO->paginator($page, $limit, $param);
		/*******************/
		$total = $this->_productDAO->total('products', $param);
		$pagination = new stdClass();
		$pagination->total = $total;
		$pagination->currentPage = $page;
		$pagination->limit = $limit;
		$pagination->sport = 'badminton';
		($gearType==null) ? $pagination->gear='all' : $pagination->gear=$gearType;
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
		$param['id'] = $productID;

		$results = $this->_productDAO->getProductBy($param);
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
	public function brand($brandName)
	{

	}

	/*search by keywords*/
	public function search($keyword, $page = 1)
	{
		if(isset($_POST["site-search"]))
		{
			$keyword = $_POST["site-search"];
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
		$pagination = new stdClass();
		$pagination->total = $total;
		$pagination->currentPage = $page;
		$pagination->limit = $limit;
		$pagination->sport = 'search';
		$pagination->gear  = $keyword;
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