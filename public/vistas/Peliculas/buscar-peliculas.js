var appBuscarPeliculas = new Vue({
    el:'#frm-buscar-peliculas',
    data:{
        mispeliculas:[], 
        valor:'' 
    },
    methods:{
        buscarPelicula:function(){
            fetch(`private/Modulos/peliculas/procesos.php?proceso=buscarPelicula&pelicula=${this.valor}`).then(resp=>resp.json()).then(resp=>{
                this.mispeliculas = resp;
            });
        },
        modificarPelicula:function(pelicula){
            apppelicula.pelicula = pelicula;
            apppelicula.pelicula.accion = 'modificar';
        },
        eliminarPelicula:function(idPelicula){
            fetch(`private/Modulos/peliculas/procesos.php?proceso=eliminarPelicula&pelicula=${idPelicula}`).then(resp=>resp.json()).then(resp=>{
                this.buscarPelicula();
            });
        }
    },
    created:function(){
        this.buscarPelicula();
    }
});