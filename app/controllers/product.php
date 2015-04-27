<?php

class Product extends Controller
{
	private $_productDAO;
	private $_brandDAO;
	private $_gearTypeDAO;
	private $_sportTypeDAO;

	public function __construct()
	{
		$this->_productDAO  = $this->model('ProductDAO');
		$this->_brandDAO    = $this->model('BrandDAO');
		$this->_gearTypeDAO = $this->model('gearTypeDAO');
		$this->_sportTypeDAO= $this->model('sportTypeDAO');
	}

	//load all products...maybe should do sth else with index()
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

	/*for product management, check sign in status*/
	public function isStaff()
	{
		if(!isset($_SESSION['staff']))
		{
 			$data = array(
				'title'   => "SportGear-Staff Sign In",
				'mainView'=> 'signIn',
				'user'    => 'staff',
				'info'    => null
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
		//die($gearType);
		//var_dump($page);
		//echo "<hr>";
		$data = array();

		$brands    = $this->_brandDAO->getBrands();
		$gearTypes = $this->_gearTypeDAO->getGearTypes();
		$sportTypes= $this->_sportTypeDAO->getSportTypes();

		$sportTypeID = $this->getIdByName($sportTypes, 'tennis');

		$param['sportTypeID'] = $sportTypeID;
		
		if($gearType != null && $gearType != 'all')
		{
			$gearTypeID = $this->getIdByName($gearTypes, $gearType);

			$param['gearTypeID'] = $gearTypeID;
		}
			//$products = $this->_productDAO->getProductBy($param);
			//how to write different sql???	
		

		$paginator = $this->_productDAO->paginator($page);
		/*******************/
		$limit = 6;

		$total = $this->_productDAO->total('products');
		$pagination = new stdClass();
		$pagination->total = $total;
		$pagination->currentPage = $page;
		$pagination->limit = $limit;
		$pagination->sport = 'tennis';
		($gearType==null) ? $pagination->gear='all' : $pagination->gear=$gearType;

		/*******************/
		$products = $paginator->products;

		if(sizeof($products) > 0) 
		{
			$data = array(
				'title'     => "SportGear-tennis products",
				'mainView'  => 'products',
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

	public function badminton($gearType = null)
	{
		
	}

	//display a product
	public function product($productID)
	{
		$param['id'] = $productID;

		$results = $this->_productDAO->getProductBy($param);
		$product = $results[$productID];

		$data = array(
				'title'    => $product->getName(),
				'mainView' => 'product',
				'product'  => $product
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

	/*search by keywords*/
	public function search()
	{
		if(isset($_POST["site-search"]))
		{
			$keyword = $_POST["site-search"];
			$products = $this->_productDAO->searchProduct($keyword);
			//print_r($products);
			//die();
			if(sizeof($products) > 0) 
			{
				$data = array(
					'title'    => "SportGear-manage products",
					'mainView' => 'products',
					'products' => $products,
					'sport'    => 'tennis',
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
	}
}