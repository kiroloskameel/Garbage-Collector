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
        // عرض بيانات العميل
        $row = $result->fetch_assoc();
        
        // التحقق من دور المستخدم
        if ($row['ROLE'] === 'client') {
            // عرض بيانات العميل
            $username = $row['username'];  // استرداد اسم المستخدم
            $email = $row['email'];
            $address = $row['address'];
            $phone = $row['phone'];
            $zone = $row['Zone'];
            
            // التحقق مما إذا كان المفتاح موجودًا قبل عرضه
            $selected_package = isset($row['selected_package']) ? $row['selected_package'] : "لا يوجد باقة محددة";
        } else {
            // إعادة التوجيه إلى صفحة غير مصرح للوصول
            header("Location: http://localhost:8080/garbage%20mangement%20project/2-log&sign/1-login%20&sign%20for%20client-admin/login_user.html");
            exit;
        }
    } else {
        echo "لا يمكن العثور على بيانات العميل";
    }
} else {
    // إعادة توجيه المستخدم إلى صفحة تسجيل الدخول إذا لم يكن قد قام بتسجيل الدخول
    header("Location: http://localhost:8080/garbage%20mangement%20project/2-log&sign/1-login%20&sign%20for%20client-admin/login_user.html");
    exit;
}

// استعد المعلومات الخاصة بـ collectors من نفس الـ zone
$zone = $row['Zone']; // الـ zone الخاص بالعميل الحالي
$sql_collectors = "SELECT * FROM collector WHERE zone='$zone'";
$result_collectors = $conn->query($sql_collectors);
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
            <a href="http://localhost:8080/garbage%20mangement%20project/client%20pages/1-client%20dashbord/INDEX%20CLIENT.php"><h3><span>pure</span></h3></a>
            </div>
            <ul class="list-unstyled components">
			<li  class="active">
                    <a href="http://localhost:8080/garbage%20mangement%20project/client%20pages/2-client%20my%20profile/INDEX%20CLIENT.php" class="dashboard"><i class="fa-solid fa-circle-user "></i>
					<span>my profile</span></a>
                </li>
                <li  class="">
                    <a href="http://localhost:8080/garbage%20mangement%20project/client%20pages/3-my%20service/" class="dashboard"><i class="fa-solid fa-bell-concierge pe-1"></i>
					<span>my service</span></a>
                </li>
                <li  class="">
                    <a href="http://localhost:8080/garbage%20mangement%20project/client%20pages/9-client%20form%20for%20smartBin%20service/" class="dashboard"><i class="fa-solid fa-circle-plus pe-1"></i>
					<span>creat bin</span></a>
                </li>
		

                

                <li  class="">
                    <a href="http://localhost:8080/garbage%20mangement%20project/client%20pages/4-client%20invoice/" class="dashboard"><i class="fa-solid fa-circle-user "></i>
					<span>creat invoice</span></a>
                </li>
                
                <li class="dropdown">
                    <a href="#pageSubmenu2" data-toggle="collapse" aria-expanded="false" 
					class="dropdown-toggle">
					<i class="fa-solid fa-face-frown pe-1"></i><span>complaint</span></a>
                    <ul class="collapse list-unstyled menu" id="pageSubmenu2">
                        <li>
                            <a href="http://localhost:8080/garbage%20mangement%20project/client%20pages/6-client%20creat%20complaint/">creat complaint</a>
                        </li>
                        <li>
                            <a href="http://localhost:8080/garbage%20mangement%20project/client%20pages/5-client%20view%20my%20complaint/">view complaint</a>
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
		     <div class="xp-breadcrumbbar text-center">
                <h4 class="page-title">client</h4>  
                            
            </div>
			
		   </div>
		   
		   
		   
		   <!--------main-content------------->
           <div class="container">
        <h2>Client Information</h2>
        <p>Name: <?php echo  $username; ?></p>
        <p>Email: <?php echo $email; ?></p>
        <p>Address: <?php echo $address; ?></p>
        <p>Phone: <?php echo $phone; ?></p>
        <p>Zone: <?php echo $zone; ?></p>
        <a class="button" href="edit_profile.php">تعديل البيانات</a>
    </div>

    <div class="container">
        <h2>Collectors in the Same Zone</h2>
        <?php
        $collector_count = 1; // بدء عداد الترقيم
        // التحقق مما إذا كان هناك collectors متاحون في نفس الـ zone
        if ($result_collectors->num_rows > 0) {
            // عرض بيانات كل collector
            while ($row_collector = $result_collectors->fetch_assoc()) {
                echo "<p>Collector " . $collector_count . " Name: " . $row_collector['username'] . "</p>";
                echo "<p>Collector " . $collector_count . " Phone: " . $row_collector['phone'] . "</p>";
                $collector_count++; // زيادة قيمة العداد بعد كل تكرار
            }
        } else {
            echo "<p>there is no collectors here</p>";
        }
        ?>
    </div>
        </div>
		
</div>


<!----------html code compleate----------->








  
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
