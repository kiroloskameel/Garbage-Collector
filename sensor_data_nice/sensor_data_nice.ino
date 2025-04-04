#include <WiFi.h>
#include <HTTPClient.h>
#include <Ultrasonic.h>

#define TRIG_PIN 18  // D19
#define ECHO_PIN 19  // D18
Ultrasonic ultrasonic(TRIG_PIN, ECHO_PIN);  // Create an Ultrasonic object

String URL = "http://192.168.1.242:8080/SENSOR_DATA/SENSOR_SENDING.PHP";

const char* ssid = "WMMAAMEA";
const char* password = "MOSTAFA_$932003$";

// Define RGB LED pins
#define RED_PIN 12    // D12
#define GREEN_PIN 14  // D14
#define BLUE_PIN 27   // D27

int distance = 0;

void setup() {
  Serial.begin(115200);
  connectWiFi();

  // Initialize RGB LED pins
  pinMode(RED_PIN, OUTPUT);
  pinMode(GREEN_PIN, OUTPUT);
  pinMode(BLUE_PIN, OUTPUT);

  // Initially set LED to green
  digitalWrite(RED_PIN, LOW);
  digitalWrite(GREEN_PIN, HIGH);
  digitalWrite(BLUE_PIN, LOW);
}

void loop() {
  if(WiFi.status() != WL_CONNECTED) {
    connectWiFi();
  }

  Load_Ultrasonic_Data();
  String postData = "id=1&distance=" + String(distance);

  HTTPClient http;
  http.begin(URL);
  http.addHeader("Content-Type", "application/x-www-form-urlencoded");

  int httpCode = http.POST(postData);
  String payload = http.getString();

  Serial.print("URL : "); Serial.println(URL);
  Serial.print("Data: "); Serial.println(postData);
  Serial.print("httpCode: "); Serial.println(httpCode);
  Serial.print("payload : "); Serial.println(payload);
  Serial.println("--------------------------------------------------");
  delay(5000);
}

void Load_Ultrasonic_Data() {
  distance = ultrasonic.read(CM); // Read distance in centimeters
  Serial.printf("Distance: %d cm\n", distance);

  if (distance < 20) {
    // Turn LED red
    digitalWrite(RED_PIN, HIGH);
    digitalWrite(GREEN_PIN, LOW);
    digitalWrite(BLUE_PIN, LOW);
  } else {
    // Turn LED green
    digitalWrite(RED_PIN, LOW);
    digitalWrite(GREEN_PIN, HIGH);
    digitalWrite(BLUE_PIN, LOW);
  }
}

void connectWiFi() {
  WiFi.mode(WIFI_OFF);
  delay(1000);
  WiFi.mode(WIFI_STA);
  
  WiFi.begin(ssid, password);
  Serial.println("Connecting to WiFi");
  
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
    
  Serial.print("Connected to: "); Serial.println(ssid);
  Serial.print("IP address: "); Serial.println(WiFi.localIP());
}