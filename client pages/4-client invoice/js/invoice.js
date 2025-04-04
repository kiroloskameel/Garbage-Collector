document.addEventListener('DOMContentLoaded', function() {
  var name = "<?php echo isset($_SESSION['name']) ? $_SESSION['name'] : ''; ?>";
  var email = "<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''; ?>";
  document.getElementById('name').value = name;
  document.getElementById('email').value = email;
});

$(document).ready(function(){
  $("#service_package").change(function(){
      if($(this).val() == "regular") {
          $("#collection_days").show();
          $("#collection_date").hide();
      } else if($(this).val() == "one_time") {
          $("#collection_days").hide();
          $("#collection_date").show();
          $("#package_expiry_date").hide(); // إخفاء حقل Package Expiry Date في حالة اختيار الباقة One-Time Special Service
      } else {
          $("#collection_days").hide();
          $("#collection_date").hide();
          $("#package_expiry_date").show(); // إظهار حقل Package Expiry Date في حالة اختيار الباقة غير One-Time Special Service
      }

      var packagePrice = 0;
      var expiryDate = "";

      if($(this).val() == "regular") {
          packagePrice = 500;
      } else if($(this).val() == "vip") {
          packagePrice = 1200;
      } else if($(this).val() == "one_time") {
          packagePrice = 300;
      }

      $("#package_price_value").text("EGP" + packagePrice);
      $("#package_price").show();

      if($(this).val() != "" && $(this).val() != "one_time") { // تحقق من أن الباقة ليست "One-Time Special Service" قبل إظهار حقل Package Expiry Date
          var registrationDate = new Date();
          var expiryDate = new Date(registrationDate.setDate(registrationDate.getDate() + 30)); // Add 30 days
          var formattedExpiryDate = formatDate(expiryDate);
          $("#package_expiry_date_value").text(formattedExpiryDate);
          $("#package_expiry_date").show();
      } else {
          $("#package_expiry_date").hide(); // إخفاء حقل Package Expiry Date في حالة اختيار الباقة One-Time Special Service
      }
  });
});

// Function to format date as desired (e.g., "9/5/2024   SUNDAY")
function formatDate(date) {
    var days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    var dayName = days[date.getDay()];
    var formattedDate = date.getDate() + '/' + (date.getMonth() + 1) + '/' + date.getFullYear() + '   ' + dayName;
    return formattedDate;
}


const apiKey = 'AIzaSyClNvqSO4OoUvCcbmLK_yI-SBkIHBT_Jpg'; 
  
const searchInput = document.getElementById('search-input');
const autocomplete = new google.maps.places.Autocomplete(searchInput);
    let map; 
  
    function initMap() {
      map = new google.maps.Map(mapContainer, {
        center: { lat: -34.397, lng: 150.644 }, // Default center coordinates
        zoom: 8
      });
  
      var autocomplete;
      autocomplete = new google.maps.places.Autocomplete(searchInput, {
        types: ['geocode']  // Optional: Specify address types to filter suggestions
      });
  
      google.maps.event.addListener(autocomplete, 'place_changed', function() {
        var place = autocomplete.getPlace();
        fillAddressFields(place);
      });
    }
  
    function fillAddressFields(place) {
      // Check if place has address components
      if (place.address_components) {
        // Loop through each address component
        place.address_components.forEach(function(component) {
          // Check types to determine which field to fill
          switch(component.types[0]) {
            case 'administrative_area_level_1': // Zone
              document.getElementById('Zone').value = component.long_name;
              break;
            case 'route': // Street
              document.getElementById('street').value = component.long_name;
              break;
            case 'street_number': // House Number
              document.getElementById('house_number').value = component.long_name;
              break;
            default:
              break;
          }
        });
      }
    }


