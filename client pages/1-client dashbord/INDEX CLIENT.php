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
            $email = $row['email'];
            $address = $row['address'];
            $phone = $row['phone'];
            $zone = $row['Zone'];

            // استعلام للحصول على service_package من جدول invoices
            $sql_package = "SELECT service_package FROM invoices WHERE email='$email'";
            $result_package = $conn->query($sql_package);
            
            if ($result_package->num_rows > 0) {
                $row_package = $result_package->fetch_assoc();
                $service_package = $row_package['service_package'];

                // التحقق من نوع الباقة وعرض البيانات المناسبة
                if ($service_package === 'regular') {
                    $sql_details = "SELECT collection_days, created_at, package_expiry_date FROM invoices WHERE email='$email'";
                } elseif ($service_package === 'vip') {
                    $sql_details = "SELECT distance, created_at, package_expiry_date FROM bin JOIN invoices ON bin.email = invoices.email WHERE invoices.email='$email'";
                } elseif ($service_package === 'one_time') {
                    $sql_details = "SELECT collection_date, created_at, status FROM invoices WHERE email='$email'";
                }

                $result_details = $conn->query($sql_details); 

                if ($result_details->num_rows > 0) {
                    $row_details = $result_details->fetch_assoc();
                } else {
                    echo "لا توجد بيانات إضافية متاحة";
                }
            } else {
                $service_package = "لا توجد باقة محددة";
            }
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

// إغلاق الاتصال بقاعدة البيانات
$conn->close();
?>

<!doctype html>
<html lang="en">
  <head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dashboard</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!----css3---->
    <link rel="stylesheet" href="css/custom.css">
    <!----fontawesome---->
    <link rel="stylesheet" href="css/all.min.css">
    <!--google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!--google material icon-->
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons"rel="stylesheet">
    <!-- css -->
    <link rel="stylesheet" href="css/style.css">
    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
			<li  class="">
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
                                        <a href="http://localhost/garbage%20mangement%20project/client%20pages/2-client%20my%20profile/INDEX%20CLIENT.php">
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

           
           <div class="container card">
    
            <div class="row gy-4">
                <div class="ser-bo col-md-3 ">
                    <div class="services-box text-center border border-1 py-5 ">
                        <div class="serviceMini-box mb-3">
                            <div class="ser-icon">
                              <i class="fa-solid fa-user fs-5 mb-4 main-color "></i>
                            </div>
                            
                            <h6 class="fw-bold ">Email</h6>
                        </div>
                        <p class="m-auto text-muted"><?php echo $email; ?></p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="services-box text-center border border-1 py-5">
                        <div class="serviceMini-box mb-3">
                            <div class="ser-icon">
                              
                              <i class="fa-solid fa-location-dot fs-2 mb-4 main-color"></i>
                            </div>
                            
                            <h6 class="fw-bold main-color">address</h6>
                        </div>
                        <p class="m-auto text-muted"><?php echo $address; ?></p>
                    </div>
                
                </div>
                <div class="col-md-3">
                    <div class="services-box text-center border border-1 py-5">
                        <div class="serviceMini-box mb-3">
                            <div class="ser-icon">
                              <i class="fa-solid fa-phone fs-2 mb-4 main-color"></i>
                            </div>
                            
                            <h6 class="fw-bold main-color">phone</h6>
                        </div>
                        <p class="m-auto main-color"><?php echo $phone; ?></p>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <div class="services-box text-center border border-1 py-5">
                        <div class="serviceMini-box mb-3">
                            <div class="ser-icon">
                              <i class="fa-solid fa-trash-can fs-2 mb-4 main-color"></i>

                            </div>
                            <h6 class="fw-bold main-color">my service</h6>
                        </div>
                        <p class="m-auto text-muted"><?php echo $service_package; ?></p>
                    </div>
                </div>
            </div>
            <!-- عرض البيانات الإضافية -->
            <?php if (isset($row_details)) { ?>
                <div class="row gy-4">
                    <?php if ($service_package === 'regular') { ?>
                        <div class="col-md-4">
                            <div class="services-box text-center border border-1 py-5">
                                <div class="serviceMini-box mb-3">
                                    <h6 class="fw-bold main-color">collection_days</h6>
                                </div>
                                <p class="m-auto text-muted"><?php echo $row_details['collection_days']; ?></p>
                            </div>
                        </div>
                        <div class="col-md-4">
    <div class="services-box text-center border border-1 py-5">
        <div class="serviceMini-box mb-3">
            <h6 class="fw-bold main-color">Package Expiry Date</h6>
        </div>
        <p class="m-auto text-muted"><?php echo $row_details['package_expiry_date']; ?></p>
    </div>
</div>

                    <?php } elseif ($service_package === 'vip') { ?>
                        <div class="col-md-4">
                            <div class="services-box text-center border border-1 py-4">
                            <div class="gauge text-center">
    <div class="gauge__body">
      <div class="gauge__fill"></div>
      <div class="gauge__cover"></div>
    </div>
  </div>
                            </div>
                        </div>
                        <div class="col-md-4">
    <div class="services-box text-center border border-1 py-5">
        <div class="serviceMini-box mb-3">
            <h6 class="fw-bold main-color">Package Expiry Date</h6>
        </div>
        <p class="m-auto text-muted"><?php echo $row_details['package_expiry_date']; ?></p>
    </div>
</div>

                    <?php } elseif ($service_package === 'one_time') { ?>
                        <div class="col-md-4">
                            <div class="services-box text-center border border-1 py-5">
                                <div class="serviceMini-box mb-3">
                                    <h6 class="fw-bold main-color">collection_date</h6>
                                </div>
                                <p class="m-auto text-muted"><?php echo $row_details['collection_date']; ?></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="services-box text-center border border-1 py-5">
                                <div class="serviceMini-box mb-3">
                                    <h6 class="fw-bold main-color">status</h6>
                                </div>
                                <p class="m-auto text-muted"><?php echo $row_details['status']; ?></p>
                            </div>
                        </div>
                    <?php } ?>
                    <div class="col-md-4">
                        <div class="services-box text-center border border-1 py-5">
                            <div class="serviceMini-box mb-3">
                                <h6 class="fw-bold main-color">created_at</h6>
                            </div>
                            <p class="m-auto text-muted"><?php echo $row_details['created_at']; ?></p>
                        </div>
                    </div>

                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<!----------html code compleate----------->



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
		


        $(document).ready(function() {
    function setGaugeValue(gauge, value) {
        if (value < 0 || value > 1) {
            return;
        }

        gauge.querySelector(".gauge__fill").style.transform = `rotate(${value / 2}turn)`;
        gauge.querySelector(".gauge__cover").textContent = `${Math.round(value * 100)}%`;
    }

    // قراءة قيمة المسافة من جدول البيانات
    var distance = <?php echo isset($row_details['distance']) ? $row_details['distance'] : 0; ?>;
    
    // طول الباسكت
    var basketLength = 52; // افتراضي، قم بتعديل هذا الرقم وفقًا لطول الباسكت الفعلي
    
    // قسم المسافة على طول الباسكت واحتساب النسبة المئوية
    var percentage = (52 - distance) / 52;  // التعديل هنا

    // تحديث قيمة المؤشر
    setGaugeValue(document.querySelector(".gauge"), percentage);
});

$(document).ready(function() {
    // قراءة قيمة المسافة من جدول البيانات
    var distance = <?php echo isset($row_details['distance']) ? $row_details['distance'] : 0; ?>;
    
    // إذا كانت القيمة أكبر من 45، عرض رسالة التحذير
    if (distance > 52) {
        alert("please close the bin");
    }
});

</script>
  
     <!-- JavaScript لتحقق النسبة وإرسال الإنذار
     <script>
                            $(document).ready(function() {
                                // التحقق من النسبة وإرسال الإنذار إذا كانت أكبر من 70%
                                function checkDistancePercentage(distance, maxDistance) {
                                    var percentage = (distance / maxDistance) * 100;
                                    return percentage;
                                }

                                var distances = [ // مثال على القيم التي يمكن استخدامها
                                    <?php echo isset($row_details['distance']) ? $row_details['distance'] : 0; ?>
                                    // يمكنك إضافة المزيد من القيم هنا
                                ];

                                distances.forEach(function(distance) {
                                    var percentage = checkDistancePercentage(distance, 100); // على افتراض أن المسافة القصوى هي 100
                                    if (percentage > 70) {
                                        alert("تحذير: المسافة تجاوزت 70%. النسبة الحالية: " + percentage + "%");
                                    }
                                });
                            });
                        </script>

		            </div>
		         </div>
		      
              </div>
			  
			  
			  
			 
			  
			  
			  
			  
			  
			  
		   </div>
		   
		   
		   
		 
		   
		   
		</div>
		
</div> -->


  
  
     <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
   <script src="js/jquery-3.3.1.slim.min.js"></script>
   <script src="js/popper.min.js"></script>
   <script src="js/bootstrap.min.js"></script>
   <script src="js/jquery-3.3.1.min.js"></script>
   <script src="script.js">  </script>
  
 

  </body>
  
  </html>








