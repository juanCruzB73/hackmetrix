import requests
from requests.exceptions import HTTPError
from getpass import getpass
from requests.auth import HTTPBasicAuth

#introduction
'''response = requests.get('https://api.github.com')
print(response.status_code)'''

#for through data in request
'''for url in ['https://api.github.com', 'https://api.github.com/invalid']:
    try:
        response=requests.get(url)
        response.raise_for_status()
    except HTTPError as http_err:
        print(f'Http error ocurred:{http_err}')
    except Exception as err:
        print(f'Other error ocurred: {err}')
    else:
        print('success')'''

#get page content in request
'''response = requests.get('https://api.github.com')
print(response.content)'''

#BY DEFAULT REQUEST WILL TRY TO LEAR RHE CURRENT ENCODING GUIDED BY HTTP HEADERS
#BUT IT CAN BE SPECIFIED
'''response=requests.get('https://api.github.com')
response.encoding='utf-8'
print(response.json())'''

#Heandilings in request
'''response=requests.get('https://api.github.com')
print(response.headers['content-type'])'''

#Transmitting the dictionary {'q': 'requests+language:python'}the Parameter paramswhich is a part of .get(), you can change the answer that was obtained when using Search API.
'''response = requests.get(
    'https://api.github.com/search/repositories',
    params={'q': 'requests+language:python'},
)
 
json_response = response.json()
repository = json_response['items'][0]
print(f'Repository name: {repository["name"]}')
print(f'Repository description: {repository["description"]}')'''

#CONFIGURING HEADERS
'''response = requests.get(
    'https://api.github.com/search/repositories',
    params={'q': 'requests+language:python'},
    headers={'Accept': 'application/vnd.github.v3.text-match+json'},
)

json_response = response.json()
repository = json_response['items'][0]
print(f'Text matches: {repository["text_matches"]}')'''

#HTTP METHODS
'''requests.post('https://httpbin.org/post', data={'key':'value'})
requests.put('https://httpbin.org/put', data={'key':'value'})
requests.delete('https://httpbin.org/delete')
requests.head('https://httpbin.org/get')
requests.patch('https://httpbin.org/patch', data={'key':'value'})
requests.options('https://httpbin.org/get')'''

#Request Analysis
'''response = requests.post('https://httpbin.org/post', json={'key':'value'})
response.request.headers['Content-Type']
print(response.request.url)
print(response.request.body)'''

#AUTH
'''response=requests.get(
    'https://api.github.com/user',
    auth=HTTPBasicAuth('username', getpass())
)
print(response.text)'''