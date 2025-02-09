entities = {
    "'": "&apos;",
    "&": "&amp;",
    "<": "&lt;",
    ">": "&gt;",
    '"': "&quot;",
    " (space, but doesn't break lines)": "&nbsp;",
    "©": "&copy;",
    "®": "&reg;",
    "€": "&euro;",
    "£": "&pound;",
    "¥": "&yen;",
    "°": "&deg;",
    "•": "&bull;",
    "←": "&larr;",
    "→": "&rarr;",
    "∞": "&infin;",
    "♥": "&hearts;",
    "Δ": "&delta;",
    "∑": "&sum;",
    "§": "&sect;"
}


def encode_url(url,sploit):
    converted_sploit=""
    final=url
    for i in range(len(sploit)):
        if(sploit[i] in entities.keys()):
            converted_sploit+=entities[sploit[i]]
        else:
            converted_sploit+=sploit[i]
    final+=converted_sploit
    return final

url=input("enter the base url \n")
script=input("enter the script \n")

print(encode_url(url,script))