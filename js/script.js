var sendEmail=function(){
    if (document.getElementById("name").value != "" && document.getElementById("subject").value != "" &&
    document.getElementById("message").value != "") {
        var name = document.getElementById("name").value;
        var subject = document.getElementById("subject").value;
        var message = document.getElementById("message").value;
        // document.location.href = "mailto:vy5br@virginia.edu?subject=" + encodeURIComponent(subject) + "&body=" + encodeURIComponent(message);
        window.open('mailto:vy5br@virginia.edu?subject='+encodeURIComponent(subject)+"&body="+encodeURIComponent(message), '_blank');

        alert("You will now be redirected to send your email.");
    }
    else{
        alert("Please fill out the form.");
    }
}