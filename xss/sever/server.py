from flask import Flask, request, make_response
from flask_cors import CORS

app = Flask(__name__)
CORS(app)  # This allows all origins; not suitable if sending credentials.

@app.route('/fetch', methods=['POST'])
def fetch_cookie():
    cookie_value = request.form.get('cookie')
    print("Cookie received:", cookie_value)
    return f"Received cookie: {cookie_value}", 200

if __name__ == '__main__':
    app.run(debug=True, host='0.0.0.0', port=5000)
