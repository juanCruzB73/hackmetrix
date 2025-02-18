from flask import Flask, request, jsonify
import requests

app = Flask(__name__)

# List of allowed domains (for basic filtering)
ALLOWED_DOMAINS = {"example.com"}  # Intentionally excluding localhost for demonstration
first_time=True
@app.route('/')
def fetch_url():
    global first_time
    if(first_time):
        first_time=False
        return "First try"
    # Get the URL parameter from the query string
    url = request.args.get('url')

    if not url:
        return jsonify({
            'status': 'error',
            'message': 'Missing URL parameter'
        }), 400

    try:
        # Fetch the content from the provided URL
        response = requests.get(url, timeout=5)  # Add a timeout for safety

        # Return the fetched content
        return jsonify({
            'status': 'success',
            'url': url,
            'content': response.text
        })

    except requests.exceptions.RequestException as e:
        # Handle errors if the request fails
        return jsonify({
            'status': 'error',
            'message': str(e)
        }), 500

if __name__ == '__main__':
    app.run(debug=True, host='0.0.0.0', port=5000)