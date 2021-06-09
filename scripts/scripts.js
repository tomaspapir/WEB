function loadDoc() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            document.getElementById("about").innerHTML = this.responseText;
        }
    };
    xhttp.open("GET", "../V2/scripts/ajax.txt", true);
    xhttp.send();
}