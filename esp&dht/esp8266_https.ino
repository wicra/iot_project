#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include "DHT.h"
#include <Arduino.h>
#include <WiFiClientSecureBearSSL.h>

/************ État global (vous n'avez pas besoin de modifier cela!) ******************/
#define DHTTYPE DHT11   // Capteur DHT 11
#define DHTPIN 2         // Broche à laquelle le capteur est connecté
DHT dht(DHTPIN, DHTTYPE); // Déclaration du capteur

#ifndef STASSID
#define STASSID "wifi-snir-02"
#define STAPSK "snir456baggio"
#endif

String HOST_NAME = "https://192.168.0.0"; // REMPLACEZ PAR L'ADRESSE IP DE VOTRE PC
String PHP_FILE_NAME   = "/iot_projet/db/recolte_donne.php";  // REMPLACEZ PAR LE NOM DE VOTRE FICHIER PHP
String tempQuery = "?temperature=15";   // Valeur de test 15 pour l'exemple

void setup() {

    Serial.begin(115200);

    Serial.println();
    Serial.println();
    Serial.println();

    // Connexion au Wi-Fi
    WiFi.mode(WIFI_STA);
    WiFi.begin(STASSID, STAPSK);

    while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
    }
    Serial.println("");
    Serial.print("Connecté! Adresse IP: ");
    Serial.println(WiFi.localIP());
}

void loop() {

    float temperature = dht.readTemperature(); // Lecture de la température en degrés Celsius
    Serial.print("Température:");
    Serial.println(temperature);

    float humidite = dht.readHumidity(); // Lecture de l'humidité en %
    Serial.print("Humidité:");
    Serial.println(humidite);

    delay(10000);
    String valeurT = "?temperature=" + String(temperature); // Stocke uniquement la température
    String valeurH = "&humidite=" + String(humidite); // Stocke uniquement l'humidité

    String server = HOST_NAME + PHP_FILE_NAME + valeurT + valeurH;
    // Attendre la connexion Wi-Fi
    if ((WiFi.status() == WL_CONNECTED)) {

        std::unique_ptr<BearSSL::WiFiClientSecure>client(new BearSSL::WiFiClientSecure);

        // Ignorer la validation du certificat SSL
        client->setInsecure();
        
        // Créer une instance HTTPClient
        HTTPClient https;
        
        // Initialisation d'une communication HTTPS en utilisant le client sécurisé
        Serial.print("[HTTPS] début...\n");
        if (https.begin(*client, server)) {  // HTTPS
            Serial.print("[HTTPS] GET...\n");
            // Démarrez la connexion et envoyez l'en-tête HTTP
            int httpCode = https.GET();
            // httpCode sera négatif en cas d'erreur
            if (httpCode > 0) {
                // L'en-tête HTTP a été envoyé et la réponse du serveur a été traitée
                Serial.printf("[HTTPS] GET... code: %d\n", httpCode);
                // Fichier trouvé sur le serveur
                if (httpCode == HTTP_CODE_OK || httpCode == HTTP_CODE_MOVED_PERMANENTLY) {
                    String payload = https.getString();
                    Serial.println(payload);
                }
            } 
            else {
            Serial.printf("[HTTPS] GET... échec, erreur: %s\n", https.errorToString(httpCode).c_str());
            }

            https.end();
        } 
        else {
            Serial.printf("[HTTPS] Impossible de se connecter\n");
        }
    }
    Serial.println();
    Serial.println("En attente de 2 minutes avant le prochain cycle...");
    delay(10000);
}
