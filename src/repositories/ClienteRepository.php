<?php

namespace App\Repositories;

class ClienteRepository
{
    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function buscarClientes($empresa, $filtro, $criterio, $iniciarDesde): array
    {
        $data = "";
        $parametros = [$empresa];

        switch ($criterio) {
            case "CODIGO":
                $data .= " AND codigo = ?";
                $parametros[] = $filtro;
                break;
            case "CEDULA/RUC":
                $data .= " AND cedula_ruc = ?";
                $parametros[] = $filtro;
                break;
            case "NOMBRE":
                $data .= " AND nombre LIKE ?";
                $parametros[] = "%$filtro%";
                break;
        }

        $query = "SELECT " . (($filtro == '') ? (($iniciarDesde == "") ? "" : " TOP 10 START AT ? ") : "") .
            "codigo, nombre, direccion1, direccion2, telefono, cedula_ruc, ISNULL(cupo,0) as cupo, activo, ciudad, observacion, contacto, vendedor, cargo, cobranza, casilla, e_mail, fax, cta_contable, estado, cta_contable_iva, cta_contable_retencionf, cta_contable_retencioni, ISNULL(descuento,0) as descuento, zona, propietario, ISNULL(dias,0) as dias, institucion, tipo, ISNULL(COD_PAC,0) as COD_PAC, apellidop, apellidom, genero, direccion3, pariente1, pariente2, pariente, fechai, fechan, telefono2, ISNULL(numprecio,0) as numprecio, tipo_identificacion, comentario, correos, visitas, llamadas, habilitado, huella, img, tipo_sangre, nivel, ISNULL(descuento_porcentual,0) as descuento_porcentual, ISNULL(discapacidad,0) as discapacidad, ISNULL(acoge_tiempo,0) as acoge_tiempo, ISNULL(acepta_forma_pago,0) as acepta_forma_pago, ISNULL(arbitraje,0) as arbitraje, beneficios, beneficios_paquete, comparticion, ISNULL(empa_servicios,0) as empa_servicios, tiempo_contrato, cuentas, red_acceso, servicio, ISNULL(renovacion,0) as renovacion, tipo_pago, com_bajada, com_subida, min_bajada, min_subida, valor_instalacion, plazo_instalacion, usuario, ISNULL(ocupacion,0) as ocupacion, pariente3, sexo, pais, provincia, grupo_sanguineo, convenio FROM in_cliente WHERE empresa = ? $data ORDER BY nombre ASC";

        if ($iniciarDesde !== null && $filtro == '') {
            array_unshift($parametros, $iniciarDesde);
        }

        try {
            $stmt = odbc_prepare($this->connection, $query);
            if (!$stmt) {
                throw new \Exception("Error al preparar la consulta: " . odbc_errormsg($this->connection));
            }

            if (!odbc_execute($stmt, $parametros)) {
                throw new \Exception("Error al ejecutar la consulta: " . odbc_errormsg($this->connection));
            }

            $clientes = [];
            while ($fila = odbc_fetch_array($stmt)) {
                $clientes[] = $fila; // No aplica codificación aquí
            }

            odbc_commit($this->connection);
            return $clientes;
        } catch (\Exception $e) {
            odbc_rollback($this->connection);
            throw new \Exception("Error en la consulta de clientes: " . $e->getMessage());
        } finally {
            odbc_close($this->connection);
        }
    }

    public function nuevoCodigoCliente($empresa): int
    {
        $query = "SELECT COUNT(*) as cantidad, MAX(CAST(codigo AS INTEGER)) as codigo FROM in_cliente WHERE empresa = ?";
        $stmt = odbc_prepare($this->connection, $query);

        if (!$stmt || !odbc_execute($stmt, [$empresa])) {
            throw new \Exception("Error al obtener el nuevo código de cliente: " . odbc_errormsg($this->connection));
        }

        $fila = odbc_fetch_array($stmt);
        return ($fila['cantidad'] > 0) ? $fila['codigo'] + 1 : 1;
    }
}
