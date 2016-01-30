
#include <ESP8266WiFi.h>

const char* ssid = "MBLAZE-EC315-5879";
const char* password = "80DB481E";

const char* host = "smartpark.hol.es";

int p1 = 0;
int p2 = 0;

void setup() {
  Serial.begin(115200);
  delay(10);


  Serial.println();
  Serial.println();
  Serial.print("Connecting to ");
  Serial.println(ssid);
  
  WiFi.begin(ssid, password);
  
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }

  Serial.println("");
  Serial.println("WiFi connected");  
  Serial.println("IP address: ");
  Serial.println(WiFi.localIP());
  
  pinMode(14, 0);
  pinMode(12, 0);
}

void loop() {
  delay(3000);
  
  int tp1 = digitalRead(14);
  int tp2 = digitalRead(12);
  
  Serial.println((String)" p1 = " + (String)tp1);
  Serial.println((String)" p2 = " + (String)tp2);
  
  if(tp1 == p1 && tp2 == p2) {
    return;
  } else {
    p1 = tp1;
    p2 = tp2;
  }
  
  Serial.println(p1);
  Serial.println(p2);

  Serial.print("connecting to ");
  Serial.println(host);
    
  // We now create a URI for the request
    
  String url[2] { " ", " " };
  url[0] = (String)"/" + (String)(p1 == 1 ? "depart.php" : "arrive.php") + (String)"?pid=1";
  url[1] = (String)"/" + (String)(p2 == 1 ? "depart.php" : "arrive.php") + (String)"?pid=2";
    
  // This will send the request to the server
  for(int i=0; i<2; i++) {
    // Use WiFiClient class to create TCP connections
    WiFiClient client;
    const int httpPort = 80;
    if (!client.connect(host, httpPort)) {
      Serial.println("connection failed");
      return;
    }
    
    Serial.print("Requesting URL: ");
    Serial.println(url[i]);
    
    client.print(String("GET ") + url[i] + " HTTP/1.1\r\n" +
                 "Host: " + host + "\r\n\r\n");
    
    // Read all the lines of the reply from server and print them to Serial
    while(!client.available()) { delay(500); }
    while(client.available()){
      String line = client.readStringUntil('\r');
      Serial.print(line);
    }
  }
  
  Serial.println();
  Serial.println("closing connection");
}

