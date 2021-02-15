var vCC = false;
var vdata = false;
var vPass = false;
var vEmail = false;
var vNome = false;
var vTel = false;
var vAPass = false;
var vPassAntiga = false;

function ValidarEmail(mail) {
	var span = document.getElementById("spanform");
	$(mail).removeClass('is-invalid');
	$(mail).removeClass('is-valid');
	var aux;
	var temp = mail.value;
	var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;


	// ajax
	if (window.XMLHttpRequest) {
		xmlhttp = new XMLHttpRequest();
	} else {
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function () {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			aux = xmlhttp.responseText;
			//alert(aux);

			if (re.test(temp)) {
				$(mail).addClass('is-valid');
				vEmail = true;

				if (aux != "") {
					$(mail).addClass('is-invalid');
					vEmail = false;
					span.innerHTML = aux;
					//alert(aux);
				}
				else {
					span.innerHTML = "";
				}
			}
			else {
				$(mail).addClass('is-invalid');
				bValido = false;
				vEmail = false;
			}
		}
		else console.log("banana");
	}

	//francisco.louro16@hotmail.com
	//alert("../apis/existemail.php?email=" + temp);
	xmlhttp.open("GET", "apis/existemail.php?email=" + temp, true);
	xmlhttp.send();





}

function ValidarData(data) {
	$(data).removeClass('is-invalid');
	$(data).removeClass('is-valid');
	var temp = $(data).val();
	var ano = temp.split("-")[0];
	var mes = temp.split("-")[1];
	var dia = temp.split("-")[2];


	var today = new Date();

	var d = new Date(ano, mes - 1, dia);
	if ((2019 - ano) <= 17 && (2019 - ano) > 99) {
		$(data).addClass('is-invalid');
		bValido = false;
		vdata = false;
	}
	if (d > today || d == "Invalid Date") {
		$(data).addClass('is-invalid');
		bValido = false;
		vdata = false;
	}
	else {
		$(data).addClass('is-valid');
		vdata = true;
	}
}
function ValidarTel(tel) {
	var span = document.getElementById("spanform");
	$(tel).removeClass('is-invalid');
	$(tel).removeClass('is-valid');
	var re = /^[0-9]{9}$/;

	var temp = $(tel).val();
	if (window.XMLHttpRequest) {
		xmlhttp = new XMLHttpRequest();
	} else {
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function () {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			aux = xmlhttp.responseText;
			//alert(aux);

			if (re.test(temp)) {
				$(tel).addClass('is-valid');
				vTel = true;

				if (aux != "") {
					$(tel).addClass('is-invalid');
					vTel = false;
					span.innerHTML = aux;
					//alert(aux);
				}
				else {
					span.innerHTML = "";
				}
			}
			else {
				$(tel).addClass('is-invalid');

				vTel = false;
			}
		}
	}
	xmlhttp.open("GET", "apis/existetel.php?tel=" + temp, true);
	xmlhttp.send();
}
function ValidarCC(cc) {
	$(cc).removeClass('is-invalid');
	$(cc).removeClass('is-valid');
	var re = /^[0-9]{8}$/;
	var temp = $(cc).val();
	if (re.test(temp)) {
		$(cc).addClass('is-valid');
		vCC = true;
	}
	else {
		$(cc).addClass('is-invalid');
		bValido = false;
		vCC = false;
	}
}

function ValidarPassIgual() {
	var span = document.getElementById("spanpass1");
	var pass1 = document.getElementById("pass1");
	var pass2 = document.getElementById("pass2");

	if (pass2 != null) {

		if (pass1.value == pass2.value) {
			aux = "As palavra pass coincidem!";
			span.classList.add("badge-success");
			span.classList.remove("badge-danger");
			pass2.classList.add("is-valid");
			pass2.classList.remove("is-invalid");
			//vPass = true;
			vAPass = true;
		} else {
			aux = " As palavras-pass não coincidem!";
			span.classList.add("badge-danger");
			span.classList.remove("badge-success");
			pass2.classList.add("is-invalid");
			pass2.classList.remove("is-valid");
			//vPass = false;
			vAPass = false;
		}
	}
	span.innerHTML = aux;

}
function ReturnPasses() {
	var span = document.getElementById("spanform");
	//alert(vPass);
	if (vPassAntiga) {
		if (vPass) {
			if (vAPass) {
				//alert("true");
				span.innerHTML = "";
				return true;

			}
			else {
				//alert("false2");
				span.innerHTML = "";
				return false
			}
		}
		else {
			//alert("false1");
			span.innerHTML = "";
			return false;
		}
	}
	else {

		span.innerHTML = "Confirme a sua palavra-passe antiga!";
		return false;
	}
	//return false;
}

function ValidarPass(pass) {
	$(pass).removeClass('is-invalid');
	$(pass).removeClass('is-valid');
	ValidarPassIgual();
	var temp = $(pass).val();
	var span = document.getElementById("spanpass");
	var reMais = /[A-Z]/g;
	var reMin = /[a-z]/g;
	var reNum = /[0-9]/g;
	var aux = "Falta: ";
	var flag = false;
	if (temp.length > 7) {
		if (reMais.test(temp)) {
			if (reMin.test(temp)) {
				if (reNum.test(temp)) {
					$(pass).addClass('is-valid');
					vPass = true;
				}
				else {
					flag = true;
					aux = aux + "Números ";
					$(pass).addClass('is-invalid');
					vPass = false;
				}
			}
			else {
				flag = true;
				aux = aux + "Letra Minúscula ";
				$(pass).addClass('is-invalid');
				vPass = false;
			}
		}
		else {
			flag = true;
			aux = aux + "Letra Maiúscula ";
			$(pass).addClass('is-invalid');
			vPass = false;
		}
	}
	else {
		flag = true;
		aux += 8 - temp.length + " Caractéres";
		$(pass).addClass('is-invalid');
		vPass = false;
	}
	if (flag)
		span.innerHTML = aux;
	else {
		span.innerHTML = "";
	}
}

function ValidarNome(nome) {
	var re = /^[a-zA-Z]+(([',. -][a-zA-Z ])?[a-zA-Z]*)*$/g;
	var temp = $(nome).val();

	$(nome).removeClass('is-invalid');
	$(nome).removeClass('is-valid');

	if (re.test(temp)) {
		$(nome).addClass('is-valid');
		vNome = true;
	}
	else {
		$(nome).addClass('is-invalid');
		vNome = false;
	}
}

function ValidarForm() {
	var span = document.getElementById("spanform");
	var flag = false;
	//reCaptch verified
	if (vNome) {
		if (vCC) {
			if (vEmail) {
				if (vdata) {
					if (vTel) {
						span.innerHTML = "";
						flag = true;
					} else {
						flag = false;
						span.innerHTML = "Formulário incompleto! Preencha o formulário com a devia informação!";
					}
				} else {
					flag = false;
					span.innerHTML = "Formulário incompleto! Preencha o formulário com a devia informação!";
				}
			}
			else {
				flag = false;
				span.innerHTML = "Formulário incompleto! Preencha o formulário com a devia informação!";
			}
		}
		else {
			flag = false;
			span.innerHTML = "Formulário incompleto! Preencha o formulário com a devia informação!";
		}
	}
	else {
		flag = false;
		span.innerHTML = "Formulário incompleto! Preencha o formulário com a devia informação!";
	}

	return flag;
}

function validarCaptcha() {

	var response = grecaptcha.getResponse();
	var flag = false;
	if (response.length == 0) {
		flag = false;
	}
	//reCaptcha not verified

	else {
		flag = true;
	}
	//reCaptch verified
	return flag;
}


function passAntiga(p, id) {


	//alert(id);
	if (window.XMLHttpRequest) {
		xmlhttp = new XMLHttpRequest();
	} else {
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function () {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			aux = xmlhttp.responseText;
			//alert(aux);
			if (aux == 1)
				vPassAntiga = true;
			else vPassAntiga = false;
		}
	}
	xmlhttp.open("GET", "apis/passantiga.php?pass=" + p.value + "&id=" + id, true);
	xmlhttp.send();

}
