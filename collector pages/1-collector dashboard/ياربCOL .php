
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
        $email = $row['email'];
        $address = $row['address'];
        $phone = $row['phone'];
        $zone = $row['zone'];
        

        
        // جلب بيانات الفواتير
        $sql_invoices = "
    SELECT 
        service_package, 
        COUNT(CASE WHEN status = 'collected' THEN 1 END) AS collected_count,
        COUNT(CASE WHEN status = 'not collected' THEN 1 END) AS not_collected_count
    FROM invoices
    WHERE service_package != 'vip'
    GROUP BY service_package";

    $sql_bins = "SELECT status, COUNT(*) AS count FROM bin GROUP BY status";
    $result_bins = $conn->query($sql_bins);
    $bins_data = [];
    if ($result_bins->num_rows > 0) {
        while($row_bins = $result_bins->fetch_assoc()) {
            $bins_data[] = $row_bins;
        }
    }
    

        $result_invoices = $conn->query($sql_invoices);

        $invoices_data = [];
        if ($result_invoices->num_rows > 0) {
            while($row_invoices = $result_invoices->fetch_assoc()) {
                $invoices_data[] = $row_invoices;
            }
        }
    } else {
        echo "لا يمكن العثور على بيانات العميل";
    }
} else {
    // إعادة توجيه المستخدم إلى صفحة تسجيل الدخول إذا لم يكن قد قام بتسجيل الدخول
    header("Location:http://localhost/garbage%20mangement%20project/2-log&sign/2-login%20%20for%20collector/login_COL.html");
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
    <title>crud dashboard</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- CSS3 -->
    <link rel="stylesheet" href="css/custom.css">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="css/all.min.css">
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <!-- Google Material Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Moment.js -->
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/min/moment.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
			<li  class="">
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
                    <a href="http://localhost:8080/garbage%20mangement%20project/collector%20pages/5-single%20time%20orders%20details%20for%20col/" class="dashboard"><i class="fa-solid fa-images pe-1"></i>
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
		   
		   
		   
		   <!--------main-content------------->
           <div class="container card">
    
            <div class="row gy-4">
                <div class="ser-bo col-md-3 ">
                    <div class="services-box text-center border border-1 py-5 ">
                        <div class="serviceMini-box mb-3">
                            <div class="ser-icon">
                              <i class="fa-solid fa-user fs-5 mb-4 main-color "></i>
                            </div>
                            
                            <h6 class="fw-bold ">Name</h6>
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
                              <i class="fa-solid fa-trash-can fs-2 mb-4 main-color"></i>
                            </div>
                            
                            <h6 class="fw-bold main-color">zone</h6>
                        </div>
                        <p class="m-auto text-muted"><?php echo $zone; ?></p>
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
                <div class="container card_satat ">
                <div class="row ">
                    
                    <div class="col-md-8">
                        <canvas id="myChart"></canvas>
                    </div>
                    <div class="col-md-4">
                        <div id="date-time" class=" time text-center p-3 border">
                            <h5 id="current-date"></h5>
                            <h6 id="current-time"></h6>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- باقي العناصر -->
        </div>
    </div>
            </div>
        </div>
		
</div>
</div>


<!----------html code compleate----------->


    </div>
    <div class="xp-breadcrumbbar text-center">
      <h4 class="page-title">collector</h4>
    </div>
  </div>

   <!-- قسم الإحصائيات -->

    
    <!-- Scripts -->
    <script>
    $(document).ready(function() {
        // Toggle Sidebar
        $(".xp-menubar").on('click', function() {
            $('#sidebar').toggleClass('active');
            $('#content').toggleClass('active');
        });

        $(".xp-menubar,.body-overlay").on('click', function() {
            $('#sidebar,.body-overlay').toggleClass('show-nav');
        });

        // عرض التاريخ والوقت
        function updateDateTime() {
            var now = moment();
            $('#current-date').text(now.format('MMMM Do YYYY'));
            $('#current-time').text(now.format('h:mm:ss A'));
        }
        setInterval(updateDateTime, 1000);
        updateDateTime();

        // جلب بيانات الفواتير من PHP
        var invoicesData = <?php echo json_encode($invoices_data); ?>;
        
        // إعداد بيانات الرسم البياني
        var labels = ['Single Collected', 'Single Not Collected', 'VIP Collected', 'VIP Not Collected'];
        var collectedSingle = 0;
        var notCollectedSingle = 0;
        var collectedVIP = 0;
        var notCollectedVIP = 0;

        invoicesData.forEach(function(invoice) {
            if (invoice.service_package === 'one_time') {
                collectedSingle = invoice.collected_count;
                notCollectedSingle = invoice.not_collected_count;
            }
        });

        // تحديث البيانات باستخدام بيانات البنود فقط
var binsData = <?php echo json_encode($bins_data); ?>;

binsData.forEach(function(bin) {
    if (bin.status === 'collected') {
        collectedVIP += bin.count;
    } else if (bin.status === 'not collected') {
        notCollectedVIP += bin.count;
    }
});


        var data = {
            labels: labels,
            datasets: [
                {
                    label: 'Collected',
                    data: [collectedSingle, notCollectedSingle, collectedVIP, notCollectedVIP],
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.2)', // single collected
                        'rgba(255, 99, 132, 0.2)', // single not collected
                        'rgba(75, 192, 192, 0.2)', // vip collected
                        'rgba(255, 99, 132, 0.2)'  // vip not collected
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 99, 132, 1)'
                    ],
                    borderWidth: 1
                }
            ]
        };

        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: data,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
    </script>





  
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





