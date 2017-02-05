<script type="text/javascript" >
/*
		function checkForm()
		{
			var clave1 = document.GetElementById("clave1").value;
			var clave2 = document.GetElementById("clave2").value;
			if (clave2 != clave1) {
				document.GetElementById('errorcontra').innerHTML = 'Las contraseñas no coinciden';
				return false;
			}
  }

*/
function checkPass(f)
{
	
    //Store the password field objects into variables ...
    var pass1 = f.elements["clave1"].value;
    var pass2 = f.elements["clave2"].value;
	alert ("Hola29");
    //Store the Confimation Message Object ...
    //var message = .elements["errorcontra"];
    //Set the colors we will be using ...
    var goodColor = "#66cc66";
    var badColor = "#ff6666";
    //Compare the values in the password field 
    //and the confirmation field
    if(pass1 == pass2){
        //The passwords match. 
        //Set the color to the good color and inform
        //the user that they have entered the correct password 
       // pass2.style.backgroundColor = goodColor;
      //  f.style.color = goodColor;
       // f.innerHTML = "Passwords Match!";
		alert ("si");
		return (true);
    } else{
        //The passwords do not match.
        //Set the color to the bad color and
        //notify the user.
        //pass2.style.backgroundColor = badColor;
       // f.style.color = badColor;
       // f.innerHTML = "Passwords Do Not Match!";
		alert("no");
		return (false);
    }
}  
</script>