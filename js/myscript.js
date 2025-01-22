function printText(){

    var text = document.getElementById("input").value;
    document.getElementById("print").innerHTML=text;
}

function isValidName() {
    const fname = document.getElementById("lname").value;
    const regex = /^[A-Za-z]+$/;

    if(!regex.test(fname))
    {
        alert("First Name should not contain any numerical value.");
        return false;

    }
    //return regex.test(input); 
}
