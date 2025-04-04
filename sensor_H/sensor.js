window.onload = function() {
    // جلب البيانات عند تحميل الصفحة
    fetchData();
};

function fetchData() {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById("sensorData").innerHTML = xhr.responseText;
        }
    };
    xhr.open("GET", "http://192.168.0.105/", true);
    xhr.send();
}
