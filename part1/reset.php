<?php 

/*
purpose : Lamp2 Project 1, reset web form
author(s) : Dana Amin, Chris Fraser, Darsh Bhatt
*/
  ?>


<html>
<head>
<link rel="stylesheet" type="text/css" href="css/path.css">
<script>
function showPath(str) {
    if (str == "") {
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else { 
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("txtHint").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","getPath2.php?q="+str,true);
        xmlhttp.send();
    }
}
</script>
</head>
<body>

<h1> Select a path below to reset  </h1>

<form>
<select name="paths" onchange="showPath(this.value)">
  <option value="">Select a path:</option>
  <option value="1">Path 1</option>
  <option value="2">Path 2</option>
  <option value="3">Path 3</option>
  </select>
</form>
<br>
<div id="txtHint"><b> </b></div>
</br>
</body>
</html>
