function password()
{
    var old = document.getElementById("password");
    if (old.type === "password") {
        old.type = "text";
        document.getElementById("eye").className= "far fa-eye-slash";
    } else {
        old.type = "password";
        document.getElementById("eye").className= "far fa-eye";
    }
}

function password_old()
{
    var old = document.getElementById("old-password");
    if (old.type === "password") {
        old.type = "text";
        document.getElementById("eye2").className= "far fa-eye-slash";
    } else {
        old.type = "password";
        document.getElementById("eye2").className= "far fa-eye";
    }
}

function password_confirmation()
{
    var old = document.getElementById("password_confirmation");
    if (old.type === "password") {
        old.type = "text";
        document.getElementById("eye_confirmation").className= "far fa-eye-slash";
    } else {
        old.type = "password";
        document.getElementById("eye_confirmation").className= "far fa-eye";
    }
}


$("#tnc-accept").click(function(){
    // if clicked, then change the checkbox to checked value checked
    // tnc accepted
    $("#tnc").prop("checked", true);


    // then hide the modal
    $("#terms-and-conditions").modal("hide");
});
