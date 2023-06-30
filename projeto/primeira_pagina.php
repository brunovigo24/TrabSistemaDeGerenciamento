<!DOCTYPE html>
<html lang="en">
<head>
<title>Sistema de Gerenciamentos de Projetos</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>

* {
  box-sizing: border-box;
  font-family: Arial, Helvetica, sans-serif;
}

body {
  margin: 0;
  font-family: Arial, Helvetica, sans-serif;
}

/* Style the top navigation bar */
.topnav {
  overflow: hidden;
  background-color: #333;
}

/* Style the topnav links */
.topnav a {
  float: left;
  display: block;
  color: #f2f2f2;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

/* Change color on hover */
.topnav a:hover {
  background-color: #ddd;
  color: black;
}


.button {
  background-color: #4CAF50; /* Green */
  border: none;
  color: white;
  padding: 8px 16px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  transition-duration: 0.4s;
  cursor: pointer;
}

.button1 {
  background-color: white; 
  color: black; 
  border: 2px solid #4CAF50;
}

.button1:hover {
  background-color: #4CAF50;
  color: white;
}
.button2 {
  background-color: white; 
  color: black; 
  border: 2px solid #008CBA;
}

.button2:hover {
  background-color: #008CBA;
  color: white;
}

.button3 {
  background-color: white; 
  color: black; 
  border: 2px solid #f44336;
}

.button3:hover {
  background-color: #f44336;
  color: white;
}

.button4 {
  background-color: white;
  color: black;
  border: 2px solid #e7e7e7;
}

.button4:hover {background-color: #e7e7e7;}


/* Style the content */
.content {
  background-color: #ddd;
  padding: 10px;
  width: 90%;
  margin: auto;
  
}

/* Style the tabela customer */
#customers {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #04AA6D;
  color: white;
}




input[type=text], select {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

input[type=submit] {
  width: 100%;
  background-color: #4CAF50;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

input[type=submit]:hover {
  background-color: #45a049;
}

.boxForm {
    width: 100%;
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 20px;
}


/* The alert message box */
.alert {
  padding: 20px;
  background-color: #f44336; /* Red */
  color: white;
  margin-bottom: 15px;
  opacity: 1;
  transition: opacity 0.6s; /* 600ms to fade out */
}

.alert.success {background-color: #04AA6D;}
.alert.info {background-color: #2196F3;}
.alert.warning {background-color: #ff9800;}

/* The close button */
.closebtn {
  margin-left: 15px;
  color: white;
  font-weight: bold;
  float: right;
  font-size: 22px;
  line-height: 20px;
  cursor: pointer;
  transition: 0.3s;
}

/* When moving the mouse over the close button */
.closebtn:hover {
  color: black;
}

/* Style the footer */
.footer {
  background-color: #f1f1f1;
  padding: 10px;
}

</style>
</head>
<body>


<div class="topnav">
  <a href="index.php?pagina=colaborador.php">Colaborador</a>
  <a href="index.php?pagina=tarefa.php">Tarefa</a>
  <a href="index.php?pagina=projeto.php">Projeto</a>
</div>

<div class="content">
  <!--<h2>CSS Template</h2>
  <p>A topnav, content and a footer.</p>-->
  <?php
    if(isset($_GET["pagina"]) && 
      !empty($_GET["pagina"])){
        $pagina = $_GET["pagina"];
        include($pagina);
    }else{

    }
  ?>
</div>

<div class="footer">
  <p>Footer</p>
</div>

<script>
// Get all elements with class="closebtn"
var close = document.getElementsByClassName("closebtn");
var i;

// Loop through all close buttons
for (i = 0; i < close.length; i++) {
  // When someone clicks on a close button
  close[i].onclick = function(){

    // Get the parent of <span class="closebtn"> (<div class="alert">)
    var div = this.parentElement;

    // Set the opacity of div to 0 (transparent)
    div.style.opacity = "0";

    // Hide the div after 600ms (the same amount of milliseconds it takes to fade out)
    setTimeout(function(){ div.style.display = "none"; }, 600);
  }
}
</script>

<script>
  const constCPF= document.getElementById('cpf');
  const form = document.getElementById('checkout_form');

  constCPF.addEventListener("focus", function(event){
    event.target.style.background = "white"
  }, true);

  constCPF.addEventListener("blur", function(event){
    var string = document.getElementById('cpf').value;
    var strCPF =  string.replace('.','').replace('-','').replace('.','') ;
    
    if (TestaCPF(strCPF)!=true){
      alert("CPF inválido")
      event.target.style.background = "#ff00007a"
    }else{
      event.target.style.background = "#00b6ff29"
    }
  }, true);

  function TestaCPF(strCPF) {
    var Soma;
    var Resto;
    Soma = 0;
  
    if (strCPF == "00000000000") return false;

    for (i=1; i<=9; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (11 - i);
    
    Resto = (Soma * 10) % 11;

    if ((Resto == 10) || (Resto == 11))  Resto = 0;
    if (Resto != parseInt(strCPF.substring(9, 10)) ) return false;

    Soma = 0;
    for (i = 1; i <= 10; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (12 - i);
    Resto = (Soma * 10) % 11;

    if ((Resto == 10) || (Resto == 11))  Resto = 0;
    if (Resto != parseInt(strCPF.substring(10, 11) ) ) return false;
    return true;
  }

</script>
</body>
</html>