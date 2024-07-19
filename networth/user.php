<?php
session_start();
include('config.php');
/**
* user class
*/
class User extends Database
{
	/**
	* parameter: username
	* parameter: password
	* return: json response
	* sessions: user session
	*
	* */
	public function login($username,$password)
	{
		$response = array(
			'status' => 0,
			'message' => 'Form submission failed, Please try again.',
		);
		$query="SELECT * FROM users WHERE email=? AND password=?";
		$stmt=$this->connect()->prepare($query);
		$stmt->execute([$username,$password]);
		if ($stmt->rowCount()) {
			$row=$stmt->fetch();
			if ($row['status']==1) {
				$_SESSION['user']=$row['title']." ".$row['name'];
				$_SESSION['user_id']=$row['user_id'];
				$_SESSION['role']=$row['role'];
				$response['message']='Redirecting...';
				$response['status']=1;
			}else{
				$response['message']='Account Suspended!';
				$response['status']=0;
			}
		}else{
			$response['message']='Invalid Login Credentials';
			$response['status']=0;
		}
		//post response
		echo json_encode($response);
	}
	/**
	* function to logout
	**/
	public function logOut()
	{
		$response = array(
			'status' => 0,
			'message' => 'Please try again.',
		);
		if (session_destroy()) {
			$response = array(
				'status' => 1,
				'message' => 'Logging Out. Good Bye!',
			);
		}
		echo json_encode($response);
	}
	/**
	* parameter: username
	* parameter: password
	* return: json response
	* sessions: user session
	*
	* */
	public function saveCategory($category)
	{
		$response = array(
			'status' => 0,
			'message' => 'Form submission failed, Please try again.',
		);
		if ($_SESSION['role']=="admin") {
			$query="INSERT INTO `categories`(`Description`) VALUES(?)";
			$stmt=$this->connect()->prepare($query);
			$result = $stmt->execute([$category]);
			if ($result) {
				$response['message']='Data save successfully!';
				$response['status']=1;
			}else{
				$response['message']='Error, please try again!';
				$response['status']=0;
			}
		}else{
			$response['message']='You dont have the permission!';
			$response['status']=0;
		}
		//post response
		echo json_encode($response);
	}
	/**
	* load categories
	*
	**/
	public function loadCategories(){
		
		$query="SELECT `category_id`, `Description`,COUNT(products.category) as products, `date_encoded` FROM `categories` LEFT JOIN products ON categories.category_id=products.category   GROUP BY category_id";
		$stmt=$this->connect()->prepare($query);
		$result=$stmt->execute();
		$array=[];
		if ($result) {
			while ($row=$stmt->fetch()) {
				$array[] = $row;
			}
			$dataset = array(
				"data" => $array
			);
		}else{
			$dataset = array(
				"data" => $array
			);
		}
		
		echo json_encode($dataset);
	}
	/**
	* load currency
	*
	**/
	public function loadCurrency(){
		
		$query="SELECT `id`, `code` FROM `currency`";
		$stmt=$this->connect()->prepare($query);
		$result=$stmt->execute();
		$array=[];
		if ($result) {
			while ($row=$stmt->fetch()) {
				$array[] = $row;
			}
			$dataset = array(
				"data" => $array
			);
		}else{
			$dataset = array(
				"data" => $array
			);
		}
		
		echo json_encode($dataset);
	}
	/**
	* load payment methods
	*
	**/
	public function loadPayMethod(){
		
		$query="SELECT `id`, `name`, `rate` FROM `payment_method`";
		$stmt=$this->connect()->prepare($query);
		$result=$stmt->execute();
		$array=[];
		if ($result) {
			while ($row=$stmt->fetch()) {
				$array[] = $row;
			}
			$dataset = array(
				"data" => $array
			);
		}else{
			$dataset = array(
				"data" => $array
			);
		}
		
		echo json_encode($dataset);
	}
	/**
	* load clients
	*
	**/
	public function loadClients(){
		
		$query="SELECT `client_id`, `Name`, `Phone` FROM `clients`";
		$stmt=$this->connect()->prepare($query);
		$result=$stmt->execute();
		$array=[];
		if ($result) {
			while ($row=$stmt->fetch()) {
				$array[] = $row;
			}
			$dataset = array(
				"data" => $array
			);
		}else{
			$dataset = array(
				"data" => $array
			);
		}
		
		echo json_encode($dataset);
	}
	/**
	* load cart
	*
	**/
	public function loadCart(){
		
		$query="SELECT cart.product_code,products.name,price,cart.quantity,total FROM cart LEFT JOIN products ON products.product_code=cart.product_code WHERE user=?";
		$stmt=$this->connect()->prepare($query);
		$result=$stmt->execute([$_SESSION['user_id']]);
		$array=[];
		if ($result) {
			while ($row=$stmt->fetch()) {
				$array[] = $row;
			}
			$dataset = array(
				"data" => $array
			);
		}else{
			$dataset = array(
				"data" => $array
			);
		}
		
		echo json_encode($dataset);
	}


	/**
	* load trending
	*
	**/
	public function loadTrending(){
		
		$query="SELECT item_id,products.name as name, SUM(qty) as SumQty,SUM(total) as SaleTotal FROM order_items LEFT JOIN products ON products.product_code=order_items.item_id GROUP BY item_id ORDER BY SumQty DESC LIMIT 5";
		$stmt=$this->connect()->prepare($query);
		$result=$stmt->execute();
		$array=[];
		if ($result) {
			while ($row=$stmt->fetch()) {
				$array[] = $row;
			}
			$dataset = array(
				"data" => $array
			);
		}else{
			$dataset = array(
				"data" => $array
			);
		}
		
		echo json_encode($dataset);
	}

	/**
	* load low stock products
	*
	**/
	public function loadLowStock(){
		
		$query="SELECT `product_code`, `name`, `selling_price`, `quantity`, `min_quantity` FROM `products` WHERE quantity<=min_quantity";
		$stmt=$this->connect()->prepare($query);
		$result=$stmt->execute();
		$array=[];
		if ($result) {
			while ($row=$stmt->fetch()) {
				$array[] = $row;
			}
			$dataset = array(
				"data" => $array
			);
		}else{
			$dataset = array(
				"data" => $array
			);
		}
		
		echo json_encode($dataset);
	}



	/****************
	* load products
	****************/
	public function loadProducts(){
		
		$query="SELECT `product_code`, `name`, `cost_price`, `selling_price`, `quantity`, `min_quantity`, `category`, `units`, `size`, `encoded_by`, `date`, categories.Description as cat_description FROM `products` LEFT JOIN categories ON categories.category_id=products.category";
		$stmt=$this->connect()->prepare($query);
		$result=$stmt->execute();
		$array=[];
		if ($result) {
			while ($row=$stmt->fetch()) {
				$array[] = $row;
			}
			$dataset = array(
				"data" => $array
			);
		}else{
			$dataset = array(
				"data" => $array
			);
		}
		
		echo json_encode($dataset);
	}
	/**
	* delete function
	*
	* */
	public function delete($item_id)
	{
		$response = array(
			'status' => 0,
			'message' => 'Query failed, Please try again.',
		);
		if ($_SESSION['role']=="admin") {
			$query="DELETE FROM categories WHERE category_id=?";
			$stmt=$this->connect()->prepare($query);
			$result = $stmt->execute([$item_id]);
			if ($result) {
				$response['message']='Item deleted successfully!';
				$response['status']=1;
			}else{
				$response['message']='Error, please try again!';
				$response['status']=0;
			}
		}else{
			$response['message']='You dont have the permission!';
			$response['status']=0;
		}
		//post response
		echo json_encode($response);
	}
	/**
	* delete function
	*
	* */
	public function delUser($id)
	{
		$response = array(
			'status' => 0,
			'message' => 'Query failed, Please try again.',
		);
		if ($_SESSION['role']=="admin") {
			$query="DELETE FROM users WHERE user_id=? AND role!='super user'";
			$stmt=$this->connect()->prepare($query);
			$result = $stmt->execute([$id]);
			if ($result) {
				$response['message']='User deleted successfully!';
				$response['status']=1;
			}else{
				$response['message']='Error, please try again!';
				$response['status']=0;
			}
		}else{
			$response['message']='You dont have the permission!';
			$response['status']=0;
		}
		//post response
		echo json_encode($response);
	}
	/**
	* delete function
	*
	* */
	public function delProduct($id)
	{
		$response = array(
			'status' => 0,
			'message' => 'Query failed, Please try again.',
		);
		if ($_SESSION['role']=="admin") {
			$query="DELETE FROM products WHERE product_code=?";
			$stmt=$this->connect()->prepare($query);
			$result = $stmt->execute([$id]);
			if ($result) {
				$response['message']='Product deleted successfully!';
				$response['status']=1;
			}else{
				$response['message']='Error, please try again!';
				$response['status']=0;
			}
		}else{
			$response['message']='You dont have the permission!';
			$response['status']=0;
		}
		//post response
		echo json_encode($response);
	}
	/**
	* delete function
	*
	* */
	public function delExpense($id)
	{
		$response = array(
			'status' => 0,
			'message' => 'Query failed, Please try again.',
		);
		if ($_SESSION['role']=="admin") {
			$query="DELETE FROM expenses WHERE expense_id=?";
			$stmt=$this->connect()->prepare($query);
			$result = $stmt->execute([$id]);
			if ($result) {
				$response['message']='Product deleted successfully!';
				$response['status']=1;
			}else{
				$response['message']='Error, please try again!';
				$response['status']=0;
			}
		}else{
			$response['message']='You dont have the permission!';
			$response['status']=0;
		}
		//post response
		echo json_encode($response);
	}

	/**
	* delete client
	*
	* */
	public function delClient($id)
	{
		$response = array(
			'status' => 0,
			'message' => 'Query failed, Please try again.',
		);
		if ($_SESSION['role']=="admin") {
			$query="DELETE FROM clients WHERE client_id=?";
			$stmt=$this->connect()->prepare($query);
			$result = $stmt->execute([$id]);
			if ($result) {
				$response['message']='Client deleted successfully!';
				$response['status']=1;
			}else{
				$response['message']='Error, please try again!';
				$response['status']=0;
			}
		}else{
			$response['message']='You dont have the permission!';
			$response['status']=0;
		}
		//post response
		echo json_encode($response);
	}
	/******************
	* FUNCTION TO GET TOTAL
	* /////////////////////*/
	/**
	* delete function
	*
	* */
	public function removeFromCart($id)
	{
		$response = array(
			'status' => 0,
			'message' => 'Query failed, Please try again.',
			'total'=>0,
		);
		if ($_SESSION['role']=="admin" || $_SESSION['role']=="cashier") {
			$query="DELETE FROM cart WHERE product_code=?";
			$stmt=$this->connect()->prepare($query);
			$result = $stmt->execute([$id]);
			if ($result) {
				$query="SELECT sum(total) as Total FROM cart";
				$stmt=$this->connect()->prepare($query);
				$totalResult = $stmt->execute();
				
				if ($totalResult){
					$row=$stmt->fetch();
					$response['total']= $row['Total'];
				}
				$response['message']='Product Removed Successfully!';
				$response['status']=1;
				
			}else{
				$response['message']='Error, please try again!';
				$response['status']=0;
			}
		}else{
			$response['message']='You dont have the permission!';
			$response['status']=0;
		}
		//post response
		echo json_encode($response);
	}
	/**
	* parameter: username
	* parameter: password
	* return: json response
	* sessions: user session
	*
	* */
	public function saveEmployee($title,$name,$surname,$gender,$password,$email,$phone,$address,$dob,$role,$status,$emp_date)
	{
		$response = array(
			'status' => 0,
			'message' => 'Form submission failed, Please try again.',
		);
		if ($_SESSION['role']=="admin") {
			$query="INSERT INTO `users`(`title`, `name`, `surname`, `gender`, `password`, `email`, `phone`, `address`, `dob`, `role`, `status`, `date_employed`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
			$stmt=$this->connect()->prepare($query);
			$result = $stmt->execute([$title,$name,$surname,$gender,$password,$email,$phone,$address,$dob,$role,$status,$emp_date]);
			if ($result) {
				$response['message']='Data saved successfully!';
				$response['status']=1;
			}else{
				$response['message']='Error, please try again!';
				$response['status']=0;
			}
		}else{
			$response['message']='You dont have the permission!';
			$response['status']=0;
		}
		//post response
		echo json_encode($response);
	}
	/**
	* parameter: username
	* parameter: password
	* return: json response
	* sessions: user session
	*
	* */
	public function saveItem($item_name,$cost_price,$selling_price,$quantity,$min_quantity,$categoryDropDown,$units,$size,$user_id)
	{
		$response = array(
			'status' => 0,
			'message' => 'Form submission failed, Please try again.',
		);
		if ($_SESSION['role']=="admin") {
			$query="INSERT INTO `products`(`name`, `cost_price`, `selling_price`, `quantity`, `min_quantity`, `category`, `units`, `size`, `encoded_by`) VALUES (?,?,?,?,?,?,?,?,?)";
			$stmt=$this->connect()->prepare($query);
			$result = $stmt->execute([$item_name,$cost_price,$selling_price,$quantity,$min_quantity,$categoryDropDown,$units,$size,$user_id]);
			if ($result) {
				$response['message']='Product saved successfully!';
				$response['status']=1;
			}else{
				$response['message']='Error, please try again!';
				$response['status']=0;
			}
		}else{
			$response['message']='You dont have the permission!';
			$response['status']=0;
		}
		//post response
		echo json_encode($response);
	}
	/**
	* parameter: username
	* parameter: password
	* return: json response
	* sessions: user session
	*
	* */
	public function saveExpense($description,$amount,$validity)
	{
		$response = array(
			'status' => 0,
			'message' => 'Form submission failed, Please try again.',
		);
		if ($_SESSION['role']=="admin") {
			$query="INSERT INTO `expenses` (`description`, `amount`,`validity`) VALUES (?,?,?)";
			$stmt=$this->connect()->prepare($query);
			$result = $stmt->execute([$description,$amount,$validity]);
			if ($result) {
				$response['message']='Product saved successfully!';
				$response['status']=1;
			}else{
				$response['message']='Error, please try again!';
				$response['status']=0;
			}
		}else{
			$response['message']='You dont have the permission!';
			$response['status']=0;
		}
		//post response
		echo json_encode($response);
	}
	/**
	* parameter: username
	* parameter: password
	* return: json response
	* sessions: user session
	*
	* */
	public function saveClient($clientName,$phoneNumber,$email)
	{
		$response = array(
			'status' => 0,
			'message' => 'Form submission failed, Please try again.',
		);
		if ($_SESSION['role']=="admin" || $_SESSION['role']=="cashier") {
			$query="INSERT INTO `clients`(`Name`, `Phone`,`email`) VALUES (?,?,?)";
			$stmt=$this->connect()->prepare($query);
			$result = $stmt->execute([$clientName,$phoneNumber,$email]);
			if ($result) {
				$response['message']='Client saved successfully!';
				$response['status']=1;
			}else{
				$response['message']='Error, please try again!';
				$response['status']=0;
			}
		}else{
			$response['message']='You dont have the permission!';
			$response['status']=0;
		}
		//post response
		echo json_encode($response);
	}
	/**
	* parameter: username
	* parameter: password
	* return: json response
	* sessions: user session
	*
	* */
	public function addToCart($pro_code,$productQuantity,$productTotal,$cost_price)
	{
		$response = array(
			'status' => 0,
			'message' => 'Form submission failed, Please try again.',
			'total'=>0
		);
		if ($_SESSION['role']=="admin"  || $_SESSION['role']=="cashier") {
			$query="INSERT INTO `cart`(`product_code`,`quantity`,`total`,`price`,`user`) VALUES (:pro_code,:productQuantity,:productTotal,:cost_price,:user) ON DUPLICATE KEY UPDATE quantity=quantity + :productQuantity, total= total + :productTotal";
			$stmt=$this->connect()->prepare($query);
			$stmt->bindParam(':pro_code',$pro_code,PDO::PARAM_STR);
			$stmt->bindParam(':productQuantity',$productQuantity,PDO::PARAM_STR);
			$stmt->bindParam(':productTotal',$productTotal,PDO::PARAM_STR);
			$stmt->bindParam(':cost_price',$cost_price,PDO::PARAM_STR);
			$stmt->bindParam(':user',$_SESSION['user_id'],PDO::PARAM_STR);
			$result = $stmt->execute();
			if ($result) {
				$query="SELECT sum(total) as Total FROM cart";
				$stmt=$this->connect()->prepare($query);
				$totalResult = $stmt->execute();
				
				if ($totalResult){
					$row=$stmt->fetch();
					$response['total']= $row['Total'];
				}
				$response['message']='Product added Successfully!';
				$response['status']=1;
			}else{
				$response['message']='Error, please try again!';
				$response['status']=0;
			}
		}else{
			$response['message']='You dont have the permission!';
			$response['status']=0;
		}
		//post response
		echo json_encode($response);
	}




	/**
	* load settings
	*
	**/
	public function loadSettings(){
		
		$query="SELECT `account`, `name`, `mobile`, `tel`, `email`, `logo`, `street`,`city`,`state`, currency.id as currency, currency.code as code,`order_prefix`, `ts_and_cs` FROM `master` LEFT JOIN currency ON master.currency=currency.id";
		$stmt=$this->connect()->prepare($query);
		$result=$stmt->execute();
		
		if ($result) {
			$row=$stmt->fetch();
		}
		
		echo json_encode($row);
	}
	/**
	* load employees
	*
	**/
	public function loadEmployees(){
		
		$query="SELECT `user_id`, `title`, `name`, `surname`, `gender`, `password`, `email`,COALESCE(sum(orders.total),0.00) as sales, `phone`, `address`, `dob`, `role`, `status`, `date_employed` FROM `users` LEFT JOIN orders ON orders.cashier=users.user_id GROUP BY user_id";
		$stmt=$this->connect()->prepare($query);
		$result=$stmt->execute();
		$array=[];
		if ($result) {
			while ($row=$stmt->fetch()) {
				$array[] = $row;
			}
			$dataset = array(
				"data" => $array
			);
		}else{
			$dataset = array(
				"data" => $array
			);
		}
		
		echo json_encode($dataset);
	}


	/**
	* load employees
	*
	**/
	public function genReport(){
		
		$query="SELECT `order_id`,clients.Name as client, payment_method.name as method, `subTotal`, `discount`, `total`, `tendered`, `payment_change`, CONCAT(users.name,' ',users.surname) as cashier, `order_date`, `order_time`,`balance`,trans_type.name as type FROM orders 
			LEFT JOIN clients ON clients.client_id=orders.customer 
			LEFT JOIN payment_method ON payment_method.id=orders.payment_method 
			LEFT JOIN trans_type ON orders.type=trans_type.id 
			LEFT JOIN users ON orders.cashier=users.user_id
			ORDER BY order_id DESC";
		$stmt=$this->connect()->prepare($query);
		$result=$stmt->execute();
		$array=[];
		if ($result) {
			while ($row=$stmt->fetch()) {
				$array[] = $row;
			}
			$dataset = array(
				"data" => $array
			);
		}else{
			$dataset = array(
				"data" => $array
			);
		}
		
		echo json_encode($dataset);
	}


	/**
	* load expenses
	*
	**/
	public function Dashboard(){
		
		$query="SELECT COALESCE(sum(tendered),0) FROM orders WHERE type=1 UNION ALL SELECT COALESCE(sum(cost_price*quantity),0) FROM products UNION ALL SELECT COALESCE(COUNT(product_code),0) FROM `products` WHERE quantity<=min_quantity UNION ALL SELECT COALESCE(count(product_code),0) FROM products UNION ALL SELECT COALESCE(sum(amount),0) FROM expenses WHERE validity >= DATE(now())";
		$stmt=$this->connect()->prepare($query);
		$result=$stmt->execute();
		$array=[];
		if ($result) {
			while ($row=$stmt->fetch()) {
				$array[] = $row;
			}
			$dataset = array(
				"data" => $array
			);
		}else{
			$dataset = array(
				"data" => $array
			);
		}
		
		echo json_encode($dataset);
	}



	/**
	* load expenses
	*
	**/
	public function loadExpenses(){
		
		$query="SELECT `expense_id`, `description`, `amount`,`validity` FROM `expenses`";
		$stmt=$this->connect()->prepare($query);
		$result=$stmt->execute();
		$array=[];
		if ($result) {
			while ($row=$stmt->fetch()) {
				$array[] = $row;
			}
			$dataset = array(
				"data" => $array
			);
		}else{
			$dataset = array(
				"data" => $array
			);
		}
		
		echo json_encode($dataset);
	}

	/**
	* load expenses
	*
	**/
	public function loadCustomer(){
		
		$query="SELECT `client_id`, `Name`, `Phone`, `email`,COALESCE(COUNT(orders.order_id),0) as orders,COALESCE(SUM(orders.total),0) as spend FROM `clients` INNER JOIN orders ON clients.client_id=orders.customer GROUP BY orders.customer ";
		$stmt=$this->connect()->prepare($query);
		$result=$stmt->execute();
		$array=[];
		if ($result) {
			while ($row=$stmt->fetch()) {
				$array[] = $row;
			}
			$dataset = array(
				"data" => $array
			);
		}else{
			$dataset = array(
				"data" => $array
			);
		}
		
		echo json_encode($dataset);
	}





	/**
	* parameter: username
	* parameter: password
	* return: json response
	* sessions: user session
	*
	* */
	public function updateEmployee($title,$name,$surname,$gender,$password,$email,$phone,$address,$dob,$role,$status,$emp_date,$id)
	{
		$response = array(
			'status' => 0,
			'message' => 'Form submission failed, Please try again.',
		);
		if ($_SESSION['role']=="admin") {
			$query="UPDATE `users` SET `title`=?,`name`=?,`surname`=?,`gender`=?,`password`=?,`email`=?,`phone`=?,`address`=?,`dob`=?,`role`=?,`status`=?,`date_employed`=? WHERE `user_id`=?";
			$stmt=$this->connect()->prepare($query);
			$result = $stmt->execute([$title,$name,$surname,$gender,$password,$email,$phone,$address,$dob,$role,$status,$emp_date,$id]);
			if ($result) {
				$response['message']='Data updated successfully!';
				$response['status']=1;
			}else{
				$response['message']='Error, please try again!';
				$response['status']=0;
			}
		}else{
			$response['message']='You dont have the permission!';
			$response['status']=0;
		}
		//post response
		echo json_encode($response);
	}




	/**
	* parameter: username
	* parameter: password
	* return: json response
	* sessions: user session
	*
	* */
	public function updateProduct($item_name,$cost_price,$selling_price,$quantity,$min_quantity,$categoryDropDown,$units,$size,$user_id,$id)
	{
		$response = array(
			'status' => 0,
			'message' => 'Form submission failed, Please try again.',
		);
		if ($_SESSION['role']=="admin") {
			$query="UPDATE `products` SET `name`=?,`cost_price`=?,`selling_price`=?,`quantity`=?,`min_quantity`=?,`category`=?,`units`=?,`size`=?,`encoded_by`=? WHERE `product_code`=?";
			$stmt=$this->connect()->prepare($query);
			$result = $stmt->execute([$item_name,$cost_price,$selling_price,$quantity,$min_quantity,$categoryDropDown,$units,$size,$user_id,$id]);
			if ($result) {
				$response['message']='Product updated successfully!';
				$response['status']=1;
			}else{
				$response['message']='Error, please try again!';
				$response['status']=0;
			}
		}else{
			$response['message']='You dont have the permission!';
			$response['status']=0;
		}
		//post response
		echo json_encode($response);
	}






	public function updateProfile($shopName,$mobile,$telephone,$email,$street,$city,$state,$currency,$account)
	{
		$response = array(
			'status' => 0,
			'message' => 'Form submission failed, Please try again.',
		);

		$filename = 'profile-logo';
		$target_directory = "../dist/img/credit/";

		$target_file = $target_directory.basename($_FILES["file"]["name"]);   //name is to get the file name of uploaded file

		$filetype = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

		$newfilename = $target_directory.$filename.".".$filetype;

		//move_uploaded_file($_FILES["file"]["tmp_name"],$newfilename);   // tmp_name is the file temprory stored in the server
		//Now to check if uploaded or not
		if ($_SESSION['role']=="admin") {

			if(move_uploaded_file($_FILES["file"]["tmp_name"],$newfilename)){
				$query="UPDATE `master` SET `name`=?,`mobile`=?,`tel`=?,`email`=?,`street`=?,`city`=?,`state`=?,`currency`=? WHERE `account`=?";
				$stmt=$this->connect()->prepare($query);
				$result = $stmt->execute([$shopName,$mobile,$telephone,$email,$street,$city,$state,$currency,$account]);
				if ($result) {
					$response['message']='Profile updated successfully!';
					$response['status']=1;
				}else{
					$response['message']='Error, please try again!';
					$response['status']=0;
				}
			}else{
				$response['message']='Image uploading failed!';
				$response['status']=0;
			}

			
		}else{
			$response['message']='You dont have the permission!';
			$response['status']=0;
		}

		
		
		//post response
		echo json_encode($response);
	}





	/**
	* parameter: username
	* parameter: password
	* return: json response
	* sessions: user session
	*
	* */
	public function updateExpense($description,$amount,$validity,$id)
	{
		$response = array(
			'status' => 0,
			'message' => 'Form submission failed, Please try again.',
		);
		if ($_SESSION['role']=="admin") {
			$query="UPDATE `expenses` SET `description`=?,`amount`=?,`validity`=? WHERE `expense_id`=?";
			$stmt=$this->connect()->prepare($query);
			$result = $stmt->execute([$description,$amount,$validity,$id]);
			if ($result) {
				$response['message']='Data updated successfully!';
				$response['status']=1;
			}else{
				$response['message']='Error, please try again!';
				$response['status']=0;
			}
		}else{
			$response['message']='You dont have the permission!';
			$response['status']=0;
		}
		//post response
		echo json_encode($response);
	}


	/**
	* parameter: username
	* parameter: password
	* return: json response
	* sessions: user session
	*
	* */
	public function updateClient($clientName,$phoneNumber,$clientemail,$clientUId)
	{
		$response = array(
			'status' => 0,
			'message' => 'Form submission failed, Please try again.',
		);
		if ($_SESSION['role']=="admin") {

			$query="UPDATE clients SET Name=:clientName, Phone= :phoneNumber,email=:clientemail WHERE client_id=:clientUId";

			$stmt=$this->connect()->prepare($query);
			$stmt->bindParam(':clientName',$clientName,PDO::PARAM_STR);
			$stmt->bindParam(':phoneNumber',$phoneNumber,PDO::PARAM_STR);
			$stmt->bindParam(':clientemail',$clientemail,PDO::PARAM_STR);
			$stmt->bindParam(':clientUId',$clientUId,PDO::PARAM_STR);

			$result = $stmt->execute();
			if ($result) {
				$response['message']='Client updated successfully!';
				$response['status']=1;
			}else{
				$response['message']='Error, please try again!';
				$response['status']=0;
			}
		}else{
			$response['message']='You dont have the permission!';
			$response['status']=0;
		}
		//post response
		echo json_encode($response);
	}


	/**update order
	* parameter: username
	* parameter: password
	* return: json response
	* sessions: user session
	*
	* */
	public function updateOrder($balance,$amtPaid,$newchange,$Orderid)
	{
		$response = array(
			'status' => 0,
			'message' => 'Form submission failed, Please try again.',
		);
		if ($_SESSION['role']=="admin") {

			$query="UPDATE orders SET balance=:balance, payment_change= :newchange,tendered=tendered+:amtPaid WHERE order_id=:Orderid";

			$stmt=$this->connect()->prepare($query);
			$stmt->bindParam(':balance',$balance,PDO::PARAM_STR);
			$stmt->bindParam(':amtPaid',$amtPaid,PDO::PARAM_STR);
			$stmt->bindParam(':newchange',$newchange,PDO::PARAM_STR);
			$stmt->bindParam(':Orderid',$Orderid,PDO::PARAM_STR);

			$result = $stmt->execute();
			if ($result) {
				$response['message']='Order updated successfully!';
				$response['status']=1;
			}else{
				$response['message']='Error, please try again!';
				$response['status']=0;
			}
		}else{
			$response['message']='You dont have the permission!';
			$response['status']=0;
		}
		//post response
		echo json_encode($response);
	}



	//cart subTotal
	public function getSubtotal()
	{
		$response = array(
			'total' => 0,
			'status'=>0,
		);
		$query="SELECT sum(total) as Total FROM cart WHERE user=?";
		$stmt=$this->connect()->prepare($query);
		$totalResult = $stmt->execute([$_SESSION['user_id']]);
				
		if ($totalResult){
			$row=$stmt->fetch();
			$response['total']= $row['Total'];
			$response['status']=1;
		}else{
			$response['total']= 0;
			$response['status']=0;
		}
		echo json_encode($response);
	}

	/**
	 * void transaction
	 * */
	public function voidCart()
	{
		$response = array(
			'status' => 0,
			'message' => 'Form submission failed, Please try again.',
		);
		if ($_SESSION['role']=="admin"  || $_SESSION['role']=="cashier") {
			$query="TRUNCATE TABLE cart";
			$stmt=$this->connect()->prepare($query);
			$result = $stmt->execute();

			if ($result) {
				$response['message']='Transaction terminated successfully!';
				$response['status']=1;
			}else{
				$response['message']='Failed!';
				$response['status']=0;
			}
		}else{
			$response['message']='You cannot perform this action!';
			$response['status']=0;
		}
		echo json_encode($response);

	}


	/**
	 * void transaction
	 * */
	public function saleChart()
	{
		$query="SELECT calendar_date as Date,COALESCE(sum(orders.total), 0 ) as sale FROM calendar left JOIN orders ON calendar.calendar_date=orders.order_date WHERE calendar.calendar_date <= DATE(now()) AND calendar.calendar_date >= SUBDATE(now(),INTERVAL 7 DAY) GROUP BY calendar_date ORDER BY calendar_date ASC";
		$stmt=$this->connect()->prepare($query);
		$result=$stmt->execute();
		$array=[];
		if ($result) {
			while ($row=$stmt->fetch()) {
				$array[] = $row;
			}
			$dataset = array(
				"data" => $array
			);
		}else{
			$dataset = array(
				"data" => $array
			);
		}
		
		echo json_encode($dataset);

	}

	//load order items
	public function orderItems($id)
	{
		$query="SELECT `id`, `order_id`,products.name as name, `item_id`, `price`, `qty`, `total` FROM `order_items` LEFT JOIN products ON order_items.item_id=products.product_code WHERE order_id=?";
		$stmt=$this->connect()->prepare($query);
		$result=$stmt->execute([$id]);
		$array=[];
		if ($result) {
			while ($row=$stmt->fetch()) {
				$array[] = $row;
			}
			$dataset = array(
				"data" => $array
			);
		}else{
			$dataset = array(
				"data" => $array
			);
		}
		
		echo json_encode($dataset);

	}
	//getIncoice
	public function getInvoice($id)
	{
		$response = array(
			'status' => 0,
			'message' => 'Form submission failed, Please try again.',
			'lastid'=>0,
			'clientName'=>0,
			'phone'=>0,
			'email'=>0,
			'payMethod'=>0,
			'subTotal'=>0,
			'discount'=>0,
			'total'=>0,
			'tendered'=>0,
			'payment_change'=>0,
			'cashier'=>0,
			'order_date'=>0,
			'order_time'=>0,
			'balance'=>0,
			'dateToday'=>0,
			'type'=>0,
		);


		$queryLast="SELECT `order_id`,clients.Name as client,clients.Phone as phone,clients.email as email, payment_method.name as method, `subTotal`, `discount`, `total`, `tendered`, `payment_change`, `cashier`, `order_date`, `order_time`,`balance`,trans_type.name as type FROM orders 
			LEFT JOIN clients ON clients.client_id=orders.customer 
			LEFT JOIN payment_method ON payment_method.id=orders.payment_method
			LEFT JOIN trans_type ON orders.type=trans_type.id  
			WHERE order_id=?";

			$stmt=$this->connect()->prepare($queryLast);
			$result=$stmt->execute([$id]);

			if ($result) {
				$row=$stmt->fetch();

				$invoice_id=$row['order_id'];
				$response['lastid']=$row['order_id'];
				$response['clientName']=$row['client'];
				$response['phone']=$row['phone'];
				$response['email']=$row['email'];
				$response['payMethod']=$row['method'];
				$response['subTotal']=$row['subTotal'];
				$response['discount']=$row['discount'];
				$response['total']=$row['total'];
				$response['tendered']=$row['tendered'];
				$response['payment_change']=$row['payment_change'];
				$response['cashier']=$row['cashier'];
				$response['order_date']=$row['order_date'];
				$response['order_time']=$row['order_time'];
				$response['balance']=$row['balance'];
				$response['dateToday']=date('Y-m-d');
				$response['type']=$row['type'];

				$response['message']='Transaction completed Successfully!';
				$response['status']=1;






			}else{
				$response['message']='Transaction failed!';
				$response['status']=0;
			}
			
			//post response
			echo json_encode($response);


	}
	/**
	 * save transaction
	 * */
	public function checkout($client, $payMethod, $subTotal, $discount, $total, $amtTendered, $amtChange, $transType, $user, $balance) {
    $response = array(
        'status' => 0,
        'message' => 'Form submission failed, Please try again.',
        'lastid' => 0,
        'clientName' => 0,
        'phone' => 0,
        'email' => 0,
        'payMethod' => 0,
        'subTotal' => 0,
        'discount' => 0,
        'total' => 0,
        'tendered' => 0,
        'payment_change' => 0,
        'cashier' => 0,
        'order_date' => 0,
        'order_time' => 0,
        'balance' => 0,
        'dateToday' => 0,
        'type' => 0,
    );

    try {
        $cashier = $_SESSION['user'];
        date_default_timezone_set('Africa/Harare');
        $date = date('Y-m-d');
        $time = date("H:i:s");

        if ($_SESSION['role'] == "admin" || $_SESSION['role'] == "cashier") {
            $query = "INSERT INTO `orders`(`customer`, `payment_method`, `subTotal`, `discount`, `total`, `tendered`, `payment_change`, `type`, `cashier`, `order_date`, `order_time`, `balance`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
            $stmt = $this->connect()->prepare($query);
            $result = $stmt->execute([$client, $payMethod, $subTotal, $discount, $total, $amtTendered, $amtChange, $transType, $user, $date, $time, $balance]);

            if ($result) {
                $queryLast = "SELECT `order_id`, clients.Name as client, clients.Phone as phone, clients.email as email, payment_method.name as method, `subTotal`, `discount`, `total`, `tendered`, `payment_change`, `cashier`, `order_date`, `order_time`, `balance`, trans_type.name as type FROM orders 
                LEFT JOIN clients ON clients.client_id = orders.customer 
                LEFT JOIN payment_method ON payment_method.id = orders.payment_method
                LEFT JOIN trans_type ON orders.type = trans_type.id  
                ORDER BY order_id DESC LIMIT 1";

                $stmt = $this->connect()->prepare($queryLast);
                $stmt->execute();
                $row = $stmt->fetch();

                $invoice_id = $row['order_id'];
                $response['lastid'] = $row['order_id'];
                $response['clientName'] = $row['client'];
                $response['phone'] = $row['phone'];
                $response['email'] = $row['email'];
                $response['payMethod'] = $row['method'];
                $response['subTotal'] = $row['subTotal'];
                $response['discount'] = $row['discount'];
                $response['total'] = $row['total'];
                $response['tendered'] = $row['tendered'];
                $response['payment_change'] = $row['payment_change'];
                $response['cashier'] = $row['cashier'];
                $response['order_date'] = $row['order_date'];
                $response['order_time'] = $row['order_time'];
                $response['balance'] = $row['balance'];
                $response['dateToday'] = date('Y-m-d');
                $response['type'] = $row['type'];

                $queryInsertProducts = "INSERT INTO `order_items`(`order_id`, `item_id`, `price`, `qty`, `total`) SELECT '$invoice_id', `product_code`, `price`, `quantity`, `total` FROM `cart`";
                $stmt = $this->connect()->prepare($queryInsertProducts);
                $insertSelect = $stmt->execute();

                if ($insertSelect) {
                    $queryUpdateProducts = "UPDATE products, cart SET products.quantity = products.quantity - cart.quantity WHERE products.product_code = cart.product_code";
                    $stmt = $this->connect()->prepare($queryUpdateProducts);
                    $selectUpdate = $stmt->execute();

                    if ($selectUpdate) {
                        $truncCart = "TRUNCATE TABLE cart";
                        $stmt = $this->connect()->prepare($truncCart);
                        $truncateTable = $stmt->execute();

                        if ($truncateTable) {
                            $response['message'] = 'Transaction completed Successfully!';
                            $response['status'] = 1;
                        }
                    }
                }
            } else {
                $response['message'] = 'Error, please try again!';
            }
        } else {
            $response['message'] = 'You don\'t have the permission!';
        }
    } catch (Exception $e) {
        error_log($e->getMessage());
        $response['message'] = 'An error occurred: ' . $e->getMessage();
    }

    //post response
    echo json_encode($response);
}
	
}








/**
* REQUESTS AND RESPONSES
* */
$user1= new User;
if ($_REQUEST['action']) {
	$action=$_REQUEST['action'];
	switch ($action) {
		case 'login':
			$user1->login($_POST['username'],$_POST['password']);
			break;
		case 'logout':
			$user1->logOut();
			break;
		case 'add_cart':
			$user1->saveCategory($_POST['category']);
			break;
		case 'tblCategory':
			$user1->loadCategories();
			break;
		case 'delCat':
			$user1->delete($_POST['id']);
			break;
		case 'saveEmp':
			$user1->saveEmployee($_POST['title'],$_POST['name'],$_POST['surname'],$_POST['gender'],$_POST['password'],$_POST['email'],$_POST['phone'],$_POST['address'],$_POST['dob'],$_POST['role'],$_POST['status'],$_POST['emp_date']);
			break;
		case 'tblEmployee':
			$user1->loadEmployees();
			break;
		case 'updateEmp':
			$user1->updateEmployee($_POST['title'],$_POST['name'],$_POST['surname'],$_POST['gender'],$_POST['password'],$_POST['email'],$_POST['phone'],$_POST['address'],$_POST['dob'],$_POST['role'],$_POST['status'],$_POST['emp_date'],$_POST['id']);
			break;
		case 'userDelete':
			$user1->delUser($_POST['id']);
			break;
		case 'ldCategory':
			$user1->loadCategories();
			break;
		case 'ldPayMethod':
			$user1->loadPayMethod();
			break;
		case 'ldClient':
			$user1->loadClients();
			break;
		case 'saveItem':
			$user1->saveItem($_POST['item_name'],$_POST['cost_price'],$_POST['selling_price'],$_POST['quantity'],$_POST['min_quantity'],$_POST['categoryDropDown'],$_POST['units'],$_POST['size'],$_SESSION['user_id']);
			break;
		
		case 'addClient':
			$user1->saveClient($_POST['clientName'],$_POST['phoneNumber'],$_POST['clientemail']);
			break;
		case 'tblProduct':
			$user1->loadProducts();
			break;
		case 'ldProducts':
			$user1->loadProducts();
			break;
		case 'ldCurrency':
			$user1->loadCurrency();
			break;
		
		case 'ldProfile':
			$user1->loadSettings();
			break;

		case 'ldSalesChart':
			$user1->saleChart();
			break;

		case 'tblExpense':
			$user1->loadExpenses();
			break;

		case 'tblCustomer':
			$user1->loadCustomer();
			break;

		case 'updateProduct':
			$user1->updateProduct($_POST['item_name'],$_POST['cost_price'],$_POST['selling_price'],$_POST['quantity'],$_POST['min_quantity'],$_POST['categoryDropDown'],$_POST['units'],$_POST['size'],$_SESSION['user_id'],$_POST['pro_id']);
			break;
		case 'prodDelete':
			$user1->delProduct($_POST['id']);
			break;
		case 'exDel':
			$user1->delExpense($_POST['id']);
			break;
			case 'clientDel':
			$user1->delClient($_POST['id']);
			break;
		case 'saveExpense':
			$user1->saveExpense($_POST['expense'],$_POST['amount'],$_POST['validity']);
			break;
		case 'updateExpense':
			$user1->updateExpense($_POST['expense'],$_POST['amount'],$_POST['validity'],$_POST['id']);
			break;
		case 'updateClient':
			$user1->updateClient($_POST['clientName'],$_POST['phoneNumber'],$_POST['clientemail'],$_POST['clientUId']);
			break;
		case 'updateOrder':
			$user1->updateOrder($_POST['balance'],$_POST['amtPaid'],$_POST['newchange'],$_POST['Orderid']);
			break;
		case 'addToCart':
			$user1->addToCart($_POST['pro_code'],$_POST['productQuantity'],$_POST['productTotal'],$_POST['cost_price']);
			break;
		case 'loadCart':
			$user1->loadCart();
			break;
		case 'tblReport':
			$user1->genReport();
			break;
		case 'print-receipt':
			$user1->getInvoice($_POST['id']);
			break;
		case 'removeCart':
			$user1->removeFromCart($_POST['id']);
			break;
		case 'subtotal':
			$user1->getSubtotal();
			break;
		case 'ldDashboard':
			$user1->Dashboard();
			break;
		case 'updateProfile':
			$user1->updateProfile($_POST['shopName'],$_POST['mobile'],$_POST['telephone'],$_POST['email'],$_POST['street'],$_POST['city'],$_POST['state'],$_POST['currency'],$_POST['account']);
			$user1->logOut();
			break;
		case 'ldOrderItems':
			$user1->orderItems($_POST['lastid']);
			break;
		case 'checkout':
			$user1->checkout($_POST['client'],$_POST['payMethod'],$_POST['subTotal'],$_POST['discount'],$_POST['total'],$_POST['amtTendered'],$_POST['amtChange'],$_POST['transType'],$_SESSION['user_id'],$_POST['balance']);
			break;
		case 'void':
			$user1->voidCart();
			break;
		case 'loadTrending':
			$user1->loadTrending();
			break;
		case 'lowStock':
			$user1->loadLowStock();
			break;

		default:
			// code...
			break;
	}
}
?>