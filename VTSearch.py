#!/usr/bin/env python3.7

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
api = config.get("keys", 'vtApi')

#Take in url from Twitter results
twUrl = sys.argv[1]

#set up URL and search params
url = 'https://www.virustotal.com/vtapi/v2/url/scan'
params = {'apikey':api,'url':twUrl}

#scan request
scan = requests.post(url, data=params)

#decode scan results
scanDetails = scan.content.decode('utf-8')

#parse json object
scanJson = json.loads(scanDetails)

#Timer set for sandbox to run scan
time.sleep(60)

#Return search ID for report function
vtSearch = scanJson["scan_id"]

#Set up url and report parameters
returnUrl = 'https://www.virustotal.com/vtapi/v2/url/report'
returnParams = {'apikey':api,'resource':vtSearch}

#Get results
results = requests.get(returnUrl, params=returnParams)

#decode results into utf-8
vtResult = results.content.decode("utf-8")

#Load results into json
scanResults = json.loads(vtResult)

#Print results to return them to the website
print(scanResults)