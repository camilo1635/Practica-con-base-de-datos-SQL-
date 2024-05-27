// PROGRAMA DENOMINADO programa1.ino
// PARA CAPTURAR DATOS DE LOS SENSORES
// Y ENVIAR A UNA BASE DE DATOS EN UN SERVIDOR WEB.

#include <WiFi.h>
#include "DHT.h"
#define DHTPIN 4     // El número que se le debe asignar a DHTPIN debe ser el número del pin GPIO de la tarjeta ESP32 que se utilice para conectar el sensor DHT22.
#define DHTTYPE DHT11   // DHT 22  (AM2302), AM2321

DHT dht(DHTPIN, DHTTYPE);
const char* ssid     = "Redmi 8";      // SSID
const char* password = "1234567890.";      // Password
const char* host = "192.168.29.252";  // Dirección IP local o remota, del Servidor Web
const int   port = 80;            // Puerto, HTTP es 80 por defecto, cambiar si es necesario.
const int   watchdog = 2000;        // Frecuencia del Watchdog
unsigned long previousMillis = millis(); 

String dato;
String cade;
String humT_min;
String temp_max;
String temp_min;
String estado;
String modo;
String line;
float t_max;
float ht_min;
float t_min;
float valor;

const int sensorLuz = 35;
const int sensorHumSuelo = 34;
int ledazul = 14; // El GPIO5 de la tarjeta ESP32, corresponde al pin D5 identificado físicamente en la tarjeta. Este pin será utilizado para una salida de un LED.
int ledrojo = 13; // Se debe tener en cuenta que el GPIO4 es el pin D4, ver imagen de GPIOs de la tarjeta ESP32. Este pin será utilizado para una salida de un LED para alertas.
int motor = 12; // Se debe tener en cuenta que el GPIO2 es el pin D2, ver imagen de GPIOs de la tarjeta  ESP32. Este pin será utilizado para una salida de un LED para alertas.

 
void setup() {
  pinMode(ledazul, OUTPUT);
  pinMode(motor, OUTPUT);
  pinMode(ledrojo, OUTPUT);
  
  Serial.begin(115200);
  Serial.print("Conectando a...");
  Serial.println(ssid);
  
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  dht.begin();
 
  Serial.println("");
  Serial.println("WiFi conectado");  
  Serial.println("Dirección IP: ");
  Serial.println(WiFi.localIP());
}
 
void loop() {
  unsigned long currentMillis = millis();

  // Reading temperature or humidity takes about 250 milliseconds!
  // Sensor readings may also be up to 2 seconds 'old' (its a very slow sensor)
  float h = dht.readHumidity();
  // Read temperature as Celsius (the default)
  float t = dht.readTemperature();

  Serial.print("Humidity: ");
  Serial.print(h);
  Serial.print(" %\t");
  Serial.print("Temperature: ");
  Serial.print(t);
  Serial.print(" *C ");

  digitalWrite(ledazul, LOW);
  digitalWrite(ledrojo, LOW);
  digitalWrite(motor, LOW);

  //lectura sensor de humedad de suelo
  float sensorValue = analogRead(sensorHumSuelo);
  // Convertir las lecturas a porcentajes
  float humedadSuelo = map((sensorValue), 4095, 0, 0, 100);
  Serial.print("humedadSuelo: ");
  Serial.print(humedadSuelo);

  //lectura sensor de luz
  int luz = analogRead(sensorLuz);
  // Convertir las lecturas a porcentajes
  int iluminacion = map((luz), 0, 4095, 0, 100);
  Serial.print("luz: ");
  Serial.print(iluminacion);

// Primero se consultan los datos maximos de temp y hum

  if ( currentMillis - previousMillis > watchdog ) {
    previousMillis = currentMillis;
    WiFiClient client;
  
    if (!client.connect(host, port)) {
      Serial.println("Conexión falló...");
      return;
    }
 
    String url = "/proceso_eventos/programa5.php";
    // Envío de la solicitud al Servidor
    client.print(String("GET ") + url + " HTTP/1.1\r\n" +
               "Host: " + host + "\r\n" + 
               "Connection: close\r\n\r\n");
    unsigned long timeout = millis();
    while (client.available() == 0) {
      if (millis() - timeout > 5000) {
        Serial.println(">>> Superado tiempo de espera!");
        return;
      }
    }
    
    // Lee respuesta del servidor
    while(client.available()){
      line = client.readStringUntil('\r');
      Serial.print(line);
    }
  //organización de datos, divididos 
      int longitud = line.length();
      int longitud_f = longitud;
      longitud = longitud - 8;
      
      dato = line.substring(longitud,longitud_f);
      cade = "Dato recibido es...";
      cade += dato; 
      Serial.println(cade);

      modo = dato.substring(7,8);
      estado = dato.substring(6,7);
      temp_min = dato.substring(4,6);
      humT_min = dato.substring(2,4);
      temp_max = dato.substring(0,2);

      Serial.print("modo: ");
      Serial.println(modo);
      
      // Lo siguiente se utiliza para pasar la cadena de texto a un flotante, para poder comparar
      char cadena[temp_max.length()+1];
      temp_max.toCharArray(cadena, temp_max.length()+1);
      t_max = atof(cadena);
      
      // Lo siguiente se utiliza para pasar la cadena de texto a un flotante, para poder comparar
      char cadena2[humT_min.length()+1];
      humT_min.toCharArray(cadena2, humT_min.length()+1);
      ht_min = atof(cadena2);

      // Lo siguiente se utiliza para pasar la cadena de texto a un flotante, para poder comparar
      char cadena3[temp_min.length()+1];
      temp_min.toCharArray(cadena3, temp_min.length()+1);
      t_min = atof(cadena3);

      // Lo siguiente se utiliza para pasar la cadena de texto a un flotante, para poder comparar
      char cadena4[estado.length()+1];
      estado.toCharArray(cadena4, estado.length()+1);
      float valor = atof(cadena4);
      
      Serial.print("Valor: ");
      Serial.println(valor);
      
      cade = "Temperatura maxima es...";
      cade += t_max;
      Serial.print(cade);
      
      cade = "Humedad minimo de la tierra es...";
      cade += ht_min;
      Serial.print(cade);

      cade = "Temperatura minima es...";
      cade += t_min;
      Serial.print(cade);

      if (t > t_max)
        {
         Serial.print("ALERTA TEMPERATURA MAXIMA");
         digitalWrite(ledrojo, HIGH);
        }
      if (modo == "1" && (humedadSuelo < ht_min)) {
        Serial.print("ALERTA HUMEDAD MINIMA");
        digitalWrite(motor, HIGH); // activa ventilador
        } else if (modo == "0" && valor == 1.00) {
            digitalWrite(motor, HIGH);
        } else {
            digitalWrite(motor, LOW);
        }
        
       if (t < t_min)
        {
         Serial.print("ALERTA TEMPERATURA MINIMA");
         digitalWrite(ledazul, HIGH);
        }
      delay(2000);
    }
  
// Ahora se guardan los valores medidos en la base de datos

   currentMillis = millis();
   if ( currentMillis - previousMillis > watchdog ) {
    previousMillis = currentMillis;
    WiFiClient client;
  
    if (!client.connect(host, port)) {
      Serial.println("Conexión falló...");
      return;
    }

    String url2 = "/proceso_eventos/programa1.php?humedad_aire=";
    url2 += h;
    url2 += "&temperatura=";
    url2 += t;
    url2 += "&luz=";
    url2 += iluminacion;
    url2 += "&humedad_tierra=";
    url2 += humedadSuelo;

    
    // Envío de la solicitud al Servidor
    client.print(String("POST ") + url2 + " HTTP/1.1\r\n" +
               "Host: " + host + "\r\n" + 
               "Connection: close\r\n\r\n");
    unsigned long timeout2 = millis();
    while (client.available() == 0) {
      if (millis() - timeout2 > 5000) {
        Serial.println(">>> Superado tiempo de espera!");
        client.stop();
        return;
      }
    }
  
    // Lee respuesta del servidor
    while(client.available()){
      line = client.readStringUntil('\r');
      Serial.print(line);
    }
      
      Serial.print("Dato ENVIADO");
      delay(15000);
      
  }
  
}
