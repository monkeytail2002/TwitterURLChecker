#!/user/bin/python
import configparser
import requests
import json
import time
#read config file for API key
config = configparser.ConfigParser()
config.sections()
config.read('../TwitterScrape/credentials.ini')

api = config.get("keys", 'urlapi')

#Set headers and data for api usage
headers = {
	'Content-Type': 'application/json',
	'API-Key': api,
}

data = '{"url":"http://bestravelways.com/P1C0uUXVxpq.jsv?byuIqrLNbdSJ=PszfbaUhtspk18d9brJ032bju01farr0116612056ozcw2fio", "public": "on"}'


#sumbits scan and decodes the details#
scan = requests.post('https://urlscan.io/api/v1/scan/', headers=headers, data=data)

scandetails = scan.content.decode('utf-8')

#parse the returned json details
scanjson = json.loads(scandetails)

#test details
#print(scanjson["uuid"])
uuid = scanjson["uuid"]

#print(uuid)
base_url = "https://urlscan.io/api/v1/result/" + str(uuid)

time.sleep(60)
response = requests.get(base_url)
print(response)

responsedetails = response.content.decode('utf-8')

print(responsedetails)
