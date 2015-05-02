<?php

//require_once __DIR__."/../VO/ProductVO.php";

//require_once __DIR__."/../DAO/PhotoDAO.php";
//require_once __DIR__."/../DAO/GearTypeDAO.php";
//require_once __DIR__."/../DAO/SportTypeDAO.php"; 
//require_once __DIR__."/../DAO/BrandDAO.php";

//require_once dirname(__DIR__)."/../core/autoload.php";

class ProductDAO extends CRUD
{
	private $_photoDAO;
	private $_brandDAO;
	private $_gearTypeDAO;
	private $_sportTypeDAO;

	private $_totalRocords;

	public function __construct()
	{
		parent::__construct();
		$this->_brandDAO = new BrandDAO();
		$this->_photoDAO = new PhotoDAO();

		$this->_gearTypeDAO = new GearTypeDAO();
		$this->_sportTypeDAO= new SportTypeDAO();
	}

	public function getProducts()
	{
		$sql = "SELECT * FROM products";

		return $products = $this->get($sql);
	}

	/*pagination*/
	public function paginator($page = 1, $limit = 6, $data)
	{
		$i = 1;
		$j = sizeof($data);
		$sql = "SELECT *
				FROM products";
		$param = array();

		if($j>0)
		{
			$sql .= ' WHERE ';
			foreach ($data as $key => $value) 
			{
				$sql .= $key.'=:'.$key;

				$param[":$key"] = $value;

				if($i < $j)
				{
					$sql .= ' AND ';
				}
				$i++;
			}	
		}
		//$sql = "SELECT * FROM products LIMIT ".(($page-1)*$limit).", $limit";
		$sql .= " LIMIT ".(($page-1)*$limit).", $limit";

		//$products = $this->get($sql, $param); 
		$products = $this->get($sql, $param);
/*
		$pagination         = new stdClass();
	    $pagination->page   = $page;
	    $pagination->limit  = $limit;
	    //$pagination->total  = $this->_totalRocords;
	    $pagination->products   = $products;
	 
	    return $pagination;
*/
	    return $products;
	}

	/*
	*input: array contains all info about one new product
	*keys are field names
	*/
	public function addProduct($product)
	{
		$oldProductID = $this->isExist($product['name']);

		if($oldProductID > 0)
		{
			return 0;
		}

		$newProductID = $this->insert('products', $product);

		return $newProductID;
	}

	/*
	*check existense by checking product name
	*/
	public function isExist($productName)
	{
		$sql = "SELECT *
				FROM products
				WHERE name=:name";

		$param = array(':name'=>$productName);

		$rows = $this->executeSQL($sql, $param);

		$productID = 0;
		if(sizeof($rows) != 0)
		{
			$productID = $rows[0]['id'];
		}

		return $productID;
	}

	//$data is an array
	public function getProductBy($data)
	{
		$i = 1;
		$j = sizeof($data);
		$sql = "SELECT *
				FROM products
				WHERE ";
		$param = array();

		foreach ($data as $key => $value) {
			$sql .= $key.'=:'.$key;

			$param[":$key"] = $value;

			if($i < $j)
			{
				$sql .= ' AND ';
			}
			$i++;
		}	

		return $products = $this->get($sql, $param);

	}

	public function searchProduct($keyword, $page=1, $limit=6)
	{
		$sql = "SELECT *
				FROM products
				WHERE name LIKE :keyword LIMIT ".(($page-1)*$limit).", $limit";

		$param = array();

		$param[':keyword'] = "%$keyword%";

		return $products = $this->get($sql, $param);
	}

	public function searchProductTotal($keyword)
	{
		$sql = "SELECT COUNT(*)
				FROM products
				WHERE name LIKE :keyword";

		$param = array();

		$param[':keyword'] = "%$keyword%";

		$total = $this->executeSQL($sql, $param);

		return (int)$total[0][0];
	}

	public function getProductbyId($productID)
	{
		$sql = "SELECT *
				FROM ";
	}
	/*
	*
	*/
	public function getProductsByBrand($brandName)
	{

	}

	public function getProductsByGearType($sportTypeID, $gearTypeID)
	{

	}

	public function getProductsBySportType($sportTypeID)
	{
		$sql = "SELECT *
				FROM products
				WHERE sportTypeID=:sport";

		$param = array(':sport'=>$sportTypeID);

		return $products = $this->get($sql, $param);
	
	}

	public function get($sql, $param = [])
	{
		$photos     = $this->_photoDAO->getPhotos();
		$brands     = $this->_brandDAO->getBrands();
		$gearTypes  = $this->_gearTypeDAO->getGearTypes();
		$sportTypes = $this->_sportTypeDAO->getSportTypes();

		$rows = $this->executeSQL($sql, $param);

		$products = array();

		foreach($rows as $row)
		{
			$products[$row['id']] = new ProductVO($row['name'], $row['price'], $row['description'], $brands[$row['brandID']], $photos[$row['photoID']], $gearTypes[$row['gearTypeID']], $sportTypes[$row['sportTypeID']], $row['status'], $row['id']);
		}

		return $products;
	}

}