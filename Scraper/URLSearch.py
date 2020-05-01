#!/usr/bin/env python3

import requests
import json
import configparser
import sys
import time

#Read config file
config = configparser.ConfigParser()
config.sections()
config.read('/home/anmacdon/Desktop/Scraper/credentials.ini')

#Pull in API keys from configuration file
api = config.get("keys", 'urlApi')

#Take in the url from the website
twUrl = sys.argv[1]

#Set headers for the api
headers = {
    'content-Type':'application/json',
    'API-Key': api,
    }

#Set up tags for the URLScan.io search. url = twitter urls.
#public = public scan through URLScan.io.
data = '{"url":"%s", "public":"on"}' % twUrl

#Posts scan through URLScan.io with headers and data.
scan = requests.post('https://urlscan.io/api/v1/scan/', headers=headers, data=data)

#Decode the scan and returns is as a readable obect
scanDetails =  scan.content.decode('utf-8')

#load into json
scanJson = json.loads(scanDetails)

#Set scan ID to a variable for getting the report
searchId = scanJson['uuid']

#Set sleep timer as this can take several minutes to complete
time.sleep(180)

#Set report url to include scan ID
baseUrl = "https://urlscan.io/api/v1/result/" + str(searchId)

#Get the response
response = requests.get(baseUrl)

#Decode the results response
urlResponse = response.content.decode("utf-8")

#load the results into a json object
urlJson = json.loads(urlResponse)

print(urlJson)