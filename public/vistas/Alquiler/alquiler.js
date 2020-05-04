Vue.component('v-select', VueSelect.VueSelect);
var appalquiler = new Vue({
    el:'#frm-alquiler',
    data:{
        alquiler:{
            idAlquiler : 0,
            accion    : 'nuevo',
            clientes   : {
                idCliente : 0,
                nombre   : ''
            },
            pelicula   : {
                idPelicula : 0,
                descripcion   : ''
            },
            fechaprestamo    : '',
            fechadevolucion      :'',
            msg       : ''
        },
        cliente : {},
        pelicula  : {}
    },
    methods:{
        guardarAlquiler(){
            fetch(`private/Modulos/alquiler/procesos.php?proceso=recibirDatos&alquiler=${JSON.stringify(this.alquiler)}`).then( resp=>resp.json() ).then(resp=>{
               
               
                this.alquiler.msg = resp.msg;
            });
        },
        limpiarAlquiler(){
            this.alquiler.idalquiler=0;
            this.alquiler.accion="nuevo";
            this.alquiler.alquiler='';
            this.alquiler.cliente='';
            this.alquiler.pelicula='';
            this.alquiler.fechaprestamo='';
            this.alquiler.fechadevolucion='';
            this.alquiler.msg="";
        }
    },
    created(){
        fetch(`private/Modulos/alquiler/procesos.php?proceso=traer_cliente_pelicula&alquiler=''`).then( resp=>resp.json() ).then(resp=>{
            this.cliente = resp.cliente;
            this.pelicula = resp.pelicula;
        });
    }
});