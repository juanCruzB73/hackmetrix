import urllib.parse
import requests
import json
import urllib.request
import httpx
import asyncio

#DEFINE THE URL
url = "https://jsonplaceholder.typicode.com/posts"

#SEND GET REQUEST
'''response=requests.get(url)

#CHECK IF THE REQUEST WAS SUCCESFUL
if (response.status_code==200):
    print("success")
    #PRINT THE JSON RESPONSE CONTENT
    data = response.json()
    print(data)
else:
    print(f"Failed to retrive data. Status code: {response.status_code}")'''

'''data = {
    "title": "foo",
    "body": "bar",
    "userId": 1
}

#SEND POST REQUEST
response= requests.post(url,data)

#CHECK IF REQUEST WAS SUCCESFUL
if(response.status_code==201):
    print("Data posted succesfully")
    print(response.json())
else:
    print(f"Failed to post data. Status code: {response.status_code}")
'''

#SEND GET REQUEST WITH URLLIB.REQUEST
'''with urllib.request.urlopen(url) as response:
    #READ THE RESPONSE AND DECODE IT
    data=response.read().decode('utf-8')
    #PARSE JSON RESPONSE
    json_data = json.loads(data)
    print(json_data)'''

'''data = {
    "title": "foo",
    "body": "bar",
    "userId": 1
}

#DECODE DATA AS FORM-ENCODED
encode_data = urllib.parse.urlencode(data).encode()
#CREATE THE REQUEST OBJECT
req=urllib.request.Request(url,data=encode_data,method="POST")
#SEND THE REQUEST
with urllib.request.urlopen(req) as response:
    #READ THE RESPONSE AND DECODE
    response_data = response.read().decode('utf-8')
    json_response=json.loads(response_data)
    print(json_response)'''

'''#SEND GET REQUEST
response = httpx.get(url)

#CHECK THE STATUS CODE AND PARSE THE RESPONSE
if response.status_code == 200:
    print("succes")
    print(response.json())
else:
    print(f"Failed to retrieve data. Status code: {response.status_code}")'''

async def fetch_data():
    async with httpx.AsyncClient() as client:
        response=await client.get(url)
        if(response.status_code==200):
            print("succes")
            print(response.json())
        else:
            print(f"Failed to retrieve data. Status code: {response.status_code}")

asyncio.run(fetch_data())