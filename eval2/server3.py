from http.server import BaseHTTPRequestHandler, HTTPServer
from urllib.parse import urlparse, parse_qs
from datetime import datetime


class MyHandler(BaseHTTPRequestHandler):

    def do_GET(self):
        query_components = parse_qs(urlparse(self.path).query)
        print("")
        print("{0} - {1}\t{2}".format(
            datetime.now().strftime("%Y-%m-%d %I:%M %p"),
            self.client_address[0],
            self.headers['user-agent'])
        )
        print("-------------------" * 6)
        for k, v in query_components.items():
            print("{0}\t\t\t{1}".format(k.strip(), v))

        return

    def log_message(self, format, *args):
        return

if __name__ == "main":
    try:
        server = HTTPServer(('0.0.0.0', 8888), MyHandler)
        print('Started http server')
        server.serve_forever()
    except KeyboardInterrupt:
        print('^C received, shutting down server')
        server.socket.close()
