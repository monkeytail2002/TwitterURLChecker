#!/usr/bin/python
import configparser
import requests


#Read configuration file for API key
config = configparser.ConfigParser()
config.sections()

config.read('/var/www/credentials.ini')

api = config.get("keys", 'urlAPI')

#Set headers for api usage
headers = {
    'Content-Type': 'application/json',
    'API-Key': api,
}


#Posts scan through urlscan.io with headers and data
response = requests.get('https://urlscan.io/api/v1/result/698f3d3d-b9af-493a-b01d-34e6a65c0912')

#Prints api for test purposes, should see a response(200) if successful
#scan = response

#Returns the results in a very very big JSON file.
scan = response.content.decode("utf-8")

print(scan)
