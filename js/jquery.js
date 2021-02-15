$(document).ready(function () {

    $("#fotoperfil").hover(function () {
        //alert("da");
        $("#fotoperfil").css({
            'width': '370',
            'height': '370'
        })
    }, function () {
        //alert("ad");
        $("#fotoperfil").css({
            'width': '200',
            'height': '200'
        });
    }
    );

});