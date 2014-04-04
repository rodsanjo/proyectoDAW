<?php
namespace controladores;

interface carrito_interface {

	
	
	
	public function meter(array $datos=array()) ;
	

	
	public function ver(array $datos = array()) ;
	
	
	
	public function vaciar(array $datos = array()) ;
	
	
	/**
	 * Recupera el carrito guardado en la base de datos.
	 * Si el usuario logueado tenía un carrito como anónimo y un carrito como usuario logueado
	 * se recupera el de fecha más reciente y el otro se destruye.
	 */
	public function recuperar() ;
	
	
	/**
	 * Ofrece al usuario el formulario para pagar.
	 * Si el usuario es anónimo debe loguearse primero.
	 * Si el usuario no está dado de alta en la aplicación, debe registrase, y confirmar el alta.
	 * 
	 */
	public function comprar() ;


	
	
	
	
} // Fin de la clase