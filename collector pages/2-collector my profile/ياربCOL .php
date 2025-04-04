<?php
session_start();

// التحقق مما إذا كان المستخدم قد قام بتسجيل الدخول
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true){
    // تم تسجيل الدخول، قم بتضمين ملف الاتصال بقاعدة البيانات
    include_once('C:\xampp\htdocs\garbage mangement project\0-DataBase\db_connection.php');

    // استعراض بيانات العميل من قاعدة البيانات
    $email = $_SESSION['email'];
    $sql = "SELECT * FROM collector WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // عرض بيانات العميل
        $row = $result->fetch_assoc();
        $username = $row['username'];  // استرداد اسم المستخدم
        $email = $row['email'];
        $address = $row['address'];
        $phone = $row['phone'];
        $zone = $row['zone'];
        
       
    } else {
        echo "لا يمكن العثور على بيانات العميل";
    }
} else {
    // إعادة توجيه المستخدم إلى صفحة تسجيل الدخول إذا لم يكن قد قام بتسجيل الدخول
    header("Location:http://localhost:8080/garbage%20mangement%20project/2-log&sign/2-login%20%20for%20collector/login_COL.html");
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
            <a href="http://localhost:8080/garbage%20mangement%20project/collector%20pages/1-collector%20dashboard/%d9%8a%d8%a7%d8%b1%d8%a8COL%20.php"><h3><span>pure</span></h3></a>
            </div>
            <ul class="list-unstyled components">
			<li  class="active">
                    <a href="http://localhost:8080/garbage%20mangement%20project/collector%20pages/2-collector%20my%20profile/%D9%8A%D8%A7%D8%B1%D8%A8COL%20.php" class="dashboard"><i class="fa-solid fa-circle-user "></i>
					<span>my profile</span></a>
                </li>
                <li  class="">
                    <a href="http://localhost:8080/garbage%20mangement%20project/collector%20pages/6-daily%20schedule/" class="dashboard"><i class="fa-brands fa-dailymotion pe-1"></i>
					<span>daily schedule</span></a>
                </li>
               
                <li  class="">
                    <a href="http://localhost:8080/garbage%20mangement%20project/collector%20pages/3-montly%20service%20details%20for%20col%20-%20Copy/" class="dashboard"><i class="fa-solid fa-calendar-days pe-1"></i>
					<span>Monthly Service</span></a>
                </li>
                <li  class="">
                    <a href="http://localhost:8080/garbage%20mangement%20project/collector%20pages/4-smart%20bins%20details%20for%20collector/" class="dashboard"><i class="fa-solid fa-house-signal pe-1"></i>
					<span>smart service</span></a>
                </li>
                <li  class="">
                    <a href="http://localhost:8080/garbage%20mangement%20project/collector%20pages/5-single%20time%20orders%20details%20for%20col/" class="dashboard"><i class="fa-solid fa-users-gear pe-1"></i></i>
					<span>single time order</span></a>
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
                                        <a href="#"><span class="material-icons">
                                        <a href="logout.php"><span class="material-icons">logout</span>Logout</a>
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
		     <div class="xp-breadcrumbbar text-center">
                <h4 class="page-title">collector</h4>  
                            
            </div>
			
		   </div>
    <div class="container">
        <h2>collector Information</h2>
        <p>Name: <?php echo  $username; ?></p>
        <p>Email: <?php echo $email; ?></p>
        <p>Address: <?php echo $address; ?></p>
        <p>Phone: <?php echo $phone; ?></p>
        <p>Zone: <?php echo $zone; ?></p>
        <a class="buttoon" href="edit_COL _profile.php">تعديل البيانات</a>
    </div>

  
     <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="js/jquery-3.3.1.slim.min.js"></script>
   <script src="js/popper.min.js"></script>
   <script src="js/bootstrap.min.js"></script>
   <script src="js/jquery-3.3.1.min.js"></script>
  

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



