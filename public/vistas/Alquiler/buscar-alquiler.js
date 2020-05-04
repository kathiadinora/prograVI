var appBuscarAlquiler = new Vue({
    el:'#frm-buscar-alquiler',
    data:{
        misalquiler:[], 
        valor:''
    },
    methods:{
        buscarAlquiler:function(){
            fetch(`private/Modulos/alquiler/procesos.php?proceso=buscarAlquiler&alquiler=${this.valor}`).then(resp=>resp.json()).then(resp=>{
                this.misalquiler = resp;
            });
        },
        modificarAlquiler:function(alquiler){
            appalquiler.alquiler = alquiler;
            appalquiler.alquiler.accion = 'modificar';
        },
        eliminarAlquiler:function(idAlquiler){
            fetch(`private/Modulos/alquiler/procesos.php?proceso=eliminarAlquiler&alquiler=${idAlquiler}`).then(resp=>resp.json()).then(resp=>{
                this.buscarAlquiler();
            });
        }
    },
    created:function(){
        this.buscarAlquiler();
    }
});