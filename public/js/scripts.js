function myFunction() {
  
    var x = document.getElementById("myTopnav");
    if (x.className === "topnav") {
        x.className += " responsive";
    } else {
        x.className = "topnav";
    }
}
function confirm() {
    confirm("Deseas eliminarlo?!");
}

  function CheckBoxesValidations() {
	if (document.form1.CHKBOX.checked == false &&
		document.form1.CHKBOX.checked == false &&
		document.form1.CHKBOX.checked == false)
	{
     alert (' Debe selecionar almenos un CheckBox');
	return false;
	}
	 else
     {
	      return true;
       }
}

