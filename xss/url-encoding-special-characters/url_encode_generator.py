url_encoding = {
    " ": "%20",
    "!": "%21",
    "\"": "%22",
    "#": "%23",
    "$": "%24",
    "%": "%25",
    "&": "%26",
    "'": "%27",
    "(": "%28",
    ")": "%29",
    "*": "%2A",
    "+": "%2B",
    ",": "%2C",
    "-": "%2D",
    ".": "%2E",
    "/": "%2F",
    ":": "%3A",
    ";": "%3B",
    "<": "%3C",
    "=": "%3D",
    ">": "%3E",
    "?": "%3F",
    "@": "%40",
    "[": "%5B",
    "\\": "%5C",
    "]": "%5D",
    "^": "%5E",
    "_": "%5F",
    "`": "%60",
    "{": "%7B",
    "}": "%7D",
    "~": "%7E"
}

def encode_url(url,sploit):
    converted_sploit=""
    final=url
    for i in range(len(sploit)):
        if(sploit[i] in url_encoding.keys()):
            converted_sploit+=url_encoding[sploit[i]]
        else:
            converted_sploit+=sploit[i]
    final+=converted_sploit
    return final

url=input("enter the base url \n")
script=input("enter the script \n")

print(encode_url(url,script))