file=open("text.txt","r")

#READ ALL THE TEXT
'''content=file.read()

print(content)

file.close()
'''

#READ THE TEXT LINE BY LINE
'''for line in file:
    print(line.strip())#Removes any leading or trailing whitespace, including newline characters
file.close()'''

#READ BINARY
file = open("text.txt","rb")
content=file.read()
print(content)
file.close()