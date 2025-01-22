
function validateForm(){
    var license=document.getElementById("license").value;
    var nop=document.getElementById("nop").value;
    var pass= document.getElementById("pass").value;
    var phn=document.getElementById("phn").value;

    if(isNaN(license)){
        //document.getElementById("license").innerHTML="Enter number only.";
        alert ("Enter Number Only");
            return false;
        }
    if(nop<5){
      //document.getElementById("nop").innerHTML="Number of Product must be greater than 5.";
            alert ("Number of Product must be greater than 5.");
                return false;
            }
        
            if(phn!==10){
                document.getElementById("phn").innerHTML="Phone number must be in 10 number.";
               // alert ("Phone number must be in 10 number.");
                return false;
            }
    

}