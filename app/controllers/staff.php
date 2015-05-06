<?php

class Staff extends Controller
{
	private $_staffDAO;

	private $_productDAO;
	private $_brandDAO;
	private $_gearTypeDAO;
	private $_sportTypeDAO;

	public function __construct()
	{

		parent::__construct();

		$this->_staffDAO    = $this->model('StaffDAO');

		$this->_productDAO  = $this->model('ProductDAO');
		$this->_brandDAO    = $this->model('BrandDAO');
		$this->_gearTypeDAO = $this->model('gearTypeDAO');
		$this->_sportTypeDAO= $this->model('sportTypeDAO');
		
	}

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

	//load staff sign in view
	public function index()
	{
		//if not log in, load log in page
		//$this->isStaff();

		//if loged in
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
		else
		{
			$staff = $_SESSION['staff'];

			$staffID  = $staff['staffID'];
			$username = $staff['username'];

			$this->profile($staffID, $username);	
		}
		
	}

	/*
	*staff sign in process
	*if fail, return to the sign in view with error message
	*if succeed, redirect to the profile page
	*/
	public function signIn()
	{
		if(isset($_POST['username']) && isset($_POST['password']))
		{
			//$staff = $this->model('StaffDAO');
			$username = $_POST['username'];
			$password = $_POST['password'];

			//log in check, return staff object
			$staff  = $this->_staffDAO->signInCheck($username, $password);
			
			if($staff->getId() != 0)
			{
				//to staff  profile
				//set session here
				$id       = $staff->getId();
				$username = $staff->getUsername();

				//echo "id is ".$id."<br>";
				//echo "name is ".$username."<br>";
				//die();

				$_SESSION['staff'] = array(
										'staffID' => $id,
										'username'=> $username
										);
				$this->profile($id, $username);
			}
			else
			{
				//return to sign in view
				$this->signInFail('staff');
			}
		}
		else
		{
			$this->signInFail('staff');
		}
	}

	/*
	*if sign in failed, call this function to redirect page
	*@param = user type
	*/
	public function signInFail($user)
	{
		$data = array(
			'title'     => "SportGear-Sign In",
			'mainView'  => 'signIn',
			'brands'    => $this->_brands,
			'sportTypes'=> $this->_sports,
			'gearTypes' => $this->_gears,
			'user'      => 'staff',
			'info'      => 'Please enter valid username and password to sign in!'
			);

		$this->view('page', $data);
	}

	/*
	*sign out, destroy all session
	*/
	public function signOut()
	{
		$_SESSION['staff'] = null;
		$this->index();
	}

	/*
	*currently, there is only one link on this page
	*when clicking,redirect to product management page
	*
	*/
	public function profile($staffID = 0, $username = null)
	{
		if($staffID == 0 || $username == null)
		{
			$this->index();
		}
		$data = array(
			'title'     => "SportGear-user info",
			'mainView'  => 'staff',
			'brands'    => $this->_brands,
			'sportTypes'=> $this->_sports,
			'gearTypes' => $this->_gears,
			'user'      => 'staff',
			'username'  => $username
			);

		$this->view('page', $data);
	}

	/**********************************************************/
	//product management
	/*
	*add new products
	*/
	public function addProducts()
	{
		$this->isStaff();
		//check all data passed here
		//if data detected, load model
		//$brands    = $this->_brandDAO->getBrands();
		//$gearTypes = $this->_gearTypeDAO->getGearTypes();
		//$sportTypes= $this->_sportTypeDAO->getSportTypes();

		//photo upload
		if( 
			isset($_POST['newproduct_name']) &&
			isset($_POST['newproduct_price']) &&
			isset($_POST['newproduct_description']) &&
			isset($_POST['newproduct_brand']) &&
			isset($_POST['newproduct_cate1']) &&
			isset($_POST['newproduct_cate2']) &&
			isset($_FILES['newproduct_photo']) &&
			isset($_POST['photo_alt']) &&
			isset($_POST['photo_description'])
			)
		{
			//$isProductExist = $this->_productDAO->isExist($_POST['newproduct_name']);
			/*
			if($isProductExist > 0)
			{
				$this->message = 'Add new products failed!<br>You can not have the same product name!';	
				$this->error($this->message);
			}
			*/
			$gearTypeID = $_POST['newproduct_cate1'];
			$gearType   = $gearTypes[$gearTypeID]->getName();
			$file       = $_FILES['newproduct_photo'];
			//upload image first to get imageID
			$photo = array(
					'name'        => $_FILES['newproduct_photo']['name'],
					'alt'         => $_POST['photo_alt'],
					'description' => $_POST['photo_description']
				);
			
			$photoID = $this->uploadImage($file, $photo, $gearType);			

			//then insert new product
			$product = array(
					'name'        => $_POST['newproduct_name'],
					'price'       => $_POST['newproduct_price'],
					'description' => $_POST['newproduct_description'],
					'brandID'     => $_POST['newproduct_brand'],
					'gearTypeID'  => $gearTypeID,
					'sportTypeID' => $_POST['newproduct_cate2'],
					'photoID'     => $photoID
					);
			$newProductID = $this->_productDAO->addProduct($product);
			//die("error: ".$newProductID);
			if($newProductID == 0)
			{
				$this->message = 'Add new products failed!<br>You can not have the same product name!';
			}
			else
			{
				$this->message = "You've added a new product!";
			}
			//**************************************

		// $_FILES['newproduct_photo'] is an array ;
		}

		//if not, go back to the view; or when error found, go back the view with error
		//if(1!=1){}
		//always load the add form
		//if($brands && $gearTypes && $sportTypes)
		//{
			$data = array(
				'title'   => "SportGear-Add new products",
				'mainView'=> 'addNewProduct',
				'brands'    => $this->_brands,
				'sportTypes'=> $this->_sports,
				'gearTypes' => $this->_gears,
				'message'  =>$this->message
			);

			$this->view('page', $data);
			/*
		}
		else
		{
			$this->message = 'Sorry, We are trying to fix this. Please try again!!!';
			$this->error($this->message);
		}
		*/
	}

	/*
	*input: array contains all info of a photo
	*categoryID
	*output:photoID
	*/
	public function uploadImage($file, $photo, $gearType)
	{
			$target_dir = "../public/images/product/$gearType/";
			$target_file= $target_dir.basename($file['name']);

			$uploadOK = 1;
			//better $fileType = $file['type']; => 'image/jpeg'
			$fileType = pathinfo($target_file, PATHINFO_EXTENSION);
			//add sth to make sure an image is uploaded
			$isImage = getimagesize($file['tmp_name']);
			if($isImage === false)
			{
				$this->message .= "Sorry, please upload a real image!<br>";
				$uploadOK = 0;
			}

			if(file_exists($target_file))
			{
				$this->message .= "Sorry, Image exists!<br>";
				//$uploadOK = 0;
			}

			if($file['size'] > 2000000)//2mb
			{
				$this->message .= "Sorry, Your file is too big!<br>";
				$uploadOK = 0;
			}

			$allowedType = array('jpg','gif','jpeg','png');
			if(!in_array($fileType, $allowedType))
			{
				$this->message .= "Sorry, only ".implode(', ', $allowedType)." files are allowed!<br>";
				$uploadOK = 0;
			}
			  
			if($uploadOK == 0)
			{
				$this->error($this->message);
			}

			$this->message = '';

			//move file to the target directory
			if(!move_uploaded_file($file['tmp_name'], $target_file))
			{
				$this->message = "Photo upload failed!";
				$this->error($this->message);
				//do we need to do sth to stop 
			}
			else
			{
				$photoDAO = $this->model('PhotoDAO');
				$photoID  = $photoDAO->addPhoto($photo);
				if($photoID == false)
				{
					$this->message = "Can not insert photo infomation into Database!!!";
					$this->error($this->message);
				}
				return $photoID;
			}
	}

	public function manageProducts($selector = null, $page = 1, $limit = 6)
	{
		$this->isStaff();

		if(isset($_POST['productID']))
		{
			$productID = $_POST['productID'];
		}

		if(isset($_POST['change-update']))
		{
			unset($_POST['change-update']);

			$formValid = true;

			if(!isset($_POST['change-name']) || strlen($_POST['change-name']) < 10)
			{
				$this->message .= "Product name must be filled with at least 10 characters!<br>";
				$formValid = false; 
			}

			if(!isset($_POST['change-price']))
			{
				$this->message .= "Price must be filled!<br>";
				$formValid = false; 
			}

			if(!$formValid)
			{
				$this->error($this->message);
			}
			else
			{
				$_POST['change-status']==1 ? $status=true: $status=false;

				$columns = array(
					'name'        => $_POST['change-name'],
					'price'       => $_POST['change-price'],
					'description' => $_POST['change-description'],
					'brandID'     => $_POST['change-brand'],
					'gearTypeID'  => $_POST['change-gearType'],
					'sportTypeID' => $_POST['change-sport'],
					'status'      => $status
					);

				$limits  = array(
					'id' => $productID 
					);

				$rowAffected = $this->_staffDAO->update('products', $columns, $limits);

				if($rowAffected != 1)
				{
					$this->message = 'Sorry, system error, please try again!';
					$this->error($this->message);
				}
				else
				{
					$this->manageProducts();
				}
			}

		}

		if(isset($_POST['change-delete']))
		{
			unset($_POST['change-delete']);
		}

		/************/
		$param = array();
		$products = $this->_productDAO->paginator($page, $limit, $param);

		/*******************/
		$total = $this->_productDAO->total('products', $param);

		$param1 = 'all';

		$pagination = $this->generatePagination($total, $page, $limit, 'staff','manageProducts', $param1);
		/*******************/

		if(sizeof($products) > 0) 
		{
			$data = array(
				'title'     => "SportGear-manage products",
				'mainView'  => 'manageProducts',
				'brands'    => $this->_brands,
				'sportTypes'=> $this->_sports,
				'gearTypes' => $this->_gears,
				'products'  => $products,
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

	public function passwordValidation($password)
	{
		$pattern = '/^[a-zA-Z0-9_-]*$/';

		$info = '';

		if(strlen($password) < 8)
		{
			$info .= "Password must be at least 8 characters!<br>";
		}

		if(!preg_match($pattern, $password))
		{
			$info .= "Password can only contain \"a-zA-Z0-9_-\"!<br>";
		}

		return $info;
	}

	public function changePassword()
	{
		$this->isStaff();

		$info = '';
		if(!isset($_SESSION['staff']))
		{
			$this->index();
		}

		if(!isset($_POST['change-password1']) || !isset($_POST['change-password2']) || !isset($_POST['change-password3']))
		{
			$info = "All fields must be filled!";
			$this->validateFail($info);
		}
		else
		{
			$password1 = $_POST['change-password1'];
			$password2 = $_POST['change-password2'];
			$password3 = $_POST['change-password3'];
		}

		$info .= $this->passwordValidation($password1);
		$info .= $this->passwordValidation($password2);
		$info .= $this->passwordValidation($password3);

		if($info)
		{
			$this->validateFail($info);
		}

		$username = $_SESSION['staff']['username'];
		$staff  = $this->_staffDAO->signInCheck($username, $password1);
		
		if($staff->getId() == 0)
		{
			$info = "You have to enter the right password before change!";
			$this->validateFail($info);
		}

		if($password1 == $password2)
		{
			$info = "You entered the same password as before!";
			$this->validateFail($info);
		}

		if($password2 !== $password3)
		{
			$info = "Passwords have to be the same to change!";
			$this->validateFail($info);
		}

		$param1['password'] = sha1(md5($password2));
		$param2['username'] = $username;

		$rowAffected = $this->_staffDAO->update('staffs', $param1, $param2);

		if($rowAffected != 1)
		{
			$info = "System Error, please try again!";
			$this->validateFail($info);
		}
		else
		{
			$info  = "Password changed! You need to log in again!<br>";
			$info .= "You will be redirected to log in in 5 seconds!";
			$this->validateFail($info, true);
		}
	}

	public function validateFail($info, $redirect = false)
	{
		$data = array(
			'title'     => "SportGear-Staff: change password",
			'mainView'  => 'changePassword',
			'brands'    => $this->_brands,
			'sportTypes'=> $this->_sports,
			'gearTypes' => $this->_gears,
			'user'      => 'staff',
			'redirect'  => $redirect,
			'info'      => $info
		);

		$this->view('page', $data);
	}

	public function manageCategories()
	{
		$info = '';

		$data = array(
			'title'     => "SportGear-Staff: manage Categories",
			'mainView'  => 'manageCategories',
			'brands'    => $this->_brands,
			'sportTypes'=> $this->_sports,
			'gearTypes' => $this->_gears,
			'user'      => 'staff',
			'info'      => $info
		);

		$this->view('page', $data);
	}

}