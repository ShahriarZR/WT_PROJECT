function validation() {
    const fname = document.getElementById("fname").value;
    const lname = document.getElementById("lname").value;
    const mail = document.getElementById("email").value;
    const phone = document.getElementById("phone").value;
    const  dob= document.getElementById("dob").value;
    const password = document.getElementById("pass").value;
    const repassword = document.getElementById("repass").value;
    const currentDate = new Date();
    const dobDate = new Date(dob);
    const age = currentDate.getFullYear() - dobDate.getFullYear();
    const regexname = /^[A-Za-z]+$/;
    const regexemail = /@.+\.com$/;
    let flag=true;
    
    
    document.getElementById("fnameerror").innerHTML = "";
    document.getElementById("lnameerror").innerHTML = "";
    document.getElementById("emailerror").innerHTML = "";
    document.getElementById("phoneerror").innerHTML = "";
    document.getElementById("doberror").innerHTML = "";
    document.getElementById("passerror").innerHTML = "";



    if (!regexname.test(fname)) {
        document.getElementById("fnameerror").innerHTML = "Only Alphabet Acceptable.";
        flag=false;
    }
    if (!regexname.test(lname)) {
        document.getElementById("lnameerror").innerHTML = "Only Alphabet Acceptable.";

        flag=false;
    }
    if (!regexemail.test(mail)) {
        document.getElementById("emailerror").innerHTML = "Enter valid  email";
        flag=false;
    }
    if(!phone.length==11){
        document.getElementById("phoneerror").innerHTML= "Phone Number is not valid";
        flag=false;
    }
    if(age<15){
            document.getElementById("doberror").innerHTML="You can register after 15.";
            flag=false;
    }
    if(password!== repassword){
        document.getElementById("passerror").innerHTML="Password did not matched.";
        flag=false;
    }
    if(flag==false)
    {
        return flag;
    }
}

