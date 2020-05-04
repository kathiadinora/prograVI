var appbuscar_alquileres = new Vue({
    el: '#frm-buscar-alquileres',
    data:{
        mis_alquileres:[],
        valor:''
    },
    methods:{
        buscarAlquiler(){
            fetch(`private/modulos/alquileres/procesos.php?proceso=buscarAlquiler&alquiler=${this.valor}`).then( resp=>resp.json() ).then(resp=>{ 
                this.mis_alquileres = resp;
            });
        },
        modificarAlquiler(alquiler){
            appalquileres.alquiler = alquiler;
            appalquileres.alquiler.accion = 'modificar';
        },
        eliminarAlquiler(idAlquiler){
            var confirmacion = confirm("¿estas seguro de eliminar el registro?..");
            if (confirmacion){
                alert(" El registro se elimino corretamente....");
                fetch(`private/modulos/alquileres/procesos.php?proceso=eliminarAlquiler&alquiler=${idAlquiler}`).then(resp=>resp.json()).then(resp=>{
                  this.buscarAlquiler();
              });
              }

        }
    },
    created(){
        this.buscarAlquiler();
    }
});