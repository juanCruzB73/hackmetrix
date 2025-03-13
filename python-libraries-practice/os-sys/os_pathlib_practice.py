import os
from pathlib import Path,PurePath
#exeptopn os error
print(os.error("this is an error"))

#get os name
print(os.name)

#get route
print(os.getcwd())#devuelve clase stirng
print(Path.cwd())#devuelve clase path

#list files
print(os.listdir())
#list files from x directory

#print(os.listdir(r'C:\Users\juanc\Desktop'))#r evita que las barras sean tomadas como secuencias de escape
#print(list(Path().iterdir()))#generador que tiene clases porpias


#juntar rutas para distinton os
print(os.path.join(r'C:\Users\juanc\Desktop',"hackmetrix"))
#print(PurePath.joinpath(r'C:\Users\juanc\Desktop',"hackmetrix"))

#crear carpetas en python
#os.mkdir("test-os")
Path('test-path').mkdir(exist_ok=True)#no detiene el codigo si la carpeta ya exite
#os.makedirs(os.path.join('folder',"folder inside folder")) create multiple folders

#renombrar archivos(investigate this with directories)
#os.rename('test-os','test-os-edited')
#Path rename(path_actual,nuevo_path)

#comprobar si path existe(investigate this with directories)
print(os.path.exists('test-os-edited'))
file=Path('test-path')
print(file.exists())

#metadata(investigate further)
print(os.path.abspath(""))#get absolute path
