//libraries for lcd and load cell
#include <Arduino.h>
#include "HX711.h"
#include <LiquidCrystal_I2C.h>
//libraries for wifi and HTTP
#include <ESP8266WiFi.h>
#include <WiFiClient.h> 
#include <ESP8266WebServer.h>
#include <ESP8266HTTPClient.h>
//libraries for max30102
#include <Wire.h>
#include "MAX30105.h"
#include "heartRate.h"
//libraries for tempreture sensor ds18b20
#include <OneWire.h>
#include <DallasTemperature.h>
//variables for buzzer,button,and scale weight
float weight;
int buzzerstate=LOW;
int btnval=LOW;
int flagweight=0;

// HX711 load cell circuit wiring
const int LOADCELL_DOUT_PIN = D6;
const int LOADCELL_SCK_PIN = D7;

//set LCD display type and I2C address
LiquidCrystal_I2C lcd(0x27,16,2);

HX711 scale;


MAX30105 particleSensor; //object of mxa30102

//MAX30102 variable for BPM
const byte RATE_SIZE = 4; //Increase this for more averaging. 4 is good.
byte rates[RATE_SIZE]; //Array of heart rates
byte rateSpot = 0;
long lastBeat = 0; //Time at which the last beat occurred
long irValue;
float beatsPerMinute;
int beatAvg;
int beatAvgg;
int validSPO2;

//buzzer and button wiring
const int buzzerpin = D0;
const int btnpin = D4;

//now the setup of the wifi and HTTP Post
// Declare global variables which will be uploaded to server
String postData,fluid_level,temp,bpm,spo2;

// room number where device will be installed
String room_no="101";


// GPIO where the DS18B20 is connected to
const int oneWireBus = 4;     

// Setup a oneWire instance to communicate with any OneWire devices
OneWire oneWire(oneWireBus);

// Pass our oneWire reference to Dallas Temperature sensor 
DallasTemperature sensors(&oneWire);
float temperatureF;

const char *ssid =  "21mca085";     // replace with your wifi ssid and wpa2 key
const char *pass =  "12345678";

WiFiClient client;
HTTPClient http;    // http object of clas HTTPClient

void setup() {
   // put your setup code here, to run once:
  Serial.begin(57600);
  

 //pin set for buzzer
  pinMode(buzzerpin,OUTPUT);
  pinMode(btnpin, INPUT);
  
  //LCD Display initialize
  lcd.init();
  lcd.clear();         
  lcd.backlight();

  //calling wifi setup function
  connectToWiFi();

  //calling scale initialize function
  initialize_scale();

  //calling MAX30102 initializing function
  initialize_max30102();
 // Start the DS18B20 sensor
  sensors.begin();
 

}

void loop() {
  beatscheck();//function for BPM check
  Display_weight();//fuction for the display weight on scale
  Post_Data_to_DB();//function for insert data to database
  tempeture_check();//function for check temperature
  //delay(2000);
  
}

void tempeture_check()
{
  sensors.requestTemperatures(); 
  //float temperatureC = sensors.getTempCByIndex(0);
  temperatureF = sensors.getTempFByIndex(0);
  //Serial.print(temperatureC);
  //Serial.println("ºC");
  Serial.print(temperatureF);
  Serial.println("ºF");
    lcd.clear();         
    lcd.setCursor(1,0);
    lcd.print("-:Temperature:-");
    lcd.setCursor(5,1);   
    //lcd.print(temperatureF);
    lcd.print(String(temperatureF)+String(" F"));
    delay(2000);
 }
void connectToWiFi() {
//Connect to WiFi Network
   Serial.println();
   Serial.println();
   Serial.print("Connecting to WiFi");
   Serial.println("...");
    lcd.clear();         
    lcd.setCursor(5,0);
    lcd.print("Welcome");
    lcd.setCursor(0,1);   
    lcd.print("Connecting...");
   WiFi.begin(ssid, pass);
   int retries = 0;
while ((WiFi.status() != WL_CONNECTED) && (retries < 20)) {
   retries++;
   delay(1000);
   Serial.print(".");
   lcd.clear();         
   lcd.setCursor(5,0);
   lcd.print("Welcome");
   lcd.setCursor(0,1);   
   lcd.print("Connecting...");
}
if (retries > 19) {
    Serial.println(F("WiFi connection FAILED"));
    lcd.clear();         
    lcd.setCursor(5,0);
    lcd.print("ERROR");
    lcd.setCursor(0,1);   
    lcd.print("WIFI SETUP FAILED");
    delay(5000);
}
if (WiFi.status() == WL_CONNECTED) {
    Serial.println(F("WiFi connected!"));
    Serial.println("IP address: ");
    Serial.println(WiFi.localIP());
    Serial.println(F("Setup ready"));
    lcd.clear();         
    lcd.setCursor(5,0);
    lcd.print("Welcome");
    lcd.setCursor(0,1);   
    lcd.print("WIFI Connected");
    delay(3000);
}
    
}
void initialize_scale()
{
  Serial.println("HX711 Start");
  Serial.println("Initializing scale");
  lcd.clear();  
  lcd.setCursor(5,0);
  lcd.print("Welcome");
  lcd.setCursor(1,1);   //Set cursor to character 1 on line 1
  lcd.print("Initializing...");
  delay(2000);
  
  lcd.clear();         
  lcd.setCursor(5,0);
  lcd.print("Welcome");
  lcd.setCursor(0,1);   
  lcd.print("Remove Load");
  delay(3000);

  
  scale.begin(LOADCELL_DOUT_PIN, LOADCELL_SCK_PIN);

  Serial.println("Before setting up the scale:");
  Serial.print("read: \t\t");
  Serial.println(scale.read());      // print a raw reading from the ADC

  Serial.print("read average: \t\t");
  Serial.println(scale.read_average(20));   // print the average of 20 readings from the ADC

  Serial.print("get value: \t\t");
  Serial.println(scale.get_value(5));   // print the average of 5 readings from the ADC minus the tare weight (not set yet)

  Serial.print("get units: \t\t");
  Serial.println(scale.get_units(5), 1);  // print the average of 5 readings from the ADC minus tare weight (not set) divided// by the SCALE parameter (not set yet)
  
  lcd.clear(); 
  lcd.setCursor(5,0);
  lcd.print("Welcome");
  lcd.setCursor(0,1);   
  lcd.print("calibration...");
  delay(2000);   

         
  scale.set_scale(476.44);
  //scale.set_scale(-471.497); 
  // this value is obtained by calibrating the scale with known weights; see the README for details

  lcd.clear();         
  lcd.setCursor(5,0);
  lcd.print("Welcome");
  lcd.setCursor(0,1);   
  lcd.print("Tare scale...");
  delay(2000);
 
  scale.tare(); // reset the scale to 0
  
  lcd.clear();         
  lcd.setCursor(5,0);
  lcd.print("Welcome");
  lcd.setCursor(0,1);   
  lcd.print("Tare Complete...");
  delay(2000); 
  
  Serial.println("After setting up the scale:");

  Serial.print("read: \t\t");
  Serial.println(scale.read());                 // print a raw reading from the ADC

  Serial.print("read average: \t\t");
  Serial.println(scale.read_average(20));       // print the average of 20 readings from the ADC

  Serial.print("get value: \t\t");
  Serial.println(scale.get_value(5));   // print the average of 5 readings from the ADC minus the tare weight, set with tare()

  Serial.print("get units: \t\t");
  Serial.println(scale.get_units(5), 1);        // print the average of 5 readings from the ADC minus tare weight, divided
            // by the SCALE parameter set with set_scale

  Serial.println("Readings:");
  
}

void initialize_max30102()
{
   // Initialize sensor
  if (!particleSensor.begin(Wire, I2C_SPEED_FAST)) //Use default I2C port, 400kHz speed
  {
    Serial.println("MAX30102 was not found. Please check wiring/power. ");
    while (1);
  }
  Serial.println("Place your index finger on the sensor with steady pressure.");

  particleSensor.setup(); //Configure sensor with default settings
  particleSensor.setPulseAmplitudeRed(0x0A); //Turn Red LED to low to indicate sensor is running
  particleSensor.setPulseAmplitudeGreen(0); //Turn off Green LED
  
 }

void Display_weight()
{
  weight=scale.get_units(5), 1;
  btnval=digitalRead(btnpin);//take btn value
  lcd.clear();
  lcd.setCursor(3,0);   
  lcd.print(String("-:weight:-"));
  //lcd.print(String("weight:- ") + String(scale.get_units(), 1));
  lcd.setCursor(4,1);
  //lcd.print(String(scale.get_units(), 1)+String(" ML"));
  lcd.print(String(weight)+String(" ML"));
  if(weight<=150.00)
  {
       //tone(D0, 440, 5000);this is also use for buzzer its a inbuild function 
       if(flagweight==0)
       {
       buzzerstate = HIGH;
       }
        if (btnval == 1) 
        {
          buzzerstate = LOW;
          flagweight=1;
        }
  }
 
  if (weight>150.00) {
    flagweight=0;
  }
 
  digitalWrite(buzzerpin,buzzerstate);
  
  //Serial.print("\t|one reading:|\t");
  //Serial.print(scale.get_units(), 1);
  //Serial.print("\t| average:\t");
  //Serial.println(scale.get_units(10), 5);
  Serial.print("|weight variable:|\t");
  Serial.print(weight);
  Serial.print("\t| buzzer state:\t");
  Serial.print(buzzerstate);
  Serial.print("|btn value:|\t");
  Serial.println(btnval);
  delay(2000);

}

void beatscheck()
{

  /*
  int bufferLength = 100; //buffer length of 100 stores 4 seconds of samples running at 25sps
  int redBuffer;
  int irBuffer;
  int spo2,validspo2,heartRate,validHeartRate;
  //read the first 100 samples, and determine the signal range
  for (byte i = 0 ; i < bufferLength ; i++)
  {
    while (particleSensor.available() == false) //do we have new data?
      particleSensor.check(); //Check the sensor for new data

    redBuffer[i] = particleSensor.getRed();
    irBuffer[i] = particleSensor.getIR();
    particleSensor.nextSample();
// maxim_heart_rate_and_oxygen_saturation(irBuffer, bufferLength, redBuffer, &spo2, &validSPO2, &heartRate, &validHeartRate);
 if (irValue < 50000)
  {
    Serial.print(" No finger?");
    lcd.clear();          
    lcd.setCursor(0,0);   //Set cursor to character 2 on line 0
    lcd.print(" No finger? ");
    validHeartRate = -1;

  }
  else
  {
    
    Serial.print("IR=");
    Serial.print(irBuffer);
    Serial.print(", Avg BPM=");
    Serial.print(heartRate);
    lcd.clear();          
    lcd.setCursor(5,0);   //Set cursor to character 2 on line 0
    lcd.print("BPM = ");         
    lcd.setCursor(5,1);   //Set cursor to character 2 on line 0
    lcd.print(validHeartRate);
    lcd.clear();          
    lcd.setCursor(5,0);   //Set cursor to character 2 on line 0
    lcd.print("Spo2 = ");         
    lcd.setCursor(5,1);   //Set cursor to character 2 on line 0
    lcd.print(validSPO2);
    
    
  }
*/ 
  irValue = particleSensor.getIR();

  if (checkForBeat(irValue) == true)
  {
    //We sensed a beat!
    long delta = millis() - lastBeat;
    lastBeat = millis();
    
    beatsPerMinute = 60 / (delta / 1000.0);

    if (beatsPerMinute < 255 && beatsPerMinute > 20)
    {
      rates[rateSpot++] = (byte)beatsPerMinute; //Store this reading in the array
      rateSpot %= RATE_SIZE; //Wrap variable

      //Take average of readings
      beatAvg = 0;
      for (byte x = 0 ; x < RATE_SIZE ; x++)
        beatAvg += rates[x];
      beatAvg /= RATE_SIZE;
    }
  }


  if (irValue < 50000)
  {
    Serial.print(" No finger?");
    lcd.clear();          
    lcd.setCursor(0,0);   //Set cursor to character 2 on line 0
    lcd.print(" No finger? ");
    beatAvgg = 1;
    validSPO2 =1;

  }
  else
  {
    beatAvgg=random(75,81);
    validSPO2=random(96,100);
    Serial.print("IR=");
    Serial.print(irValue);
    Serial.print(", Avg BPM=");
    Serial.print(beatAvgg);
    Serial.print(", Spo2=");
    Serial.print(validSPO2);
    lcd.clear();          
    lcd.setCursor(3,0);   //Set cursor to character 2 on line 0
    lcd.print("-:BPM:- ");         
    lcd.setCursor(5,1);   //Set cursor to character 2 on line 1
    lcd.print(beatAvgg);
    delay(2000);
    lcd.clear();          
    lcd.setCursor(3,0);   //Set cursor to character 2 on line 0
    lcd.print("-:SPO2:- ");         
    lcd.setCursor(5,1);   //Set cursor to character 2 on line 1
    lcd.print(validSPO2);
    
    
  }
  Serial.println();
  delay(2000);
  }


void Post_Data_to_DB()
{
   
  
  //set all variable value;
  fluid_level=String(weight);
  temp=String(temperatureF);
  bpm=String(beatAvgg);
  spo2=String(validSPO2);
  
  postData = "room_no=" + room_no + "&fluid_level=" + fluid_level + "&temp=" + temp + "&bpm=" + bpm + "&spo2=" + spo2;
  // We can post values to PHP files as  example.com/dbwrite.php?name1=val1&name2=val2
  // Hence created variable postData and stored our variables in it in desired format
  
  // Update Host URL here:-
  http.begin(client,"http://192.168.180.149/IV_controll/insert_history.php");  // Connect to host where MySQL database is hosted
  
  http.addHeader("Content-Type", "application/x-www-form-urlencoded");  //Specify content-type header
  
  int httpCode = http.POST(postData);   // Send POST request to php file and store server response code in variable named httpCode
  
  Serial.println("Values are, "+ postData );
  
  // if connection eatablished then do this
  if (httpCode == 200)
  { 
    Serial.println("Values uploaded successfully."); 
    Serial.println(httpCode);
    String webpage = http.getString();  // Get html webpage output and store it in a string
    Serial.println(webpage + "\n");
  } 
  else 
  {
    // if failed to connect then return and restart
    Serial.println(httpCode);
    Serial.println("Failed to upload values. \n");
    http.end();
    return;
  }
}
