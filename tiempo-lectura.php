<?php
/**
 * Plugin Name: Tiempo de lectura
 * Description: Muestra cuánto se tarda en leer cada entrada.
 * Version: 0.1
 * Author: Miguel Llácer
 * License: GPL v2 or later
 */

// Si alguien abre este archivo directamente, no hacemos nada.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
// Calcula cuántos minutos se tarda en leer un texto.
function tl_calcular_minutos( $texto ) {
	// Quitamos el HTML para contar solo las palabras.
	$texto    = wp_strip_all_tags( $texto );
	$palabras = count( preg_split( '/\s+/', $texto, -1, PREG_SPLIT_NO_EMPTY ) );

	// Una persona lee unas 200 palabras por minuto.
	$minutos = ceil( $palabras / 200 );

	// Como mínimo, 1 minuto.
	return max( 1, $minutos );
}

// Añade el tiempo de lectura antes del contenido de la entrada.
function tl_mostrar_tiempo( $contenido ) {
	// Solo en una entrada suelta, no en páginas ni en listados.
	if ( ! is_singular( 'post' ) ) {
		return $contenido;
	}

	$minutos = tl_calcular_minutos( $contenido );
	$aviso   = '<p class="tiempo-lectura">Tiempo de lectura: ' . $minutos . ' min</p>';

	return $aviso . $contenido;
}
add_filter( 'the_content', 'tl_mostrar_tiempo' );
