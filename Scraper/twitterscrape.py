#!/usr/bin/env python3

import requests
import json
import configparser
import sys
import base64
import os

#Read configuration file
config = configparser.ConfigParser()
config.sections()
config.read('/home/anmacdon/Desktop/Scraper/credentials.ini')

#Pull in API keys from configuration file
conKey = config.get("keys", 'consumerkey')
conSecret = config.get("keys", 'consumersecret')
accKey = config.get("keys", 'accesstokenkey')
accSecret = config.get("keys", 'accesstokensecret')

#reformat and encode keys
keySecret = '{}:{}'.format(conKey,conSecret).encode('ascii')

#Transform bytes to bytes for printing
b64_encoded_key = base64.b64encode(keySecret)

#Transform from bytes back to unicode
b64_encoded_key = b64_encoded_key.decode('ascii')

#set up URL's for the authentication
baseUrl = 'https://api.twitter.com/'
authUrl = '{}oauth2/token'.format(baseUrl)

#POST headers for authentication
authHeaders = {
    'Authorization':'Basic {}'.format(b64_encoded_key),
    'Content-Type':'application/x-www-form-urlencoded;charset=UTF-8'
    }

#POST data
authData = {
    'grant_type':'client_credentials'
    }

#Request authentication from Twitter
authResp = requests.post(authUrl, headers=authHeaders,data=authData)

#Create bearer token that will give app authenticated access.
accessToken = authResp.json()['access_token']

#Set the headers for the search
searchHeaders = {
    'Authorization':'Bearer {}'.format(accessToken)
    }

#Search parameters including user input from web page
userSearch = sys.argv[1]
searchParams = {
    'q': userSearch,
    'result_type':'recent',
    'count': 4
    }

#Search URL
searchUrl = '{}1.1/search/tweets.json'.format(baseUrl)




#Search response
searchResp = requests.get(searchUrl, headers=searchHeaders, params=searchParams)

#Convert response into readable format
data = json.loads(searchResp.content)

#drill down the Json data lists for the urls
twitterResult = (data['statuses'])#[0])#['entities'])#['urls'])

#function to get the data
def searchTwitter(twitterSearch):
    returnedUrl = []
    for x in twitterSearch:
        for y in x['entities']['urls']:
            returnedUrl.append(y['expanded_url'])
    return returnedUrl

#Set the function to variable
twitUrl = searchTwitter(twitterResult)

#prints variable that returns to php script
print (twitUrl)