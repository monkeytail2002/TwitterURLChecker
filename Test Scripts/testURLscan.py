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

#URL hardcoded in the data.  It is a dodgy URL so don't use it outside of this test
#url = url, public = public scan through urlscan.io, tags are set to highlight if phishing or malicious
data = '{"url": "http://landiel.xyz/r.php?t=c&d=89185&l=5548&c=145298", "public": "on","tags": ["phishing", "malicious"]}'

#Posts scan through urlscan.io with headers and data
response = requests.post('https://urlscan.io/api/v1/scan/', headers=headers, data=data)

#Prints api for test purposes, should see a response(200) if successful
scan = response
print(scan)
