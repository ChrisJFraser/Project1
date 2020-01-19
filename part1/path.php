<html>
<head>
<head>
<link rel="stylesheet" type="text/css" href="css/path.css">
</head>

<h1> Click Hyperlink Below to reset a path</h1></br>

<a href="reset.php">Proceed to Reset</a>

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
        xmlhttp.open("GET","getPath.php?q="+str,true);
        xmlhttp.send();
    }
}
</script>
</head>
<body>

<form>
<h1> Choose From drop down menu a path to be displayed</h1></br><b>Path
<select name="paths" onchange="showPath(this.value)">
  <option value="">Select a path:</option>
  <option value="1">Path 1</option>
  <option value="2">Path 2</option>
  <option value="3">Path 3</option>
  </select>
</form>
<br>
<div id="txtHint">
 tablular info will be listed here...</b></div>

</body>
</html>
