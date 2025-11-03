<?php
/**
 * Custom post type for vehicles.
 *
 * @package pablo-gp
 */

/**
 * Register CPT.
 */
function pablo_gp_register_cpt() {
$labels = [
'name'               => _x( 'Fahrzeuge', 'post type general name', 'pablo-gp' ),
'singular_name'      => _x( 'Fahrzeug', 'post type singular name', 'pablo-gp' ),
'menu_name'          => _x( 'Fahrzeuge', 'admin menu', 'pablo-gp' ),
'name_admin_bar'     => _x( 'Fahrzeug', 'add new on admin bar', 'pablo-gp' ),
'add_new'            => _x( 'Neu hinzufügen', 'fahrzeug', 'pablo-gp' ),
'add_new_item'       => __( 'Neues Fahrzeug', 'pablo-gp' ),
'new_item'           => __( 'Neues Fahrzeug', 'pablo-gp' ),
'edit_item'          => __( 'Fahrzeug bearbeiten', 'pablo-gp' ),
'view_item'          => __( 'Fahrzeug ansehen', 'pablo-gp' ),
'all_items'          => __( 'Alle Fahrzeuge', 'pablo-gp' ),
'view_items'         => __( 'Fahrzeuge ansehen', 'pablo-gp' ),
'search_items'       => __( 'Fahrzeuge durchsuchen', 'pablo-gp' ),
'not_found'          => __( 'Keine Fahrzeuge gefunden.', 'pablo-gp' ),
'not_found_in_trash' => __( 'Keine Fahrzeuge im Papierkorb.', 'pablo-gp' ),
];

$args = [
'labels'             => $labels,
'public'             => true,
'has_archive'        => true,
'show_in_rest'       => true,
'supports'           => [ 'title', 'editor', 'excerpt', 'thumbnail', 'revisions' ],
'menu_icon'          => 'dashicons-car',
'rewrite'            => [ 'slug' => 'fahrzeuge' ],
'capability_type'    => 'post',
'menu_position'      => 20,
];

register_post_type( 'fahrzeuge', $args );
}
add_action( 'init', 'pablo_gp_register_cpt' );
