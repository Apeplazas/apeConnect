<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class evaluacionestwo_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	function evaluacionListaCategorias($campaniaID = ''){
		$campaniaID = (!empty($campaniaID)) ? "WHERE e.campaniaID='$campaniaID'" : '';
		$data = array();
		$q = $this->db->query("SELECT * FROM evaluacion_preguntas e
			LEFT JOIN evaluacion_categorias ec ON e.categoria=ec.evaluacionCategoriaID
			$campaniaID
			GROUP BY categoria order by preguntaID asc");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

	function listaCategoriasCatalogo(){
		$data = array();
		$q = $this->db->query("SELECT * from evaluacion_categorias");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

	function cargaAreas(){
		$data = array();
		$q = $this->db->query("SELECT * FROM gerenciasRH");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

	function preguntasCategorias($categoria, $campaniaID){
		$data = array();
		$q = $this->db->query("SELECT * FROM evaluacion_preguntas WHERE categoria='$categoria' and campaniaID='$campaniaID'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

	function cargaUsuariosDepartamentos($areaID){
		$data = array();
		$q = $this->db->query("SELECT * FROM usuarios WHERE areaID='$areaID'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

	function respuestasCategorias($categoria,$usuarioID,$campaniaID){
		$data = array();
		$q = $this->db->query("SELECT preguntas, autoevaluacion, jefeDirecto, plandeaccion, ((autoevaluacion + jefeDirecto)/2) as promedio
		FROM (
			select
			ep.pregunta as 'preguntas',
			(select r.respuesta from evaluacion_respuestas r LEFT JOIN evaluacion_catalogoEvaluadores c ON c.catalogoId = r.catalogoId where r.preguntaID=ep.preguntaID AND c.usuarioAcalificarID='$usuarioID' and r.tipo='1' group by ep.preguntaID) as 'autoevaluacion' ,
			(select r.respuesta from evaluacion_respuestas r LEFT JOIN evaluacion_catalogoEvaluadores c ON c.catalogoId = r.catalogoId where r.preguntaID=ep.preguntaID AND c.usuarioAcalificarID='$usuarioID' and r.tipo='2' group by ep.preguntaID) as 'jefeDirecto',
			(select r.respuesta from evaluacion_respuestas r LEFT JOIN evaluacion_catalogoEvaluadores c ON c.catalogoId = r.catalogoId where r.preguntaID=ep.preguntaID AND c.usuarioAcalificarID='$usuarioID' and r.tipo='3' group by ep.preguntaID) as 'plandeaccion'
			from evaluacion_preguntas ep
			WHERE ep.categoria='$categoria'
			AND ep.campaniaID='$campaniaID'
		) as temp
		");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

	function verificaRespuestaIndexColaborador($campaniaID,$usuario){
		$data = array();
		$q = $this->db->query("SELECT er.usuarioAcalificar as 'usuario'
				FROM evaluacion_preguntas ep
				LEFT JOIN evaluacion_respuestas er ON er.preguntaID=ep.preguntaID
				WHERE ep.campaniaID='$campaniaID'
				AND er.usuarioAcalificar='$usuario'
				GROUP BY ep.campaniaID");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

	function verificaFormularioJefeDirecto($campaniaID,$usuarioID,$usuarioIdQueCalifica){
		$data = array();
		$q = $this->db->query("SELECT *
				FROM evaluacion_catalogoEvaluadores c
				WHERE c.campaniaID='$campaniaID'
				AND c.usuarioAcalificarID='$usuarioID'
				AND c.usuarioQuecalifica='$usuarioIdQueCalifica'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}
	
	function detalleCamp($campaniaID,$usuarioID){
		$data = array();
		$q = $this->db->query("SELECT max(r.tipo) as tipo FROM evaluacion_respuestas r
			LEFT JOIN evaluacion_catalogoEvaluadores c ON c.catalogoId = r.catalogoId
			WHERE c.campaniaID = '$campaniaID'
			AND c.usuarioAcalificarID = '$usuarioID'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}
	
	function cargaCampania($camcaniaID){
		$data = array();
		$q = $this->db->query("SELECT *
				FROM evaluacion_campanias ec
				WHERE ec.campaniaID='$camcaniaID'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

	function cargaCampaniasEvaluaciones($usuarioID){
		$data = array();
		$q = $this->db->query("SELECT *
				FROM evaluacion_campanias ec
				LEFT JOIN evaluacion_catalogoEvaluadores ece ON ec.campaniaID=ece.campaniaID
				WHERE ece.catalogoStatus='Activado' 
				AND (ece.usuarioQuecalifica='$usuarioID'
				OR ece.usuarioAcalificarID='$usuarioID')
				GROUP BY ec.campaniaID");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

	function cargaTodasEvaluaciones(){
		$data = array();
		$q = $this->db->query("SELECT * FROM evaluacion_campanias");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

	function checaContestacionesCampaniaUsuario($campaniaID, $usuarioAcalificar){
		$data = array();
		$q = $this->db->query("SELECT ec.usuarioAcalificarID as 'usuario'
						FROM evaluacion_respuestas er
						LEFT JOIN evaluacion_catalogoEvaluadores ec ON ec.catalogoId=er.catalogoId
						where ec.campaniaID='$campaniaID'
						and ec.usuarioAcalificarID='$usuarioAcalificar'
						group by ec.campaniaID='$campaniaID'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

	function cargaListadeEvaluaciones($usuarioID,$campaniaID){
		$data = array();
		$q = $this->db->query("SELECT
			ec.fechaInicio as 'Inicia',
			ec.fechaFin as 'Finaliza',
			ec.campaniaStatus as 'status',
			ece.campaniaID as 'campaniaID',
			ece.usuarioAcalificarID as 'usuarioID',
			u.nombreCompleto as 'nombreCompleto',
			u.email as 'email',
			u.puesto as 'puesto'
			FROM evaluacion_catalogoEvaluadores ece
			LEFT JOIN evaluacion_campanias ec ON ec.campaniaID=ece.campaniaID
			LEFT JOIN usuarios u ON u.usuarioID=ece.usuarioAcalificarID
			WHERE ece.usuarioQuecalifica='$usuarioID'
			AND ece.usuarioAcalificarID != '$usuarioID'
			AND ece.campaniaID='$campaniaID'
		");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

	function verificaProceso($usuarioID,$camId){
		$data = array();
		$q = $this->db->query("SELECT * FROM evaluacion_preguntas p 
			LEFT JOIN evaluacion_respuestas r ON p.preguntaID=r.preguntaID
			LEFT JOIN evaluacion_catalogoEvaluadores c ON c.catalogoId = r.catalogoId
			WHERE c.usuarioAcalificarID= '$usuarioID'
			AND p.campaniaID = '$camId' group by r.tipo");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}
	
	function verificaRespuesta($usuarioID, $tipo){
		$data = array();
		$q = $this->db->query("SELECT * FROM evaluacion_respuestas where usuarioAcalificar='$usuarioID' and tipo='$tipo' LIMIT 1");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

	function infoCampania($campaniaID){
		$data = array();
		$q = $this->db->query("SELECT * FROM evaluacion_campanias WHERE campaniaID='$campaniaID'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

	function respuestasPorPregunta($preguntaID,$usuarioID){
		$data = array();
		$q = $this->db->query("SELECT * FROM evaluacion_catalogoEvaluadores c
				LEFT JOIN evaluacion_respuestas r ON r.catalogoId = c.catalogoId
				WHERE r.preguntaID='$preguntaID' and c.usuarioAcalificarID='$usuarioID'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

	function validaEvala($usuarioQuecalifica,$usuarioAcalificarID,$campaniaID){
		$data = array();
		$q = $this->db->query("SELECT * FROM evaluacion_catalogoEvaluadores c
				LEFT JOIN evaluacion_respuestas r ON r.catalogoId = c.catalogoId
				WHERE c.usuarioQuecalifica='$usuarioQuecalifica'
				AND c.usuarioAcalificarID='$usuarioAcalificarID'
				AND r.tipo='1'
				AND c.campaniaID='$campaniaID'
				LIMIT 1");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

	function validaPermisosEvaluaciones($usuarioQuecalifica,$usuarioAcalificarID){
		$data = array();
		$q = $this->db->query("SELECT * FROM evaluacion_catalogoEvaluadores ece
			LEFT JOIN usuarios u ON u.usuarioID=ece.usuarioAcalificarID
			WHERE usuarioQuecalifica='$usuarioQuecalifica'
			AND usuarioAcalificarID='$usuarioAcalificarID'
		");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}
	
	function traeCatalogoId($usuarioQuecalifica,$usuarioAcalificarID,$campania){
		$data = array();
		$q = $this->db->query("SELECT catalogoId FROM evaluacion_catalogoEvaluadores
			WHERE usuarioQuecalifica='$usuarioQuecalifica'
			AND usuarioAcalificarID='$usuarioAcalificarID'
			AND campaniaID = '$campania'
		");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data = $row->catalogoId;
			}
			$q->free_result();
		}
		return $data;
	}

	function validaContestacion($campaniaID,$usuarioID){
		$data = array();
		$q = $this->db->query("SELECT * FROM evaluacion_respuestas er
			LEFT JOIN evaluacion_catalogoEvaluadores ec ON ec.catalogoId= er.catalogoId
			WHERE ec.campaniaID='$campaniaID'
			AND ec.usuarioQuecalifica='$usuarioID'
			GROUP BY ec.campaniaID");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

	function busquedaUsuariosAjax($nombre){
		$data = array();
		$q = $this->db->query("
		SELECT * FROM usuarios WHERE nombreCompleto like '%$nombre%'");
		if($q->num_rows() > 0) {
			foreach($q->result() as $row){
				$data[] = $row;
			}
			$q->free_result();
		}
		return $data;
	}

}
