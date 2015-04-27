<?php

class Test extends Controller
{
	public function index()
	{
		//$test = $this->model("TestModel");
		/*
		$results = $test->test();
		foreach($results as $result)
		{
			echo $result['brandName'];
			echo "<br>";
		}
		*/
		//$login = 
		$test = $this->model("BrandDAO");

		
		$brands = $test->getBrands();
		foreach ($brands as $brand) 
		{
			echo "id is ".$brand->getId()." name=".$brand->getName()."<br><hr>";
		}
		//print_r($login);
	}

	public function photo()
	{
		$photo = $this->model("PhotoDAO");

		$isExist = $photo->isExist("xhead-championship-4-ball-can.jpg");

		if($isExist)
		{
			echo "good";
		}
		else
		{
			echo "bad";
		}
	}

	public function sql()
	{
		$sportTypeID = 1;
		$price = 19.99;
		$brand = 'wilson';

		$data = array(
			'sportTypeID='=>$sportTypeID,
			'price>'      =>$price,
			'brand='      =>$brand
			);

		$i = 1;
		$j = sizeof($data);
		$sql = '';
		$param = array();

		foreach ($data as $key => $value) {
			$sql .= ' '.$key.':'.$key;

			$param[":$key"] = $value;

			if($i < $j)
			{
				$sql .= ' AND ';
			}
			$i++;
		}

		print_r($param);
		echo "<hr>";
		die($sql);
	}

	public function test1()
	{
		$sql = "SELECT * FROM products WHERE sportTypeID=:sportTypeID= AND gearTypeID=:gearTypeID=";
	}

	public function total()
	{
		$product = $this->model("ProductDAO");

		$table = 'products';

		$total = $product->total($table);

		var_dump($total);
	}
}