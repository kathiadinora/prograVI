var appBuscarClientes = new Vue({
    el:'#frm-buscar-clientes',
    data:{
        misclientes:[], 
        valor:''
    },
    methods:{
        buscarCliente:function(){
            fetch(`private/Modulos/clientes/procesos.php?proceso=buscarCliente&cliente=${this.valor}`).then(resp=>resp.json()).then(resp=>{
                this.misclientes = resp;
            });
        },
        modificarCliente:function(cliente){
            appcliente.cliente = cliente;
            appcliente.cliente.accion = 'modificar';
        },
        eliminarCliente:function(idCliente){
            fetch(`private/Modulos/clientes/procesos.php?proceso=eliminarCliente&cliente=${idCliente}`).then(resp=>resp.json()).then(resp=>{
                this.buscarCliente();
            });
        }
    },
    created:function(){
        this.buscarCliente();
    }
});