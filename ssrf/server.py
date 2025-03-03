from flask import Flask, request, jsonify,redirect
import requests

app = Flask(__name__)

@app.route('/')
def call_admin():
    #url = request.args.get('url')  # Get the URL parameter from the query string
    cookies = {
        "session": "your_session_cookie_here"  # Reemplaza con la cookie que necesites
    }

    #print(f"Attempting to fetch: {url}")

    '''if not url:
        return jsonify({
            'status': 'error',
            'message': 'Missing URL parameter'
        }), 400'''

    try:
        #headers
        headers={
            "bypass-tunnel-reminder":"test",
            "Host": "juancruzberrios732.ssrfeasychallenge.academy-challenges.com",
            "Cache-Control": "max-age=0",
            "Content-Type":"application/x-www-form-urlencoded",
            "Accept-Language": "en-US,en;q=0.9",
            "Upgrade-Insecure-Requests": "1",
            "User-Agent": "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36",
            "Accept": "text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.7",
            "Referer": "http://google.com",
            "Accept-Encoding": "gzip, deflate, br",
            "Cookie": "PHPSESSID=5fbe5b1235141dd5a60252b9d5023736"
        }
        #resposnse to debug
        response = requests.get("http://google.com",headers=headers,timeout=5)
        
        #Print the response content from the external request
        print("response content: ", response.text)
        #if succesfull redirect to url
        return redirect("http://google.com")
    
    except requests.exceptions.RequestException as e:
        # Handle errors if the request fails
        return jsonify({
            'status': 'error',
            'message': str(e)
        }),500

if __name__ == '__main__':
    app.run(debug=True)
