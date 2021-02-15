function PesquisarPerfil(pes) {
    var div = document.getElementById("divpesq");
    var div1 = document.getElementById("divpesq2");
    $("#divpesq2").empty();
    div.classList.remove("jumbotron");
    var temp = $(pes).val();
    var aux;
    var arr;
    //alert();
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            aux = xmlhttp.responseText;
            //alert();
            div.classList.add("jumbotron");
            arr = JSON.parse(aux);
            var ele;
            var str;
            var cont = 0;
            for (ele in arr) {
                cont++;

                var node = document.createElement("A");
                var elem = document.createElement("img");
                var p = document.createElement("p");
                elem.setAttribute("src", arr[ele].Foto);
                elem.setAttribute("height", "50");
                elem.setAttribute("width", "50");
                elem.setAttribute("class", "rounded-circle");
                str = arr[ele].Nome;
                //alert(arr[ele].Nome);
                var textnode = document.createTextNode(str);
                node.appendChild(textnode);
                node.setAttribute("href", "index.php?cmd=perfil&id=" + arr[ele].iduti);
                var text = document.createTextNode("          ");
                node.setAttribute("class", "btn btn-primary");
                p.appendChild(text);
                div1.appendChild(p);
                div1.appendChild(elem);
                div1.appendChild(node);
                if (cont % 4 == 0) {
                    var breaka = document.createElement("br");
                    div1.appendChild(breaka);
                }

            }

        }
    }
    xmlhttp.open("GET", "apis/nomeuser.php?query=" + temp, true);
    xmlhttp.send();
}