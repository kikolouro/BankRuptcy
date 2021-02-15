$(document).ready(function () {
    let form = $("#selectcriarconta");
    let limite = $("#selectlimite");
    let mult = $("#tags");
    mult.hide();
    limite.hide();
    form.change(function () {

        if (form.val() == 3) {
            limite.val("");
            limite.show();
            mult.hide();
        }
        else {
            mult.hide();
            limite.hide();
        }
        if (form.val() == 2) {
            mult.val("");
            mult.show();
            limite.hide();
        }



    });

});
/*
function a () {
    let form = document.getElementById("selectcriarconta");
    alert(form.value);
}*/