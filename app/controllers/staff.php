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
		$this->_gearTypeDAO = $this->model('GearTypeDAO');
		$this->_sportTypeDAO= $this->model('SportTypeDAO');
		
	}

	public function isStaff()
	{
		if(!isset($_SESSION['staff']))
		{
 			$this->loadSignInView();
		}
		else
		{
			$staffID  = $_SESSION['staff']['staffID'];
			$username = $_SESSION['staff']['username'];

			$param = array(
				'id'      => $staffID,
				'username'=> $username
				);

			$isStaff = $this->_staffDAO->select('staffs', $param);

			if(sizeof($isStaff) != 1)
			{
				$this->loadSignInView();
			}
		}
	}

	public function loadSignInView($info = null)
	{
		$data = array(
			'title'     => "SportGear-Staff Sign In",
			'mainView'  => 'signIn',
			'brands'    => $this->_brands,
			'sportTypes'=> $this->_sports,
			'gearTypes' => $this->_gears,
			'user'      => 'staff',
			'info'      => $info
			);
		$this->view('page', $data);
		exit();
	}

	//load staff sign in view
	public function index()
	{
		//if not log in, load log in page
		$this->isStaff();

		$staff = $_SESSION['staff'];

		$staffID  = $staff['staffID'];
		$username = $staff['username'];

		$this->profile($staffID, $username);		
	}

	/*
	*staff sign in process
	*if fail, return to the sign in view with error message
	*if succeed, redirect to the profile page
	*/
	public function signIn()
	{
		$info = '';
		if(isset($_POST['username']) && isset($_POST['password']))
		{
			//$staff = $this->model('StaffDAO');
			$username = $_POST['username'];
			$password = $_POST['password'];

			$formValid = true;
			if(strlen($username) < 4)
			{
				$info .= "Username must be at least 4 characters!<br>";
				$formValid = false;
			}

			if(strlen($password) < 8)
			{
				$info .= "Password must be at least 8 characters!<br>";
				$formValid = false;
			}

			if(!$formValid)
			{
				$this->loadSignInView($info);
			}

			$password = $password = sha1(md5($password));

			$param = array(
				'username'=>$username,
				'password'=>$password
				);

			$isStaff = $this->_staffDAO->select('staffs', $param);

			if(sizeof($isStaff) != 1)
			{
				$info = 'Please check your username or password and try again!';
				$this->loadSignInView($info);
			}
			else
			{
				$staffID  = $isStaff[0]['id'];
				$username = $isStaff[0]['username'];

				$_SESSION['staff'] = array(
					'staffID' => $staffID,
					'username'=> $username
					);
				$this->profile($staffID, $username);
			}
		}
		else
		{
			$info = 'Please check your username or password and try again!';
			$this->loadSignInView($info);
		}
	}


	/*
	*sign out, destroy all session
	*/
	public function signOut()
	{
		$_SESSION['staff'] = null;
		$this->loadSignInView();

		//$this->index();
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
			'title'     => "SportGear-Staff Manegement System",
			'mainView'  => 'staff',
			'brands'    => $this->_brands,
			'sportTypes'=> $this->_sports,
			'gearTypes' => $this->_gears,
			'user'      => 'staff',
			'username'  => $username
			);

		$this->view('page', $data);
	}

	public function loadAddProductView($info = null)
	{
		$data = array(
			'title'     => "SportGear-Add new products",
			'mainView'  => 'addNewProduct',
			'brands'    => $this->_brands,
			'sportTypes'=> $this->_sports,
			'gearTypes' => $this->_gears,
			'user'      => 'staff', 
			'info'      => $info
		);

			$this->view('page', $data);
			exit();
	}

	/*
	*add new products
	*/
	public function addProducts()
	{
		$this->isStaff();

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
			$formValid = true;
			$param = array(
				'name' => $_POST['newproduct_name']
				);
			$isProductExist = $this->_productDAO->select('products', $param);
			if(sizeof($isProductExist) != 0)
			{
				$info .= "Please change product name!<br>";
				$formValid = false;
			}

			if(!is_numeric($_POST['newproduct_price']))
			{
				$info .= "Please enter a valid price!<br>";
				$formValid = false;
			}

			if(!$formValid)
			{
				$this->loadAddProductView($info);
			}

			$gearTypeID = $_POST['newproduct_cate1'];
			$gearType   = $this->_gears[$gearTypeID]->getName();
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
			$newProductID = $this->_productDAO->insert('products', $product);
			//die("error: ".$newProductID);
			$info = null;
			if($newProductID == 0)
			{
				$info = 'Add new products failed!<br>You can not have the same product name!';
			}
			else
			{
				$info = "You've added a new product!";
			}
			
			$this->loadAddProductView($info);
		}

		$info = "Please fill this form to add new products!";
		$this->loadAddProductView($info);
	}

	/*
	*input: array contains all info of a photo
	*categoryID
	*output:photoID
	*/
	public function uploadImage($file, $photo, $gearType)
	{
		$info = null;
		$target_dir = "../public/images/product/$gearType/";
		$target_file= $target_dir.basename($file['name']);

		$uploadOK = 1;
		//better $fileType = $file['type']; => 'image/jpeg'
		$fileType = pathinfo($target_file, PATHINFO_EXTENSION);
		//add sth to make sure an image is uploaded
		$isImage = getimagesize($file['tmp_name']);
		if($isImage === false)
		{
			$info .= "Sorry, please upload a real image!<br>";
			$uploadOK = 0;
		}

		if($file['size'] > 2000000)//2mb
		{
			$info .= "Sorry, Your file is too big!<br>";
			$uploadOK = 0;
		}

		$allowedType = array('jpg','gif','jpeg','png');
		if(!in_array($fileType, $allowedType))
		{
			$info .= "Sorry, only ".implode(', ', $allowedType)." files are allowed!<br>";
			$uploadOK = 0;
		}
		  
		if($uploadOK == 0)
		{
			$this->loadAddProductView($info);
		}

		$info = '';

		//move file to the target directory
		if(!move_uploaded_file($file['tmp_name'], $target_file))
		{
			$info = "Photo upload failed!";
			$this->loadAddProductView($info);
		}
		else
		{
			$photoDAO = $this->model('PhotoDAO');
			$photoID  = $photoDAO->addPhoto($photo);
			if($photoID == false)
			{
				$info = "Can not insert photo infomation into Database!!!";
				$this->loadAddProductView($info);
			}
			return $photoID;
		}
	}

	public function manageProducts($selector = null, $page = 1, $limit = 6)
	{
		$this->isStaff();

		$info = null;

		if(isset($_POST['change-update']))
		{
			if(isset($_POST['productID']))
			{
				$productID = $_POST['productID'];
			}
			else
			{
				$info = "System Error, please try again!";
				$this->loadManageProductsView($page, $limit, $info);
			}

			unset($_POST['change-update']);

			$formValid = true;

			if(!isset($_POST['change-name']) || strlen($_POST['change-name']) < 10)
			{
				$info .= "Product name must be filled with at least 10 characters!<br>";
				$formValid = false; 
			}

			if(!isset($_POST['change-price']))
			{
				$info .= "Price must be filled!<br>";
				$formValid = false; 
			}

			if(!$formValid)
			{
				$this->loadManageProductsView($page, $limit, $info);
			}
			else
			{
				$param = array(
					'name' => $_POST['change-name']
					);
				$isExist = $this->_productDAO->select('product', $param);

				if(sizeof($isExist) != 0)
				{
					$info = 'Sorry,please change your product name!';
					$this->loadManageProductsView($page, $limit, $info);
				}

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
					$info = 'Sorry, system error, please try again!';
					$this->loadManageProductsView($page, $limit, $info);
				}
				else
				{
					$this->loadManageProductsView($page, $limit, $info);
				}
			}

		}

		if(isset($_POST['change-delete']))
		{
			if(isset($_POST['productID']))
			{
				$productID = $_POST['productID'];
			}
			else
			{
				$info = "System Error, please try again!";
				$this->loadManageProductsView($page, $limit, $info);
			}

			unset($_POST['change-delete']);

			//$isOrdered = $this->_productDAO->exist('orderedproduct', $productID);
			$param = array(
				'productID'=>$productID
				);
			$isOrdered = $this->_productDAO->select('orderedproduct', $param);

			if(sizeof($isOrdered) == 0)
			{
				$param = array(
					'id'=> $productID
					);

				$rowAffected = $this->_productDAO->delete('products', $param);

				if($rowAffected == 0)
				{
					$info = 'System error, please try again!';
					$this->loadManageProductsView($page, $limit, $info);
				}
				else
				{
					$info = 'Successfully delete one product!';
					$this->loadManageProductsView($page, $limit, $info);
				}
			}
			else
			{
				$info = 'Sorry, you can not delete any ordered products!';
				$this->loadManageProductsView($page, $limit, $info);
			}
		}
		$this->loadManageProductsView($page, $limit, $info);
	}

	public function loadManageProductsView($page, $limit, $info = null)
	{
		$param = array();
		$products = $this->_productDAO->paginator($page, $limit, $param);

		//$total = $this->_productDAO->total('products', $param);
		$rows  = $this->_productDAO->select('products', $param);
		$total = sizeof($rows);

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
				'user'      => 'staff',
				'info'      => $info
			);

			$this->view('page', $data);
		}
		else
		{
			$info = 'Sorry, We don\'t have any products now.';
			$this->error($info);
		}
		exit;
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
			$this->loadChangePasswordView($info);
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
			$this->loadChangePasswordView($info);
		}

		$username = $_SESSION['staff']['username'];
		$password = sha1(md5($password1));

		$param = array(
			'username'=>$username,
			'password'=>$password
			);
		//$staff  = $this->_staffDAO->signInCheck($username, $password1);
		$isStaff = $this->_staffDAO->select('staffs', $param);

		if(sizeof($isStaff) != 1)
		{
			$info = "You have to enter the right password before change!";
			$this->loadChangePasswordView($info);
		}

		if($password1 == $password2)
		{
			$info = "You entered the same password as before!";
			$this->loadChangePasswordView($info);
		}

		if($password2 !== $password3)
		{
			$info = "Passwords have to be the same to change!";
			$this->loadChangePasswordView($info);
		}

		$param1['password'] = sha1(md5($password2));
		$param2['username'] = $username;

		$rowAffected = $this->_staffDAO->update('staffs', $param1, $param2);

		if($rowAffected != 1)
		{
			$info = "System Error, please try again!";
			$this->loadChangePasswordView($info);
		}
		else
		{
			$info  = "Password changed!";
			$this->loadChangePasswordView($info, true);
		}
	}

	public function loadChangePasswordView($info, $redirect = false)
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
		exit;
	}

	public function manageCategories()
	{
		$this->isStaff();

		$info = '';

		if(isset($_POST["addCategorySubmit"]))
		{
			$newCate = $_POST["category-name"];
			unset($_POST["addCategorySubmit"]);

			$isValid = true;


			if(strlen($newCate) < 5)
			{
				$info .= 'Category name must have at least 5 characters!<br>';
				$isValid = false;
			}

			$pattern = "/^[a-zA-Z0-9_.'-]*$/";

			if(!preg_match($pattern, $newCate))
			{
				$info .= "Category name can only contain \"a-zA-Z0-9_ /\.'-\"!<br>";
				$isValid = false;
			}

			if(!$isValid)
			{
				$this->loadManageCategoriesView(false, $info);
			}
			else
			{
				//$isExist = $this->_gearTypeDAO->isExist('geartypes', $newCate);
				$param = array(
					'name'   => $newCate
					);
				$isExist = $this->_gearTypeDAO->select('geartypes', $param);
				if(sizeof($isExist) != 0)
				{
					$info .= "You've aleady have a category called $newCate.<br>";
					$this->loadManageCategoriesView(false, $info);
				}

				$param = array(
					'name'   => $newCate,
					'status' => true
					);

				$id = $this->_gearTypeDAO->insert('geartypes', $param);

				if($id > 0)
				{
					$info = "You've added a new category - $newCate successfully.";
					$this->loadManageCategoriesView(true, $info);
				}
			}
		}

		if(isset($_POST['category-delete']))
		{
			$id = $_POST['categoryID'];
			unset($_POST['category-delete']);

			$param = array(
				'id'=>$id
				);
			//$products = $this->_productDAO->getProductBy($param);
			$products = $this->_productDAO->select('geartypes', $param);
			if(sizeof($products) > 0)
			{
				$info .= "You can not delete a category with products belong to it!<br>";
				$this->loadManageCategoriesView(false, $info);
			}
			else
			{
				$param = array(
					'id' => $id
					);
				$rowAffected = $this->_gearTypeDAO->delete('geartypes', $param);
				if($rowAffected == 0)
				{
					$info = "Error, please try later!<br>";
					$this->loadManageCategoriesView(false, $info);
				}
				else
				{
					$info = "You've deleted a category - $newCate successfully.";
					$this->loadManageCategoriesView(true, $info);
				}
			}
		}

		if(isset($_POST['category-update']))
		{
			unset($_POST['category-update']);

			$id     = $_POST['categoryID'];
			$name   = $_POST['category-name'];
			$_POST['category-status']==1 ? $status=true : $status=false;

			//$isExist = $this->_gearTypeDAO->isExist('geartypes', $name);
			$param = array(
					'name' => $name
					);
			$isExist = $this->_gearTypeDAO->select('geartypes', $param);

			if(sizeof($isExist) > 0)
			{
				$param = array(
					'name'   => $name,
					'status' => !$status
					);

				//$isUpdateStatus = $this->_gearTypeDAO->total('geartypes', $param);
				$isUpdateStatus = $this->_gearTypeDAO->select('geartypes', $param);

				if(sizeof($isUpdateStatus) != 1)
				{
					$info .= "You've aleady have a category called $name.<br>";
					$this->loadManageCategoriesView(false, $info);
				}

				
			}

			$columns = array(
				'name'   => $name,
				'status' => $status
				);
			$limits  = array(
				'id'     => $id
				);

			$rowAffected = $this->_staffDAO->update('geartypes', $columns, $limits);

			if($rowAffected != 1)
			{
				$info = 'Failed to update categories!<br>';
				$this->loadManageCategoriesView(false, $info);
			}
			else
			{
				$info = 'Update category successfully!<br>';
				$this->loadManageCategoriesView(true, $info);
			}
		}

		$this->loadManageCategoriesView(false, $info);
	}

	public function loadManageCategoriesView($loadNewGearTypes, $info = null)
	{
		if($loadNewGearTypes)
		{
			$gears = $this->_gearTypeDAO->getGearTypes();
		}
		else
		{
			$gears = $this->_gears;
		}

		$data = array(
			'title'     => "SportGear-Staff: manage Categories",
			'mainView'  => 'manageCategories',
			'brands'    => $this->_brands,
			'sportTypes'=> $this->_sports,
			'gearTypes' => $gears,
			'user'      => 'staff',
			'info'      => $info
		);

		$this->view('page', $data);
		exit();
	}

	public function customize()
	{
		$this->isStaff();

		$info = '';

		$staffID = $_SESSION['staff']['staffID'];
		
		if(isset($_POST['customizeSave']))
		{
			unset($_POST['customizeSave']);
			$style = '';
			
			if(isset($_POST['customize-fs']))
			{
				$fs = $_POST['customize-fs'];
				unset($_POST['customize-fs']);

				$style .= $this->setFontSize($fs, $style);
			}

			if(isset($_POST['customize-bg']))
			{
				$bg = $_POST['customize-bg'];
				unset($_POST['customize-bg']);

				$style .= "body{background:url(../images/theme/$bg)}";
			}

			$css = fopen("../public/css/staff".$staffID.".css", 'w+');

			fwrite($css, $style);

			fclose($css);
		}

		$data = array(
			'title'     => "SportGear-Staff: manage Categories",
			'mainView'  => 'customize',
			'brands'    => $this->_brands,
			'sportTypes'=> $this->_sports,
			'gearTypes' => $this->_gears,
			'user'      => 'staff',
			'info'      => $info
		);

		$this->view('page', $data);
	}

	public function setFontSize($fs, $style)
	{
		switch ($fs) {
			case 'small':
				$style .= ".staff-management-menu{font-size:18px;}";
				break;
			case 'medium':
				$style .= ".staff-management-menu{font-size:20px;}";
				break;
			case 'large':
				$style .= ".staff-management-menu{font-size:24px;}";
				break;
			
			default:
				$style .= ".staff-management-menu{font-size:16px;}";
				break;
		}

		return $style;
	}
}

