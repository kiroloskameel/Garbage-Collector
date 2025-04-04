#include <WiFi.h>
#include <HTTPClient.h>
#include <Ultrasonic.h>

#define TRIG_PIN 15  
#define ECHO_PIN 2  
Ultrasonic ultrasonic(TRIG_PIN, ECHO_PIN);  // Create an Ultrasonic object

#define LED_PIN 13 // تحديد رقم البن الخاص بالـ LED

String URL = "http://192.168.43.86:8080/SENSOR_DATA/SENSOR_SENDING.PHP";

const char* ssid = "abdo";
const char* password = "55555555";
int distance = 0;
int maxRetries = 5;

void setup() {
  Serial.begin(115200);
  pinMode(LED_PIN, OUTPUT); // تعيين البن الخاص بالـ LED كمخرج
  connectWiFi();
}

void loop() {
  if (WiFi.status() != WL_CONNECTED) {
    connectWiFi();
  }

  Load_Ultrasonic_Data();
  String postData = "id=1&distance=" + String(distance);

  bool success = sendPostRequest(postData);

  if (!success) {
    Serial.println("Failed to send data. Retrying...");
    for (int i = 0; i < maxRetries && !success; i++) {
      success = sendPostRequest(postData);
      if (!success) {
        Serial.print("Retry "); Serial.println(i + 1);
        delay(5000); // Wait before retrying
      }
    }
  }

  // إذا فشلت عملية إرسال البيانات، قم بتشغيل الـ LED
  if (!success) {
    digitalWrite(LED_PIN, HIGH);
  } else {
    digitalWrite(LED_PIN, LOW);
  }

  delay(20000); // Wait before the next reading
}

void Load_Ultrasonic_Data() {
  distance = ultrasonic.read(CM); // Read distance in centimeters
  Serial.printf("Distance: %d cm\n", distance);
}

bool sendPostRequest(String postData) {
  HTTPClient http;
  http.begin(URL);
  http.addHeader("Content-Type", "application/x-www-form-urlencoded");

  int httpCode = http.POST(postData);
  String payload = http.getString();

  Serial.print("URL: "); Serial.println(URL);
  Serial.print("Data: "); Serial.println(postData);
  Serial.print("httpCode: "); Serial.println(httpCode);
  Serial.print("payload: "); Serial.println(payload);
  Serial.println("--------------------------------------------------");

  http.end(); // Close connection
  
  // Check for success in the JSON response
  if (httpCode == HTTP_CODE_OK) {
    if (payload.indexOf("\"status\":\"success\"") > -1) {
      return true;
    } else {
      Serial.println("Error in server response");
      return false;
    }
  } else {
    return false;
  }
}

void connectWiFi() {
  WiFi.mode(WIFI_STA);
  
  Serial.println("Connecting to WiFi");
  WiFi.begin(ssid, password);

  int retries = 0;
  const int maxRetries = 20; // Retry up to 20 times

  while (WiFi.status() != WL_CONNECTED && retries < maxRetries) {
    delay(500);
    Serial.print(".");
    retries++;
  }

  if (WiFi.status() == WL_CONNECTED) {
    Serial.print("Connected to: "); Serial.println(ssid);
    Serial.print("IP address: "); Serial.println(WiFi.localIP());
    Serial.print("Signal strength (RSSI): "); Serial.println(WiFi.RSSI());
  } else {
    Serial.println("Failed to connect to WiFi.");
  }
}
