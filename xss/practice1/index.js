let input1 = document.getElementById("input1");
let button = document.getElementById("submit-button");
let span = document.getElementById("span1");

console.log(span);

button.addEventListener("click",()=>{
    span.innerHTML=input1.value;
})
//since browser have security to prevent the <script> useing other html tags is necesary like img or button