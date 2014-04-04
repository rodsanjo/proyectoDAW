<?php

namespace modelos;

/**
 * Description of ClaseCarrito
 * 
 * Los carritos se guardan en la bd y se borrarán si tienen más de 15 días.
 *
 * @author jesus
 */
interface carrito_interface {
	
//	private $id = null;
//	private $fechaHoraInicio = null;
//	private $articulos = array();
	
	
	public function __construct($id) ;
	
	
	public static function recuperar($id) ;
		
	
	/**
	 * LLeva el objeto carrito desde el objeto hasta la capa de persistencia (bd).
	 */
	public function persistir() ;
	
	
	
	public function cambiar_id($id) ;
	
	
	public function meter($articulo) ;
	
	
	
	
	public function corregir($articulo) ;
	
	
	
	public function quitar($articulo) ;
	
	
	public function vaciar() ;
	
	
	
	public function contador_articulos() ;
	
	
	public function get_valor();
	
	public function get_articulos() ;
	
	
	public function get_fechaHoraInicio() ;
	
}
