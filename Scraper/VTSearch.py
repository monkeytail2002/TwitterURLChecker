#!/usr/bin/env python3

import requests
import json
import configparser
import sys
import time


#Read configuration file
config = configparser.ConfigParser()
config.sections()
config.read('/home/anmacdon/Desktop/Scraper/credentials.ini')

#Pull in API keys from configuration file
api = config.get("keys", 'vtapi')

#Take in url from twitter results
twurl = 'www.test.com'

#set up url and search parameters
url = 'https://www.virustotal.com/vtapi/v2/url/scan'
params = {'apikey':api,'url':twurl}

#scan
scan = requests.post(url, data=params)

#decode scan results
scanDetails = scan.content.decode('utf-8')

#parse json object
scanJson = json.loads(scanDetails)

#return search id for report function
vtSearch = scanJson["scan_id"]

time.sleep(120)

#set up url and report parameters
returnUrl = 'https://www.virustotal.com/vtapi/v2/url/report'
returnParams = {'apikey':api,'resource':vtSearch}

results = requests.get(returnUrl, params=returnParams)

vtResult = results.content.decode("utf-8")

scanResult = json.loads(vtResult)

print(scanResult)


