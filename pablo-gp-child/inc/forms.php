<?php
/**
 * Form handling.
 *
 * @package pablo-gp
 */

/**
 * Register REST endpoint for form submissions.
 */
function pablo_gp_register_form_routes() {
register_rest_route(
'pablo-gp/v1',
'/form/(?P<slug>[a-z0-9\-]+)',
[
'methods'             => 'POST',
'callback'            => 'pablo_gp_handle_form_submission',
'permission_callback' => '__return_true',
]
);
}
add_action( 'rest_api_init', 'pablo_gp_register_form_routes' );

/**
 * Handle forms.
 *
 * @param WP_REST_Request $request Request.
 *
 * @return WP_REST_Response
 */
function pablo_gp_handle_form_submission( WP_REST_Request $request ) {
$params = $request->get_json_params();

if ( empty( $params['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $params['nonce'] ) ), 'pablo_gp_forms' ) ) {
return new WP_REST_Response( [ 'success' => false, 'message' => __( 'Ungültige Anfrage.', 'pablo-gp' ) ], 403 );
}

$slug = sanitize_key( $request->get_param( 'slug' ) );

$forms = [
'abschlepp' => [
'label'   => __( 'Abschlepp-Anfrage', 'pablo-gp' ),
'fields'  => [ 'name', 'phone', 'location', 'vehicle', 'message', 'privacy' ],
],
'ankauf'   => [
'label'  => __( 'Fahrzeugankauf', 'pablo-gp' ),
'fields' => [ 'name', 'phone', 'brand', 'model', 'year', 'mileage', 'message', 'privacy' ],
],
'transport' => [
'label'  => __( 'Transportanfrage', 'pablo-gp' ),
'fields' => [ 'name', 'phone', 'from', 'to', 'date', 'weight', 'message', 'privacy' ],
],
];

if ( ! isset( $forms[ $slug ] ) ) {
return new WP_REST_Response( [ 'success' => false, 'message' => __( 'Formular nicht gefunden.', 'pablo-gp' ) ], 404 );
}

$data = [];

foreach ( $forms[ $slug ]['fields'] as $field ) {
$value = isset( $params[ $field ] ) ? sanitize_text_field( wp_unslash( $params[ $field ] ) ) : '';

if ( 'privacy' === $field && '1' !== $value ) {
return new WP_REST_Response( [ 'success' => false, 'message' => __( 'Bitte stimmen Sie der Datenverarbeitung zu.', 'pablo-gp' ) ], 422 );
}

if ( in_array( $field, [ 'name', 'phone' ], true ) && empty( $value ) ) {
return new WP_REST_Response( [ 'success' => false, 'message' => __( 'Bitte Pflichtfelder ausfüllen.', 'pablo-gp' ) ], 422 );
}

$data[ $field ] = $value;
}

$to      = get_option( 'admin_email' );
$subject = sprintf( '%s - %s', get_bloginfo( 'name' ), $forms[ $slug ]['label'] );
$message = "Formular: {$forms[$slug]['label']}\n\n";

foreach ( $data as $field => $value ) {
$message .= ucfirst( $field ) . ': ' . $value . "\n";
}

wp_mail( $to, $subject, $message );

pablo_gp_log_form_submission( $slug, $data );

return new WP_REST_Response( [ 'success' => true, 'message' => __( 'Danke! Wir melden uns umgehend.', 'pablo-gp' ) ], 200 );
}

/**
 * Log submissions.
 *
 * @param string $slug Slug.
 * @param array  $data Data.
 */
function pablo_gp_log_form_submission( $slug, $data ) {
$logs = get_option( 'pablo_gp_form_logs', [] );

$logs[] = [
'slug'  => $slug,
'data'  => $data,
'time'  => current_time( 'mysql' ),
'ip'    => isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '',
];

update_option( 'pablo_gp_form_logs', $logs, false );
}

/**
 * Provide nonce to frontend.
 */
function pablo_gp_form_data() {
wp_localize_script(
'pablo-gp-forms',
'pabloForms',
[
'endpoint' => esc_url_raw( rest_url( 'pablo-gp/v1/form/' ) ),
'nonce'    => wp_create_nonce( 'pablo_gp_forms' ),
'success'  => __( 'Danke! Wir melden uns umgehend.', 'pablo-gp' ),
'error'    => __( 'Fehler beim Senden. Bitte versuchen Sie es erneut.', 'pablo-gp' ),
]
);
}
add_action( 'wp_enqueue_scripts', 'pablo_gp_form_data', 30 );
