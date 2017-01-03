<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Planogramas_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	function traerPlano($planoId){
		$data = array();
		$q = $this->db->query("SELECT v.* FROM planogramas p
			LEFT JOIN vector v ON v.plazaId=p.id
			WHERE p.id = '$planoId'
			AND v.status !='borrado'
			AND v.status !='areaPublica'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

	function traerInfoPlano($planoId){
		$data = array();
		$q = $this->db->query("SELECT
									v.id as 'id',
									v.grupoId as 'grupoId',
									v.tipo as 'tipo',
									v.x as 'x',
									v.y as 'y',
									v.x1 as 'x1',
									v.y1 as 'y1',
									v.x2 as 'x2',
									v.y2 as 'y2',
									v.cx as 'cx',
									v.cy as 'cy',
									v.d as 'd',
									v.r as 'r',
									v.rx as 'rx',
									v.ry as 'ry',
									v.width as 'width',
									v.height as 'height',
									v.points as 'points',
									v.transform as 'transform',
									v.localID as 'localID',
									l.Uso_1 as 'status',
									c.fechaEmision as 'fechaEmision',
									l.precioLocal as 'precioLocal'
								FROM planogramas p
								LEFT JOIN vector v ON v.plazaId=p.id
								LEFT JOIN contratos c ON c.Clavedelocal=v.localID
								LEFT JOIN vic_local l ON l.local=v.localID
								WHERE p.id = '$planoId'
								AND v.status !='borrado'
								AND v.status !='areaPublica'
								AND v.tipo !='text'
								");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

	function traerRenovacionesPlano($planoId){
		$data = array();
		$q = $this->db->query("SELECT
									v.id as 'id',
									v.tipo as 'tipo',
									v.x as 'x',
									v.y as 'y',
									v.x1 as 'x1',
									v.y1 as 'y1',
									v.x2 as 'x2',
									v.y2 as 'y2',
									v.cx as 'cx',
									v.cy as 'cy',
									v.d as 'd',
									v.r as 'r',
									v.rx as 'rx',
									v.ry as 'ry',
									v.width as 'width',
									v.height as 'height',
									v.points as 'points',
									v.transform as 'transform',
									v.localID as 'localID',
									l.Uso_1 as 'status',
									c.fechaEmision as 'fechaEmision',
									l.precioLocal as 'precioLocal',
									c.Clavedelocal as 'Clavedelocal',
									l.nombre as 'nombreLocal',
									v.contenido as 'contenido'
								FROM planogramas p
								LEFT JOIN vector v ON v.plazaId=p.id
								LEFT JOIN contratos c ON c.Clavedelocal=v.localID
								LEFT JOIN vic_local l ON l.local=v.localID
								WHERE p.id = '$planoId'
								AND v.status !='borrado'
								AND v.status !='areaPublica'
								");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

	function traerAreaPublica($planoId){
		$data = array();
		$q = $this->db->query("SELECT
									v.id as 'id',
									v.tipo as 'tipo',
									v.x as 'x',
									v.y as 'y',
									v.x1 as 'x1',
									v.y1 as 'y1',
									v.x2 as 'x2',
									v.y2 as 'y2',
									v.cx as 'cx',
									v.cy as 'cy',
									v.d as 'd',
									v.r as 'r',
									v.rx as 'rx',
									v.ry as 'ry',
									v.width as 'width',
									v.height as 'height',
									v.points as 'points',
									v.transform as 'transform',
									v.localID as 'localID',
									a.DISPOSICION as 'status'
								FROM planogramas p
								LEFT JOIN vector v ON v.plazaId=p.id
								LEFT JOIN V_MiguelWEB a ON a.Local=v.localID
								WHERE p.id = '$planoId'
								AND v.status ='areaPublica'
								AND v.tipo !='text'
								");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}


	function cargarPlaza(){
		$data = array();
		$q = $this->db->query("SELECT * FROM propiedades");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

	function buscarClaveLocalVector($id){
		$data = array();
		$q = $this->db->query("SELECT localID, tipo FROM vector WHERE id='$id'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}


	function cargarPlanosAsignar($planogramaID){
		$data = array();
		$q = $this->db->query("SELECT * FROM vector WHERE  plazaId='$planogramaID' AND tipo!='text'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

	function cargarPlanogramas(){
		$data = array();
		$q = $this->db->query("SELECT * FROM planogramas GROUP BY plaza");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

	function cargarPlanogramasID($id){
		$data = array();
		$q = $this->db->query("SELECT * FROM planogramas WHERE id='$id' and estatus='1'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

	function cargarPisos($plaza){
		$data = array();
		$q = $this->db->query("SELECT * FROM planogramas WHERE plaza='$plaza' and estatus='1' order by piso asc ");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}
	
	function cargarPisosPredioPlaza($predio_id,$inmueble_id){
		$data = array();
		$q = $this->db->query("SELECT * FROM layouts_piso WHERE INMUEBLE_ID='$inmueble_id' and PREDIO_ID='$predio_id'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}
	
	function cargarPisosPlaza($predio_id){
		$data = array();
		$q = $this->db->query("SELECT * FROM layouts_piso WHERE PREDIO_ID='$predio_id'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

	function cargarPisosArray($plaza){
		$data = array();
		$q = $this->db->query("SELECT piso FROM planogramas WHERE plaza='$plaza'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row->piso;
			}
			$q->free_result();
		}
		return $data;
	}

	function cargarTexto($planoId){
		$data = array();
		$q = $this->db->query("SELECT
								v.id as 'id',
								p.id as 'planogramaID',
								v.transform as 'transform',
								a.Local as 'localID'
								FROM planogramas p
								LEFT JOIN vector v ON v.plazaId=p.id
								LEFT JOIN V_MiguelWEB a ON a.Local=v.localID
								WHERE p.id = '$planoId'
								AND v.status !='borrado'
								AND v.tipo ='text'
								AND orden !=''
								AND infoTipo ='1'
								group by v.localID
			");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

	function traerID($planoId, $localID, $orden){
		$data = array();
		$q = $this->db->query("SELECT *
								FROM planogramas p
								LEFT JOIN vector v ON v.plazaId=p.id
								LEFT JOIN vic_local i ON i.local=v.localID
								LEFT JOIN contratos c ON c.Clavedelocal=v.localID
								WHERE p.id = '$planoId'
								AND v.localID='$localID'
								AND v.tipo='text'
								AND v.orden='$orden'
								");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

	function traerIDNulos($planoId, $localID){
		$data = array();
		$q = $this->db->query("SELECT *
								FROM planogramas p
								LEFT JOIN vector v ON v.plazaId=p.id
								LEFT JOIN vic_local i ON i.local=v.localID
								LEFT JOIN contratos c ON c.Clavedelocal=v.localID
								WHERE p.id = '$planoId'
								AND v.localID='$localID'
								AND v.tipo='text'
								AND v.orden IS NULL
								");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

	function cargaCamposBD(){
		$data = array();
		$q = $this->db->query("SELECT c.*, i.* FROM vic_local i
								LEFT JOIN contratos c ON c.Clavedelocal=i.local
								LIMIT	 1
								");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}
	
	function cargarInmuebles(){
		$data = array();
		$q = $this->db->query("SELECT * FROM borrar_vic_inmueble where Nombre !='' order by Nombre asc");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}
	
	function cargarLocalesPlaza($plazaId){
		$data = array();
		$q = $this->db->query("SELECT *, CASE v.Estatus 
													WHEN 'BLOQUEADO' THEN 'CONFINADO'
													WHEN 'DESOCUPADO' THEN 'DISPONIBLE'
													ELSE v.Estatus
													END as NUEVO_ESTATUS
													FROM vic_local v
													LEFT JOIN layouts_local l ON v.Local=l.INTELISIS_ID
													where v.Inmueble = '$plazaId'
													and v.Estatus != 'BAJA'
													order by v.NombreCorto asc");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}
	
	function cargarLocalesPlazaFaltantes($plazaId){
		$data = array();
		$q = $this->db->query("SELECT * FROM vic_local_faltantes where Inmueble = '$plazaId' order by NombreCorto asc");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}
	
	function cargarLocalesPlazaNuevos(){
		$data = array();
		$q = $this->db->query("SELECT l.*,u.email FROM vic_local l
			LEFT JOIN inmuebles i ON i.inmuebleIntelisis = CAST(l.Inmueble AS UNSIGNED)
			LEFT JOIN TEMPORA_PLAZA p ON p.nomenclatura = i.codigoIATA
			LEFT JOIN usuarios u ON u.usuarioID = p.gerente
			WHERE l.Estatus != 'BAJA'
			AND CAST(l.Inmueble AS UNSIGNED) IN (49,
					23,
        			33,
        			9,
        			13,
        			6,
        			16,
        			21,
        			35,
					34)
			AND l.`Local` NOT IN (SELECT l.INTELISIS_ID FROM layouts_local l
			UNION ALL
			SELECT e.INTELISIS_ID FROM layouts_estatus_local e)
			GROUP BY l.Inmueble");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}
	
	function cargarLocalesPisoPredio($piso_id,$predio_id){
		$data = array();
		$q = $this->db->query("SELECT * FROM layouts_local where PISO_ID = '$piso_id' AND PREDIO_ID = '$predio_id'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}
	
	function cargarLocalesPiso($piso_id){
		$data = array();
		$q = $this->db->query("SELECT * FROM layouts_local where PISO_ID = '$piso_id'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}
	
	function cargarPrediosPlaza($plazaId){
		$plazaId = (int)$plazaId;
		$data = array();
		$q = $this->db->query("SELECT * FROM layouts_predial where INMUEBLE_ID = '$plazaId' order by CALLE asc");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}
	
	function cargarLocalesEstatusPlaza($plazaId){
		$plaza_id_int = (int)$plazaId;
		$data = array();
		$q = $this->db->query("SELECT * FROM vic_local where Inmueble = '$plazaId' AND Estatus != 'BAJA' 
			AND Local NOT IN (SELECT INTELISIS_ID FROM layouts_local WHERE INMUEBLE_ID = '$plaza_id_int') order by NombreCorto asc");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}
	
	function cargarPredios($intelisisInmueble){
		
		$data = array();
		$q = $this->db->query("SELECT * FROM inmuebles where inmuebleIntelisis='$intelisisInmueble'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

	function traer_predios_por_plaza($plaza_id){
		
		$data = array();
		$q = $this->db->query("SELECT * FROM layouts_predial where INMUEBLE_ID = '$plaza_id' order by NOMBRE_DE_PREDIO asc");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
		
	}
	
	function traer_estatus_local($intelisis_ref){
		
		$data = array();
		$q = $this->db->query("SELECT ESTATUS, COMENTARIO FROM layouts_estatus_local where INTELISIS_ID = '$intelisis_ref'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
		
	}
	
	function traer_piso($piso_id){
		
		$data = array();
		$q = $this->db->query("SELECT * FROM layouts_piso where PISO_ID = '$piso_id'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
		
	}

	function traer_local_layout($intelisis_ref){
		
		$data = array();
		$q = $this->db->query("SELECT * FROM layouts_local where INTELISIS_ID = '$intelisis_ref'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
		
	}
	
	function traer_local_estatus($intelisis_ref){
		
		$data = array();
		$q = $this->db->query("SELECT * FROM layouts_estatus_local where INTELISIS_ID = '$intelisis_ref'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
		
	}
	
	function trae_usuarios(){
		$data = array(); 
		$q = $this->db->query("SELECT * FROM usuarios");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
	}
	
	function cargarEncargados($intelisisInmueble){
		$data = array(); 
		$q = $this->db->query("SELECT * FROM borrar_encargado_inmueble WHERE Inmueble='$intelisisInmueble'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
	}
	
	function cargarPrediosLayouts(){
		$data = array(); 
		$q = $this->db->query("SELECT * FROM layouts_predial lp 
												LEFT JOIN inmuebles i ON i.inmuebleIntelisis=lp.INMUEBLE_ID 
												");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
	}
	
	function cargarPisosLayouts(){
		$data = array(); 
		$q = $this->db->query("SELECT * FROM layouts_piso p
												JOIN layouts_predial r on p.PREDIO_ID=r.PREDIO_ID
												ORDER BY idCorrecto");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
	}
	
	function cargarLocasLayouts(){
		$data = array(); 
		$q = $this->db->query("
		SELECT 
				L.INMUEBLE_ID AS INMUEBLE_ID,
				R.ID_PREDIOS AS PREDIO_ID,
				P.idCorrecto AS PISO_ID,
				V.NombreCorto AS NUMERO,
				L.AREA_RENTABLE AS AREA_RENTABLE,
				L.TIPO_DE_LOCAL AS TIPO_DE_LOCAL,
				L.CATEGORIA_LOCAL AS CATEGORIA_LOCAL,
				L.ESTATUS_LOCAL AS ESTATUS_LOCAL,
				L.FECHA_INICIO_LOCAL AS FECHA_INICIO_LOCAL,
				L.USO_LOCAL AS USO_LOCAL,
				L.INTELISIS_ID AS INTELISIS_ID
		FROM layouts_local L
			JOIN vic_local V ON V.Local=L.INTELISIS_ID
			JOIN layouts_piso P ON P.PISO_ID=L.PISO_ID 
			JOIN layouts_predial R ON R.PREDIO_ID=L.PREDIO_ID 
			WHERE ( L.INMUEBLE_ID='49'
								OR  L.INMUEBLE_ID='23'
								OR  L.INMUEBLE_ID='33'
								OR  L.INMUEBLE_ID='9'
								OR  L.INMUEBLE_ID='13'
								OR  L.INMUEBLE_ID='6'
								OR  L.INMUEBLE_ID='16'
								OR  L.INMUEBLE_ID='21'
								OR  L.INMUEBLE_ID='35'
								OR  L.INMUEBLE_ID='34')
			AND L.ESTATUS_LOCAL != 'BAJA'
			AND V.Estatus != 'NULL'
		");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
	}
	
	function cargarLocasSinContratosLayouts(){
		$data = array(); 
		$q = $this->db->query("SELECT * FROM layouts_local l
			LEFT JOIN borrarContratos b ON b.`LOCAL` = l.INTELISIS_ID
			WHERE b.CLIENTE IS NULL");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
	}
	
	function cargarCategoriasPisos($inmuebleID, $pisoID){
		$data = array(); 
		$q = $this->db->query("select * from layouts_local ll 
												where ll.INMUEBLE_ID='$inmuebleID' 
												and ll.PISO_ID='$pisoID'
												GROUP BY ll.CATEGORIA_LOCAL");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();  	
		}
		return $data;
	}
	
	function caida_inmuebles(){
		$data = array();
		$q = $this->db->query("SELECT
									i.codigoIATA as 'codigoIATA',
									i.inmuebleNombre as 'inmuebleNombre',
									i.inmuebleIntelisis as 'inmuebleIntelisis',
									a.Estatus as 'Estatus',
									a.Estatus as 'Estatus',
									e.ApeApex as 'RazonSocial',
									e.No_cuenta as 'No_cuenta',
									e.Clave_Servicio as 'Clave_Servicio',
									a.DiasPago as 'DiasPago',
									e.CuentaContable as 'CuentaContable'
								FROM inmuebles i
								LEFT JOIN borrar_vic_inmueble a ON a.Inmueble=i.inmuebleIntelisis
								LEFT JOIN borrarInmueblesExtractor e ON e.Inmueble=i.inmuebleIntelisis
								WHERE a.Inmueble=i.inmuebleIntelisis
								");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}
		
	function sumaPisos($pisoID){
		$data = array();
		$q = $this->db->query("SELECT ROUND(SUM(AREA_RENTABLE),2) as suma FROM layouts_local where PISO_ID='$pisoID' AND ESTATUS_LOCAL != 'BAJA'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}	
	
	function comparaciones($intelisisID){
		$data = array();
		$q = $this->db->query("SELECT * FROM layouts_local where INTELISIS_ID = '$intelisisID'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}	
	
	function comentariosGerentes($intelisisID){
		$data = array();
		$q = $this->db->query("SELECT * FROM layouts_estatus_local where INTELISIS_ID = '$intelisisID'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}	
	
	function llocales($intelisisID){
		$data = array();
		$q = $this->db->query("SELECT ESTATUS_LOCAL FROM layouts_local WHERE INTELISIS_ID = '$intelisisID'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}	
	
	
	function contratos($Local){
		$data = array();
		$q = $this->db->query("
		SELECT MovID FROM intelisis_vic_condicion iv 
		JOIN intelisis_contrato ic ON ic.ID=iv.IDContrato
		where iv.Local='$Local'
		");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}
	
	function consultaContrato($INTELISIS_ID){
		$data = array();
		$q = $this->db->query("
		SELECT MovID from intelisis_vic_condicion i
		LEFT JOIN intelisis_contrato c ON i.IDContrato=c.id
		WHERE i.Local='$INTELISIS_ID'
		and i.Estatus='Activa'
		and i.articulo = 'REN'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}
	
}
