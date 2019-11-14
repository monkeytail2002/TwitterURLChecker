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
data = '{"url":"www.google.com" , "public": "on"}'

#Posts scan through urlscan.io with headers and data
scan = requests.post('https://urlscan.io/api/v1/scan/', headers=headers, data=data)

#decodes scan details.  This should result in the UUID printing to console.
scandetails = scan.content.decode('utf-8')
#Prints scan details.
print(scandetails)
