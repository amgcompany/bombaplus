function mpass(){
	document.getElementById("pass_container")
	.innerHTML = "<input id=\"password\" name=\"pass_login\" type=\"password\"/>";
	document.getElementById("password").focus();
	if(this.value=='Парола')this.value='';
 }