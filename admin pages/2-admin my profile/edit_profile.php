<?php
session_start();

// التحقق مما إذا كان المستخدم قد قام بتسجيل الدخول
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true){
    // تم تسجيل الدخول، قم بتضمين ملف الاتصال بقاعدة البيانات
    include_once('C:\xampp\htdocs\garbage mangement project\0-DataBase\db_connection.php');

    // استعراض بيانات العميل من قاعدة البيانات
    $email = $_SESSION['email'];
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // عرض بيانات العميل إذا كان دوره "admin"
        $row = $result->fetch_assoc();
        if($row['ROLE'] === 'admin') {
            $username = $row['username'];
            $email = $row['email'];
            $address = $row['address'];
            $phone = $row['phone'];
        } else {
            echo "لا يمكن العثور على بيانات العميل";
            exit; // قم بإيقاف تشغيل النص إذا لم يكن دور المستخدم "admin"
        }
    } else {
        echo "لا يمكن العثور على بيانات العميل";
    }
} else {
    // إعادة توجيه المستخدم إلى صفحة تسجيل الدخول إذا لم يكن قد قام بتسجيل الدخول
    header("Location: http://localhost/garbage%20mangement%20project/2-login%20&sign%20for%20client/login_user.html");
    exit;
}

// إغلاق الاتصال بقاعدة البيانات
$conn->close();
?>







<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
        <title>crud dashboard</title>
	    <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="css/bootstrap.min.css">
	    <!----css3---->
        <link rel="stylesheet" href="css/custom.css">

        <!----fontawsem---->
        <link rel="stylesheet" href="css/all.min.css">
		
		
		<!--google fonts -->
	
	    <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
	
	
	<!--google material icon-->
      <link href="https://fonts.googleapis.com/css2?family=Material+Icons"rel="stylesheet">
      <!-- css -->
      <link rel="stylesheet" href="css/style.css">
     
      <link rel="stylesheet" href="client_info.css">
    

  </head>
  <body>
  

<div class="wrapper">


        <div class="body-overlay"></div>
		
		<!-------------------------sidebar------------>
		     <!-- Sidebar  -->
             <nav id="sidebar">
            <div class="sidebar-header">
                <a href="http://localhost:8080/garbage%20mangement%20project/admin%20pages/1-admin%20dashboard/"><h3><span>pure</span></h3></a>
            </div>
            <ul class="list-unstyled components">
			<li  class="">
                    <a href="http://localhost:8080/garbage%20mangement%20project/admin%20pages/2-admin%20my%20profile/INDEX%20admin.php" class="dashboard"><i class="fa-solid fa-circle-user "></i>
					<span>my profile</span></a>
                </li>
                <li class="dropdown">
                    <a href="#homeSubmenu1" data-toggle="collapse" aria-expanded="false" 
					class="dropdown-toggle">
					<i class="fa-solid fa-trash pe-1"></i> service</a>
                    <ul class="collapse list-unstyled menu" id="homeSubmenu1">
                        <li>
                            <a href="http://localhost:8080/garbage%20mangement%20project/admin%20pages/3-bins%20details%20for%20admin%20-%20new/">smart bin</a>
                        </li>
                        <li>
                            <a href="http://localhost:8080/garbage%20mangement%20project/admin%20pages/9-monthly%20service%20details/">monthly</a>
                        </li>
                        <li>
                            <a href="http://localhost:8080/garbage%20mangement%20project/admin%20pages/8-single%20time%20order%20details/">single order</a>
                        </li>
                    </ul>
                </li>
                <li  class="">
                    <a href="http://localhost:8080/garbage%20mangement%20project/admin%20pages/4-clients%20details%20for%20admin%20-%20new/" class="dashboard"><i class="fa-solid fa-users pe-1"></i>
					<span>clients</span></a>
                </li>
                <li class="dropdown">
                    <a href="#pageSubmenu3" data-toggle="collapse" aria-expanded="false" 
					class="dropdown-toggle">
					<i class="fa-solid fa-users-gear pe-1"></i><span>collector</span></a>
                    <ul class="collapse list-unstyled menu" id="pageSubmenu3">
                       
                        
                        <li>
                            <a href="http://localhost:8080/garbage%20mangement%20project/admin%20pages/6-collectors%20details%20for%20admin-%20new/">veiw</a>
                        </li>
                        <li>
                            <a href="http://localhost:8080/garbage%20mangement%20project/admin%20pages/10-add%20collector/add%20collector.php">add</a>
                        </li>
                        
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#pageSubmenu4" data-toggle="collapse" aria-expanded="false" 
					class="dropdown-toggle">
					<i class="fa-solid fa-user-tie pe-1"></i><span>Sub admin</span></a>
                    <ul class="collapse list-unstyled menu" id="pageSubmenu4">
                       
                        
                        <li>
                            <a href="http://localhost:8080/garbage%20mangement%20project/admin%20pages/5-admins%20details%20for%20admin%20-%20new/">veiw</a>
                        </li>
                        <li>
                            <a href="http://localhost:8080/garbage%20mangement%20project/admin%20pages/11-add%20admin/add%20admin.php">add</a>
                        </li>
                        
                    </ul>
                </li>
                
                <li  class="">
                    <a href="http://localhost:8080/garbage%20mangement%20project/admin%20pages/12-invoices%20details%20for%20admin/" class="dashboard"><i class="fa-solid fa-receipt pe-1"></i>
					<span>invoice details</span></a>
                </li>
                
                <li class="dropdown">
                    <a href="#pageSubmenu2" data-toggle="collapse" aria-expanded="false" 
					class="dropdown-toggle">
					<i class="fa-solid fa-face-frown pe-1"></i><span>complaint</span></a>
                    <ul class="collapse list-unstyled menu" id="pageSubmenu2">
                       
                        <li>
                            <a href="http://localhost:8080/garbage%20mangement%20project/admin%20pages/7-admin%20view%20complaint%20and%20respond/">view complaint</a>
                        </li>
                        
                    </ul>
                </li>
               
               
            </ul>

           
        </nav>
		
		
		
		
		<!--------page-content---------------->
		
		<div id="content">
		   
		   <!--top--navbar----design--------->
		   
		   <div class="top-navbar">
		      <div class="xp-topbar">

                <!-- Start XP Row -->
                <div class="row"> 
                    <!-- Start XP Col -->
                    <div class="col-2 col-md-1 col-lg-1 order-2 order-md-1 align-self-center">
                        <div class="xp-menubar">
                               <span class="material-icons text-white">signal_cellular_alt
							   </span>
                         </div>
                    </div> 
                    <!-- End XP Col -->

                    <!-- Start XP Col -->
                    <div class="col-md-5 col-lg-3 order-3 order-md-2">
                        <div class="xp-searchbar">
                            <form>
                                <div class="input-group">
                                  <input type="search" class="form-control" 
								  placeholder="Search">
                                  <div class="input-group-append">
                                    <button class="btn" type="submit" 
									id="button-addon2">GO</button>
                                  </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- End XP Col -->

                    <!-- Start XP Col -->
                    <div class="col-10 col-md-6 col-lg-8 order-1 order-md-3">
                        <div class="xp-profilebar text-right">
							 <nav class="navbar p-0">
                        <ul class="nav navbar-nav flex-row ml-auto">   
                            <li class="dropdown nav-item active">
                                <a href="#" class="nav-link" data-toggle="dropdown">
                                   <span class="material-icons">notifications</span>
								   <span class="notification">4</span>
                               </a>
                                <ul class="dropdown-menu">
                                <li>
                                        <a href="#"></a>
                                    </li>
                                    <li>
                                        <a href="#"></a>
                                    </li>
                                    <li>
                                        <a href="#"></a>
                                    </li>
                                    <li>
                                        <a href="#"></a>
                                    </li>
                                  
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
								<span class="material-icons">question_answer</span>

								</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link" href="#" data-toggle="dropdown">
								<img src="img/user.jpg" style="width:40px; border-radius:50%;"/>
								<span class="xp-user-live"></span>
								</a>
								<ul class="dropdown-menu small-menu">
                                    <li>
                                        <a href="#">
										  <span class="material-icons">
person_outline
</span>Profile

										</a>
                                    </li>
                                    <li>
                                        <a href="#"><span class="material-icons">
settings
</span>Settings</a>
                                    </li>
                                    <li>
                                    <a href="logout.php"><span class="material-icons">
logout</span>Logout</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    
               
            </nav>
							
                        </div>
                    </div>
                    <!-- End XP Col -->

                </div> 
                <!-- End XP Row -->

            </div>
           
    </div>
    <div class="container">
        <h2>Edit Profile</h2>
        <form action="update_profile.php" method="POST">
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username" value="<?php echo $username; ?>" required><br>
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" value="<?php echo $email; ?>" required><br>
            <label for="address">Address:</label><br>
            <input type="text" id="address" name="address" value="<?php echo $address; ?>" required><br>
            <label for="phone">Phone:</label><br>
            <input type="text" id="phone" name="phone" value="<?php echo $phone; ?>" required><br>
           
            <button type="submit">Save Changes</button>
        </form>
</div>

 <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="js/jquery-3.3.1.slim.min.js"></script>
    <script src="js/popper.min.js"></script>
    <!-- <script src="js/bootstrap.min.js"></script> -->
    <script src="js/jquery-3.3.1.min.js"></script>
    
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
 
 <script type="text/javascript">
        
		$(document).ready(function(){
		  $(".xp-menubar").on('click',function(){
		    $('#sidebar').toggleClass('active');
			$('#content').toggleClass('active');
		  });
		  
		   $(".xp-menubar,.body-overlay").on('click',function(){
		     $('#sidebar,.body-overlay').toggleClass('show-nav');
		   });
		  
		});
		
</script>

 
 
   </body>
   
   </html>


























