<?php
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
		
		$sql .= " LIMIT ".(($page-1)*$limit).", $limit";
		
		$products = $this->get($sql, $param);

	    return $products;
	}

	/*
	*input: array contains all info about one new product
	*keys are field names
	*/
	public function addProduct($product)
	{
		//$oldProductID = $this->isExist('products', $product['name']);
		$param = array(
			'name' => $product['name']
			);
		$rows = $this->select('products', $param);

		if(sizeof($rows) > 0)
		{
			return 0;
		}

		$newProductID = $this->insert('products', $product);

		return $newProductID;
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