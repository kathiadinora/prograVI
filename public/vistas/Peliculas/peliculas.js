var appmateria = new Vue({
    el:'#frm-materias',
    data:{
        materia:{
            idMateria  : 0,
            accion    : 'nuevo',
            codigo    : '',
            materia    : '',
            carrera : '',
            facultad  : '',
            msg       : ''
        }
    },
    methods:{
        guardarMateria:function(){
            fetch(`private/Modulos/materias/procesos.php?proceso=recibirDatos&materia=${JSON.stringify(this.materia)}`).then( resp=>resp.json() ).then(resp=>{
                this.materia.msg = resp.msg;
                this.materia.idMateria = 0;
                this.materia.codigo = '';
                this.materia.materia = '';
                this.materia.carrera = '';
                this.materia.facultad = '';
                this.materia.accion = 'nuevo';
                appBuscarMaterias.buscarMateria();
            });
        }
    }
});
