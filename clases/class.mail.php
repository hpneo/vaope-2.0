<?php
	class Mail{
		public $cabeceras;
		public $para;
		public $asunto;
		public $mensaje;
		
		function Mail($para, $asunto, $mensaje){
			$this->para = $para;
			$this->asunto = $asunto;
			$this->mensaje = $mensaje;
			$this->cabeceras  = 'MIME-Version: 1.0' . "\r\n";
			$this->cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";
			$this->cabeceras .= 'To: Contacto Vao Pe! <contacto@vaope.com>' . "\r\n";
			$this->cabeceras .= 'From: Contacto Vao Pe! <contacto@vaope.com>' . "\r\n";
		}
		function enviar(){
			if(@mail($this->para, $this->asunto, $this->mensaje, $this->cabeceras))
				return true;
			else
				return false;
		}
	}
?>