<?php
include('../../config/config.php');
$cliente = new cliente($conexion);

$proceso = '';
if( isset($_GET['proceso']) && strlen($_GET['proceso'])>0 ){
    $proceso = $_GET['proceso'];
}
$cliente->$proceso( $_GET['cliente'] );
print_r(json_encode($cliente->respuesta));

class cliente{
    private $datos = array(), $db;
    public $respuesta = ['msg'=>'correcto'];

    public function __construct($db){
        $this->db=$db;
    }
    public function recibirDatos($cliente){
        $this->datos = json_decode($cliente, true);
        $this->validar_datos();
    }
    private function validar_datos(){
        if( empty($this->datos['nombre']) ){
            $this->respuesta['msg']= 'Ingrese su nombre';
        }
        if( empty($this->datos['direccion']) ){
            $this->respuesta['msg']= 'Ingrese su direccion';
        }
        if( empty($this->datos['telefono']) ){
            $this->respuesta['msg']= 'Ingrese su numero de telefono';
        }
        if( empty($this->datos['dui']) ){
            $this->respuesta['msg']= 'Ingrese su numero de DUI';
        }
        $this->almacenar_cliente();

    }
    private function almacenar_cliente(){
        if( $this->respuesta['msg']==='correcto' ){
            if( $this->datos['accion']==='nuevo' ){
                $this->db->consultas('
                    INSERT INTO clientes (nombre,direccion,telefono,dui) VALUES(
                        "'. $this->datos['nombre'] .'",
                        "'. $this->datos['direccion'] .'",
                        "'. $this->datos['telefono'] .'",
                        "'. $this->datos['dui'] .'",
                    )
                ');
                $this->respuesta['msg'] = 'El registro guardado exitosamnete';
            } else if( $this->datos['accion']==='modificar' ){
                $this->db->consultas('
                   UPDATE cliente SET
                        nombre   ="'. $this->datos['nombre'] .'",
                        direccion ="'. $this->datos['direecion'] .'",
                        telefono ="'. $this->datos['telefono'] .'",
                        dui    ="'. $this->datos['dui'] .'",
                    WHERE idCliente = "'. $this->['idCliente'] .'"    
                ');
                $this->respuesta['msg'] = 'El registro fue actualizado exitosamente'
            }
        }
    }
    public function buscarCliente($valor=''){
        $this->db->consultas('
            select clientes.idCliente, cliente.nombre, cliente.direccion, cliente.telefono, cliente.dui
            from clientes
            where clientes.codigo like "%'.$valor.'%" or clientes.nombre like "%'.$valor.'%" or cliente.dui like "%'.$valor.'%"
        ');
        return $this->respuesta = $this->db->obtener_datos();
    }
    public function eliminarCliente($idCliente=''){
        $this->db->consultas('
            delete clientes
            from clientes
            where clientes.idCliente = "'.$idCliente.'"
        ');
        $this->respuesta['msg'] = 'El registro fue eliminado exitosamente';
    }
}

?>