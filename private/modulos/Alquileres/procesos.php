<?php 
include('../../config/config.php');
$alquiler = new alquiler($conexion);

$proceso = '';
if( isset($_GET['proceso']) && strlen($_GET['proceso'])>0 ){
	$proceso = $_GET['proceso'];
}
$alquiler->$proceso( $_GET['alquiler'] );
print_r(json_encode($alquiler->respuesta));

class alquiler{
    private $datos = array(), $db;
    public $respuesta = ['msg'=>'correcto'];
    
    public function __construct($db){
        $this->db=$db;
    }
    public function recibirDatos($alquiler){
        $this->datos = json_decode($alquiler, true);
        $this->validar_datos();
    }
    private function validar_datos(){
        if( empty($this->datos['cliente']['id']) ){
            $this->respuesta['msg'] = 'por favor ingrese el cliente';
        }
        if( empty($this->datos['pelicula']['id']) ){
            $this->respuesta['msg'] = 'por favor ingrese la pelicula';
        }
        if( empty($this->datos['fechaPrestamo']) ){
            $this->respuesta['msg'] = 'por favor ingrese el valor';
        }
        $this->almacenar_alquiler();
    }
    private function almacenar_alquiler(){
        if( $this->respuesta['msg']==='correcto' ){
            if( $this->datos['accion']==='nuevo' ){
                $this->db->consultas('
                    INSERT INTO alquiler (idCliente,idPelicula,fechaPrestamo,fechaDevolucion,valor) VALUES(
                        "'. $this->datos['cliente']['id'] .'",
                        "'. $this->datos['pelicula']['id'] .'",
                        "'. $this->datos['fechaPrestamo'] .'",
                        "'. $this->datos['fechaDevolucion'] .'",
                        "'. $this->datos['valor'] .'"
                    )
                ');
                $this->respuesta['msg'] = 'Registro insertado correctamente';
            } else if( $this->datos['accion']==='modificar' ){
                $this->db->consultas('
                    UPDATE alquiler SET
                        idCliente     = "'. $this->datos['cliente']['id'] .'",
                        idPelicula      = "'. $this->datos['pelicula']['id'] .'",
                        fechaPrestamo   = "'. $this->datos['fechaPrestamo'] .'",
                        fechaDevolucion   = "'. $this->datos['fechaDevolucion'] .'",
                        valor             = "'. $this->datos['valor'] .'"
                    WHERE idAlquiler = "'. $this->datos['idAlquiler'] .'"
                ');
                $this->respuesta['msg'] = 'Registro actualizado correctamente';
            }
        }
    }
    public function buscarAlquiler($valor = ''){
        if( substr_count($valor, '-')===2 ){
            $valor = implode('-', array_reverse(explode('-',$valor)));
        }
        $this->db->consultas('
            select alquiler.idAlquiler, alquiler.idCliente, alquiler.idPelicula, alquiler.valor,date_format(alquiler.fechaPrestamo,"%d-%m-%Y") AS fechaPrestamo, alquiler.fechaPrestamo AS f, date_format(alquiler.fechaDevolucion,"%d-%m-%Y") AS fechaDevolucion, alquiler.fechaDevolucion AS d,
                
                peliculas.genero, peliculas.descripcion, clientes.dui, clientes.nombre, alquiler.valor AS v

            from alquiler
                inner join peliculas on(peliculas.idPelicula=alquiler.idPelicula)
                inner join clientes on(clientes.idCliente=alquiler.idCliente)
            where alquiler.cliente like "%'. $valor .'%" or alquiler.pelicula like "%'. $valor .'%" or alquiler.valor like "%'. $valor .'%" 

        ');
        $alquileres = $this->respuesta = $this->db->obtener_data();
        foreach ($alquileres as $key => $value) {
            $datos[] = [
                'idAlquiler' => $value['idAlquiler'],
                'pelicula'      => [
                    'id'      => $value['idPelicula'],
                    'label'   => $value['descripcion']
                ],
                'cliente'      => [
                    'id'      => $value['idCliente'],
                    'label'   => $value['nombre']
                ],
                'fechaPrestamo'       => $value['f'],
                'f'           => $value['fechaPrestamo'],

                'fechaDevolucion'       => $value['d'],
                'd'           => $value['fechaDevolucion'],

                'valor'       => $value['v'],
                'v'           => $value['valor']
            ]; 
        }
        return $this->respuesta = $datos;
    }


    public function traer_cliente_pelicula(){
        $this->db->consultas('
            select clientes.nombre AS label, clientes.idCliente AS id
            from clientes
        ');
        $clientes = $this->db->obtener_data();
        $this->db->consultas('
            select peliculas.descripcion AS label, peliculas.idPelicula AS id
            from peliculas
        ');
        $peliculas = $this->db->obtener_data();
        return $this->respuesta = ['clientes'=>$clientes, 'peliculas'=>$peliculas ];
    }
    public function eliminarAlquiler($idAlquiler = 0){
        $this->db->consultas('
            DELETE alquiler
            FROM alquiler
            WHERE alquiler.idAlquiler="'.$idAlquiler.'"
        ');
        return $this->respuesta['msg'] = 'Registro eliminado correctamente';;
    }
}
?>