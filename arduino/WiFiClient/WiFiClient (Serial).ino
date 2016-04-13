//Invalid parking indicator led pin-out
int GREEN[2] = {13, 2};
int RED[2] = {12, 4};

//Sensors pin-out
int SENSOR_1 = A0;
int SENSOR_2 = A1;

//WiFi credentials
String ssid = "Simulator Wifi";
String password = "";

//Server details
String host = "karthik.esy.es";
const int httpPort = 80;

//Value of the two sensors used
int p1 = 0;
int p2 = 0;

void setup() {
	//Set the mode of the leds to OUTPUT
	pinMode(GREEN[0], OUTPUT);
	pinMode(RED[0], OUTPUT);
	pinMode(GREEN[1], OUTPUT);
	pinMode(RED[1], OUTPUT);
  
  
    digitalWrite(GREEN[0], HIGH);
    digitalWrite(GREEN[1], HIGH);
	
	//Set the mode of the sensors to INPUT
	pinMode(SENSOR_1, INPUT);
	pinMode(SENSOR_2, INPUT);
	
	//WiFi Connections
	//Step 1 : Serial Connection to ESP8266
	Serial.begin(115200);
	Serial.println("AT");
	delay(50);
	
	//Step 2 : Connect to the AP
	Serial.println("AT+CWJAP=\"" + ssid + "\",\"" + password + "\"");
	delay(50);
}

void loop() {
	int tp1 = digitalRead(SENSOR_1);
	int tp2 = digitalRead(SENSOR_2);
  
    /*digitalWrite(GREEN[0], !p1);
    digitalWrite(GREEN[1], !p2);
    digitalWrite(RED[0], p1);
    digitalWrite(RED[1], p2);*/
	
	if (tp1 == p1 && tp2 == p2) {
      return;
	} else {
      p1 = tp1;
      p2 = tp2;
    }
        
    // Prepare the URL for the request based on sensor values
    String url[2] { " ", " " };
    url[0] = (String)"/" + (String)(p1 == 0 ? "depart.php" : "arrive.php") + (String)"?pid=1";
    url[1] = (String)"/" + (String)(p2 == 0 ? "depart.php" : "arrive.php") + (String)"?pid=2";
      
	for(int i = 0; i < 2; i++) {
      //STEP 3: Open a TCP Connection with the server
      Serial.println("AT+CIPSTART=\"TCP\",\"" + host + "\"," + httpPort);
      delay(50);

      //STEP 4: Construct the request packet
      String httpPacket = "GET " + url[i] + " HTTP/1.1\r\nHost: " + host + "\r\n\r\n";
      int length = httpPacket.length();

      //STEP 5: Send Message length
      Serial.print("AT+CIPSEND=");
      Serial.println(length);
      delay(50);

      //STEP 6: Send the packet
      Serial.print(httpPacket);
      delay(50); 

      //STEP 7: Wait till the response reaches and find required pattern
      while(!Serial.available()) delay(5);
      while(Serial.available()) { 
        if(Serial.find("invalid parking")) {
          digitalWrite(GREEN[i], LOW);
          digitalWrite(RED[i], HIGH);
          Serial.flush();
          break;
        }else if ((p1 == 0 && i == 0) || (p2 == 0 && i == 1)) {
          digitalWrite(GREEN[i], HIGH);
          digitalWrite(RED[i], LOW);          
          Serial.flush();
          break;
        } else if (Serial.find("valid parking")) {
          digitalWrite(GREEN[i], HIGH);
          digitalWrite(RED[i], LOW);
          Serial.flush();
          break;
        } 
      }
	}
}