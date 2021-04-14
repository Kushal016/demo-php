<?php

//Declaring variable         
$fname="" ; //First Name
$lname="" ;//Last Name
$em=""  ;//Email
$em2="" ;//Email2
$password="" ;//password
$password2="" ;//password 2
$date="" ;//signup date
$error_array=array() ;//holds error msgs

if(isset($_POST['register_button'])){
	//First Name
	$fname=strip_tags($_POST['reg_fname']);//remove html tags
	$fname=str_replace(' ','', $fname);//remove spaces
	$fname=ucfirst(strtolower($fname));//uppercase 1st letter other lower
	$_SESSION['reg_fname'] = $fname; // Stores first name into session veriable


	//Last Name
	$lname=strip_tags($_POST['reg_lname']);//remove html tags
	$lname=str_replace(' ','', $lname);//remove spaces
	$lname=ucfirst(strtolower($lname));//uppercase 1st letter other lower
	$_SESSION['reg_lname'] = $lname; // Stores last name into session veriable


	//Email
	$em=strip_tags($_POST['reg_email1']);//remove html tags
	$em=str_replace(' ','', $em);//remove spaces
	//$em=ucfirst(strtolower($em));//uppercase 1st letter other lower
	$_SESSION['reg_email1'] = $em; // Stores email into session veriable



	//Email2
	$em2=strip_tags($_POST['reg_email2']);//remove html tags
	$em2=str_replace(' ','', $em2);//remove spaces
	//$em2=ucfirst(strtolower($em2));//uppercase 1st letter other lower
	$_SESSION['reg_email2'] = $em2; // Stores second email into session veriable


	//Password
	$password=strip_tags($_POST['reg_password1']);//remove html tags
	$password2=strip_tags($_POST['reg_password2']);//remove html tags

	//Date
	$date=date("Y-m-d");//holds current date

	// VALIDATION LOGIC

	iF($em == $em2){
		//check if Email is valid
		if(filter_var($em, FILTER_VALIDATE_EMAIL)){
			$em =filter_var($em, FILTER_VALIDATE_EMAIL) ;
			//check if Email is exixts 

			$e_check = mysqli_query($con,"SELECT email FROM users WHERE email='$em'");
			//Count the number of new returned
			$num_rows = mysqli_num_rows($e_check);

			if($num_rows > 0){
				//echo "Email already in use";
				array_push($error_array, "Email already in use<br>");
			}
		} else{
			//echo "Invalid Format";
			array_push($error_array, "Invalid Email Format<br>");
		}

	}else {
		//echo "Emails dont match";
		array_push($error_array, "Emails don't match<br>");
	}

	if(strlen($fname) > 25 || strlen($fname) <2){
	//echo "Your First name must be b/t 2-25 char ";
	array_push($error_array, "Your first name must be between 2 to 25 characters<br>");
	}

	if(strlen($lname) > 25 || strlen($lname) <2){
	//echo "Your last name must be b/t 2-25 char ";
	array_push($error_array, "Your last name must be between 2 to 25 characters<br>");
	}

	if($password != $password2){
		//echo "Your password dont match";
		array_push($error_array, "Your password don't match<br>");
	}else {
		if(preg_match('/[^A-Za-z0-9]/', $password)){
			//echo "your password can only contain englich charecter or numbers";
			array_push($error_array, "your password can only contain english charecter or numbers<br>");
		}
	}

	if(strlen($password) > 30 || strlen($password) <5){
		 //echo " Your password must be 5-30 characters";
		 array_push($error_array, "Your password must be 5-30 characters<br>");
	}


	if(empty($error_array)){
		$password = md5($password);// Encryption of password

		//Creating username by concatination firstname and last name 
		$username = strtolower($fname."_".$lname);
		$check_username_query = mysqli_query($con, "SELECT username FROM users WHERE username='$username'
			");
		$i =0;
		//if username exists add number to username
		while (mysqli_num_rows($check_username_query) != 0) {
				$i++;
				$username = $username."_".$i;
				$check_username_query = mysqli_query($con, "SELECT username FROM users WHERE username='$username'
			");
			}
			//Profile picture
			$rand = rand(1,2);
			if($rand ==1) 
				$profile_pic = "assets/images/profile_pics/defaults/default_male.jpg";
			else if($rand ==2)
				$profile_pic = "assets/images/profile_pics/defaults/default_female.jpg";

			$query = mysqli_query($con ,
				"INSERT INTO users VALUES('','$fname','$lname','$username','$em','$password','$date','$profile_pic','0','0','no',',')");  
			array_push($error_array, "<span style='color: #14C800;'> You all set Go ahead and login!</span><br>");
			//clear session data

			$_SESSION['reg_fname'] ="";
			$_SESSION['reg_lname'] ="";
			$_SESSION['reg_email1'] ="";
			$_SESSION['reg_email2'] ="";


	}
}
?>