document.addEventListener("DOMContentLoaded", (event) =>{
    const formAlumnos = document.querySelector("#frmAlumno");
    frmAlumnos.addEventListener("submit", (e)=>{
        e.preventDefault(); 
        let codigo = document.querySelector("#txtCodigoAlumno").value,
            nombre = document.querySelector("#txtNombreAlumno").value,
            direccion = document.querySelector("#txtDireccionAlumno").value,
            telefono = document.querySelector("#txtTelefonoAlumno").value;

        var Keycodigo = "codigo";
        var Keynombre = "nombre";
        var Keydireccion = "direccion";
        var Keytelefono = "telefono";

        if( 'localStorage' in window ){
            window.localStorage.setItem(Keycodigo, codigo);
            window.localStorage.setItem(Keynombre, nombre);
            window.localStorage.setItem(Keydireccion, direccion);
            window.localStorage.setItem(Keytelefono, telefono);
        } else {
            alert("almacenamiento en local NO soportado!!! Actualizate!");
        }
    });

    document.querySelector("#btnRecuperarAlumno").addEventListener("click", (e) => {
        if('localStorage' in window){
            let codigo = document.querySelector("#txtCodigoAlumno").value;
            if(Codigo != ""){
                document.querySelector("#txtCodigoAlumno").value = window.localStorage.getItem("codigo" + Codigo);
                document.querySelector("#txtCodigoAlumno").value = window.localStorage.getItem("nombre" + Codigo);
                document.querySelector("#txtCodigoAlumno").value = window.localStorage.getItem("direccion" + Codigo);
                document.querySelector("#txtCodigoAlumno").value = window.localStorage.getItem("telefono" + Codigo);
            }else{
                alert("ingresar codigo a editar");
            }

        }else{
            alert("almacenamiento en local NO soportado!!! Actualizate!");
        }
    })
});

/*document.addEventListener("DOMContentLoaded",init);*/

/*document.addEventListener("DOMContentLoaded",function(event){
    alert("Pagina cargo forma 2");
});*/

/*function init(event){
    alert("Hola la pagina a cargado");
}*/