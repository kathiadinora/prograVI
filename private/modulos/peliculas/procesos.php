<?php 
include('../../config/config.php');
$pelicula = new pelicula($conexion);

$proceso = '';
if( isset($_GET['proceso']) && strlen($_GET['proceso'])>0 ){
    $proceso = $_GET['proceso'];
}
$pelicula->$proceso( $_GET['pelicula'] );
print_r(json_encode($pelicula->respuesta));

class pelicula{
    private $dato = array(), $db;
    public $respuesta = ['msg'=>'correcto'];

    public function __construct($db){
        $this->db=$db;
    }
    public function recibirDatos($peliculas){
        $this->datos = json_decode($pelicula, true);
        $this->validar_datos();
    }
    private function validar_datos(){
        if( empty($this->datos['nombre']) ){
            $this->respuesta['msg'] = 'Nombre de la pelicula';
        }
        if( empty($this->datos['sinopsis']) ){
            $this->respuesta['msg'] = 'Sinopsis de la pelicula';
        }
        if( empty($this->datos['genero']) ){
            $this->respuesta['msg'] = 'Genero de la pelicula';
        }
        if( empty($this->datos['duracion']) ){
            $this->respuesta['msg'] = 'Duracion de la pelicula';
        }
        $this->almacenar_pelicula();
    }
    private function almacenar_pelicula(){
        if( $this->respuesta['msg']==='correcto' ){
            if( $this->datos['accion']==='nuevo' ){
                $this->db->consultas('
                    INSERT INTO pelicula (nombre,sinopsis,genero,duracion) VALUES(
                        "'. $this->datos['nombre'] .'",
                        "'. $this->datos['sinopsis'] .'",
                        "'. $this->datos['genero'] .'",
                        "'. $this->datos['duracion'] .'",
                    )
                ');
                $this->respuesta['msg'] = 'El registro fue guardado exitosamente'
            } else if( $this->datos['accion']==='modificar' ){
                $this->db->consultas('
                   UPDATE pelicula SET 
                        nombre  = "'. $this->datos['nombre'] .'",
                        sinopsis = "'. $this->datos['sinopsis'] .'",
                        genero  = "'. $this->datos['genero'] .'",
                        duracion  = "'. $this->datos['duracion'] .'",
                    WHERE idPelicula = "'. $this->datos['idPeicula'] .'",
                ');
                $this->respuesta['msg'] = 'El registro fue actualizado exitosamente'
            }
        }
    }
    public function buscarPelicula($valor=''){
        $this->db->consultas('
            select peliculas.idPelicula, peliculas.nombre, peliculas.sinopsis, peliculas.genero, peliculas.duracion
            from peliculas
            where peliculas.nombre like "%'.$valor.'%" or peliculas.genero like "%'.$valor.'%"
        ');
        return $this->respuesta = $this->db->obtener_datos();
    }
    public function eliminarPelicula($idPelicula=''){
        $this->db->consultas('
            delete peliculas
            from peliculas
            where peliculas.idPelicula = "'.$idPelicula.'"
        ');
        $this->respuesta['msg'] = 'El registro se elimino exitosamente'
    }
}

?>