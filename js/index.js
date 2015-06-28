var login_form = document.getElementById("login_form_overlay");
var reg_form   = document.getElementById("reg_form_overlay");
function mpass() {
    document.getElementById("passcontainer").innerHTML = "<input id=\"password\" name=\"password\" type=\"password\"/>";
    document.getElementById("password").focus();
}
function regmpass() {
	document.getElementById("regpass").innerHTML = "<input id=\"regpassword\" name=\"reg_password\" type=\"password\"/>";
    document.getElementById("regpassword").focus();
}
function cregmpass() {
	document.getElementById("cregpass").innerHTML = "<input id=\"cregpassword\" name=\"creg_password\" type=\"password\"/>";
    document.getElementById("cregpassword").focus();
}
function showLoginForm() {
	login_form.style.visibility = "visible";
}
function hideLoginForm() {
	login_form.style.visibility = "hidden";
}
function showRegForm() {
	reg_form.style.visibility = "visible";
}
function hideRegForm() {
	reg_form.style.visibility = "hidden";
}
function logout() {
	window.location.href="http://google.com";
}