<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class EvaluacionesTwo_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	function evaluacionListaCategorias($campaniaID){
		$data = array();
		$q = $this->db->query("SELECT * FROM evaluacion_preguntas e
			LEFT JOIN evaluacion_categorias ec ON e.categoria=ec.evaluacionCategoriaID
			WHERE e.campaniaID='$campaniaID'
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
		$q = $this->db->query("SELECT * FROM catalogoDepartamentos");
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
			(select respuesta from evaluacion_respuestas where preguntaID=ep.preguntaID AND usuarioAcalificar='$usuarioID' and tipo='1') as 'autoevaluacion',
			(select respuesta from evaluacion_respuestas where preguntaID=ep.preguntaID AND usuarioAcalificar='$usuarioID' and tipo='2') as 'jefeDirecto',
			(select respuesta from evaluacion_respuestas where preguntaID=ep.preguntaID AND usuarioAcalificar='$usuarioID' and tipo='3') as 'plandeaccion'
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

	function verificaFormularioJefeDirecto($campaniaID,$usuarioID){
		$data = array();
		$q = $this->db->query("SELECT er.usuarioAcalificar as 'usuario'
				FROM evaluacion_preguntas ep
				LEFT JOIN evaluacion_respuestas er ON er.preguntaID=ep.preguntaID
				WHERE ep.campaniaID='$campaniaID'
				AND er.usuarioAcalificar='$usuarioID'
				AND er.tipo='2'
				GROUP BY ep.campaniaID");
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
				WHERE usuarioQuecalifica='$usuarioID'
				OR ece.usuarioAcalificarID='$usuarioID'
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
		$q = $this->db->query("SELECT usuarioAcalificar as 'usuario'
														FROM evaluacion_respuestas er
														LEFT JOIN evaluacion_preguntas ep ON er.preguntaID=ep.preguntaID
														where ep.campaniaID='$campaniaID'
														and usuarioAcalificar='$usuarioAcalificar'
														group by ep.campaniaID='$campaniaID'");
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

	function verificaProceso($usuarioID){
		$data = array();
		$q = $this->db->query("SELECT * FROM evaluacion_respuestas WHERE usuarioAcalificar='$usuarioID' group by tipo");
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
		$q = $this->db->query("SELECT * FROM evaluacion_respuestas where preguntaID='$preguntaID' and usuarioAcalificar='$usuarioID'");
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
		$q = $this->db->query("SELECT * FROM evaluacion_respuestas er
				LEFT JOIN evaluacion_preguntas ep ON ep.preguntaID=er.preguntaID
				WHERE er.usuarioQueCalifico='$usuarioQuecalifica'
				AND er.usuarioAcalificar='$usuarioAcalificarID'
				AND er.tipo='1'
				AND ep.campaniaID='$campaniaID'
				LIMIT 1
		");
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

	function validaContestacion($campaniaID,$usuarioID){
		$data = array();
		$q = $this->db->query("SELECT * FROM evaluacion_respuestas er
			LEFT JOIN evaluacion_preguntas ep ON er.preguntaID=ep.preguntaID
			WHERE campaniaID='$campaniaID'
			AND usuarioQueCalifico='$usuarioID'
			GROUP BY campaniaID");
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
