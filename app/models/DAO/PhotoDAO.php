<?php

//require_once __DIR__."/../VO/PhotoVO.php";

class PhotoDAO extends CRUD
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getPhotos()
	{
		$rows = $this->select("photos");

		$photos = array();

		foreach ($rows as $row) 
		{
			$photos[$row['id']] = new PhotoVO($row['name'], $row['alt'], $row['description'], $row['id']);
		}

		return $photos;
	}

	/*
	*insert new photo's info into CRUD
	*if succeed, return id
	*input:
	*/
	public function addPhoto($photo)
	{
		$param = array(
			'name' => $photo['name']
			);
		$rows = $this->select('photos', $param);

		if(sizeof($rows) > 0)
		{
			foreach($rows as $row)
			{
				if($row['name'] == $photo['name'])
				{
					$photoID = $row['id'];
				}
			}
			return $photoID;
		}

		$data = array(
			'name'       =>$photo['name'],
			'alt'        =>$photo['alt'],
			'description'=>$photo['description']
			);

		$id = $this->insert('photos', $data);

		return $id;
	}
}