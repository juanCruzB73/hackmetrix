from http.server import BaseHTTPRequestHandler, HTTPServer
from urllib.parse import urlparse, parse_qs
from datetime import datetime


class MyHandler(BaseHTTPRequestHandler):
    def do_GET(self):
        query_components = parse_qs(urlparse(self.path).query)

        print("\n")
        print(f"{datetime.now().strftime('%Y-%m-%d %I:%M %p')} - {self.client_address[0]}\t{self.headers['user-agent']}")
        print("-" * 60)
        
        for k, v in query_components.items():
            print(f"{k.strip()}\t\t\t{v}")

        # Enviar respuesta HTTP válida
        self.send_response(200)
        self.send_header("Content-type", "text/plain")
        self.end_headers()
        self.wfile.write(b"Request received")

    def log_message(self, format, *args):
        return


if __name__ == "__main__":
    try:
        server = HTTPServer(("0.0.0.0", 8888), MyHandler)
        print("Started HTTP server on port 8888")
        server.serve_forever()
    except KeyboardInterrupt:
        print("\n^C received, shutting down server")
        server.socket.close()

