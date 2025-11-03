<?php
/**
 * Taxonomies for vehicles.
 *
 * @package pablo-gp
 */

/**
 * Register taxonomies.
 */
function pablo_gp_register_taxonomies() {
$categories_labels = [
'name'          => __( 'Fahrzeugkategorien', 'pablo-gp' ),
'singular_name' => __( 'Fahrzeugkategorie', 'pablo-gp' ),
];

register_taxonomy(
'fahrzeug_kategorie',
'fahrzeuge',
[
'labels'            => $categories_labels,
'hierarchical'      => true,
'show_admin_column' => true,
'show_in_rest'      => true,
]
);

$brand_labels = [
'name'          => __( 'Marken', 'pablo-gp' ),
'singular_name' => __( 'Marke', 'pablo-gp' ),
];

register_taxonomy(
'marke',
'fahrzeuge',
[
'labels'            => $brand_labels,
'hierarchical'      => false,
'show_admin_column' => true,
'show_in_rest'      => true,
]
);
}
add_action( 'init', 'pablo_gp_register_taxonomies' );
