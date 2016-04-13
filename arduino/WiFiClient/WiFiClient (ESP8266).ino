#include <ESP8266WiFi.h>

//SSID and password
//Host details
const char* ssid = "MBLAZE-EC315-5879";
const char* password = "80DB481E";

const char* host = "smartpark.hol.es";

//Value of the two sensors used
int p1 = 0;
int p2 = 0;

//Sensor PIN Config
int S1 = 12;
int S2 = 14;

void setup() {
    //Set the baud rate
    Serial.begin(115200);

    //Connect to the WiFi Access Point
    Serial.println();
    Serial.print("Connecting to ");
    Serial.println(ssid);
    WiFi.begin(ssid, password);
    
    //Wait till it is connected to the AP
    while (WiFi.status() != WL_CONNECTED) {
        delay(500);
        Serial.print(".");
    }

    //Display the IP alloted to the ESP module
    Serial.println();
    Serial.println("WiFi connected");  
    Serial.println("IP address: ");
    Serial.println(WiFi.localIP());
    
    //Set the Sensors to input mode
    pinMode(S1, 0);
    pinMode(S2, 0);
}

void loop() {
    //Dealy to avoid overhead
    delay(3000);
    
    //Read and display the sensor readings
    int tp1 = digitalRead(S1);
    int tp2 = digitalRead(S2);
    Serial.println((String)" p1 = " + (String)tp1);
    Serial.println((String)" p2 = " + (String)tp2);
    
    //Update sensor readings if changed and continue
    if(tp1 == p1 && tp2 == p2) {
        return;
    } else {
        p1 = tp1;
        p2 = tp2;
    }
        
    // Prepare the URL for the request based on sensor values
    String url[2] { " ", " " };
    url[0] = (String)"/" + (String)(p1 == 1 ? "depart.php" : "arrive.php") + (String)"?pid=1";
    url[1] = (String)"/" + (String)(p2 == 1 ? "depart.php" : "arrive.php") + (String)"?pid=2";
        
    for(int i=0; i<2; i++) {
        // Use WiFiClient class to create TCP connections
        WiFiClient client;
        const int httpPort = 80;
        if (!client.connect(host, httpPort)) {
            Serial.println("connection failed");
            return;
        }
        
        //Request to server
        Serial.print("Requesting URL: ");
        Serial.println(url[i]);
        client.print(
            String("GET ") + url[i] + " HTTP/1.1\r\n" +
            "Host: " + host + "\r\n\r\n"
        );
        
        //Read the server response and display it on the serial monitor
        while(!client.available()) { delay(500); }
        while(client.available()){
        String line = client.readStringUntil('\r');
        Serial.print(line);
        }
    }
}

