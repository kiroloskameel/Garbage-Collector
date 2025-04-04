<?php
// عرض النص الثابت من متغيرات PHP
$pageTitle = "Divs with Buttons";

include_once('C:\xampp\htdocs\garbage mangement project\0-DataBase\db_connection.php');

// استعلام SQL لاسترداد البيانات من جدول الصناديق
$sql = "SELECT * FROM boxes";
$result = $conn->query($sql);

// إغلاق اتصال قاعدة البيانات
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo $pageTitle; ?></title>
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/all.min.css">
</head>
<body>
  <div class="navbar">
    <div class="navbar-left">
      <img src="logo.png" alt="Logo">
    </div>
    <div class="navbar-right">
      <button id="admin-btn">Admin</button>
      <button id="logout-btn">Logout</button>
    </div>
  </div>
<div class="container">
  <?php
  // عرض البيانات المسترجعة من قاعدة البيانات في صناديق HTML
  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      echo "<div class='box' id='box" . $row["id"] . "'>";
      echo "<i class='" . $row["icon"] . "'></i>";
      echo "<h2>" . $row["name"] . "</h2>";
      echo "<button class='add-btn'>Add Content</button>";
      echo "<button class='view-btn'>View Content</button>";
      echo "<div class='content'></div>";
      echo "</div>";
    }
  } else {
    echo "0 results";
  }
  ?>
</div>

<script src="script.js"></script>
</body>
</html>
