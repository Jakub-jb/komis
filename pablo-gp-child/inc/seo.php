<?php
/**
 * SEO enhancements.
 *
 * @package pablo-gp
 */

/**
 * Output meta tags.
 */
function pablo_gp_meta_tags() {
if ( is_admin() ) {
return;
}

$title       = wp_get_document_title();
$description = get_bloginfo( 'description' );
$url         = ( is_singular() ) ? get_permalink() : home_url( add_query_arg( [] ) );
$image       = get_theme_mod( 'custom_logo' ) ? wp_get_attachment_image_url( get_theme_mod( 'custom_logo' ), 'full' ) : pablo_gp_asset( 'assets/images/og-placeholder.jpg' );

if ( is_singular() ) {
$singular_description = get_post_meta( get_the_ID(), '_pablo_meta_description', true );
if ( $singular_description ) {
$description = $singular_description;
} elseif ( has_excerpt() ) {
$description = wp_strip_all_tags( get_the_excerpt() );
}
}

echo '<meta name="description" content="' . esc_attr( $description ) . '" />';
echo '<link rel="canonical" href="' . esc_url( $url ) . '" />';
echo '<meta property="og:type" content="' . ( is_singular() ? 'article' : 'website' ) . '" />';
echo '<meta property="og:title" content="' . esc_attr( $title ) . '" />';
echo '<meta property="og:description" content="' . esc_attr( $description ) . '" />';
echo '<meta property="og:url" content="' . esc_url( $url ) . '" />';
echo '<meta property="og:image" content="' . esc_url( $image ) . '" />';
echo '<meta name="twitter:card" content="summary_large_image" />';
echo '<meta name="twitter:title" content="' . esc_attr( $title ) . '" />';
echo '<meta name="twitter:description" content="' . esc_attr( $description ) . '" />';
echo '<meta name="twitter:image" content="' . esc_url( $image ) . '" />';

pablo_gp_output_hreflang();
}
add_action( 'wp_head', 'pablo_gp_meta_tags', 1 );

/**
 * Prev/next pagination links for archives.
 */
function pablo_gp_rel_links() {
if ( is_singular() ) {
$previous = get_adjacent_post( false, '', true );
$next     = get_adjacent_post( false, '', false );

if ( $previous ) {
echo '<link rel="prev" href="' . esc_url( get_permalink( $previous ) ) . '" />';
}
if ( $next ) {
echo '<link rel="next" href="' . esc_url( get_permalink( $next ) ) . '" />';
}
}

if ( is_archive() && get_query_var( 'paged' ) > 1 ) {
global $wp_query;
$paged = (int) get_query_var( 'paged' );
if ( $paged > 1 ) {
echo '<link rel="prev" href="' . esc_url( get_pagenum_link( $paged - 1 ) ) . '" />';
}
if ( $paged < $wp_query->max_num_pages ) {
echo '<link rel="next" href="' . esc_url( get_pagenum_link( $paged + 1 ) ) . '" />';
}
}
}
add_action( 'wp_head', 'pablo_gp_rel_links', 3 );

/**
 * Output hreflang tags for DE/EN/PL (placeholder URLs).
 */
function pablo_gp_output_hreflang() {
$languages = [
'de' => home_url( '/de/' ),
'en' => home_url( '/en/' ),
'pl' => home_url( '/pl/' ),
];

foreach ( $languages as $lang => $link ) {
echo '<link rel="alternate" hreflang="' . esc_attr( $lang ) . '" href="' . esc_url( $link ) . '" />';
}
echo '<link rel="alternate" hreflang="x-default" href="' . esc_url( home_url( '/de/' ) ) . '" />';
}

/**
 * Register meta box for description.
 */
function pablo_gp_meta_box() {
add_meta_box( 'pablo_meta_description', __( 'Meta Description', 'pablo-gp' ), 'pablo_gp_meta_box_callback', [ 'post', 'page', 'fahrzeuge' ], 'side', 'default' );
}
add_action( 'add_meta_boxes', 'pablo_gp_meta_box' );

/**
 * Meta box callback.
 */
function pablo_gp_meta_box_callback( $post ) {
$value = get_post_meta( $post->ID, '_pablo_meta_description', true );
nonce_field( 'pablo_meta_description', 'pablo_meta_description_nonce' );
echo '<textarea style="width:100%;min-height:100px;" name="pablo_meta_description">' . esc_textarea( $value ) . '</textarea>';
}

/**
 * Save meta description.
 */
function pablo_gp_save_meta_description( $post_id ) {
if ( ! isset( $_POST['pablo_meta_description_nonce'] ) || ! wp_verify_nonce( wp_unslash( $_POST['pablo_meta_description_nonce'] ), 'pablo_meta_description' ) ) {
return;
}

if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
return;
}

if ( isset( $_POST['pablo_meta_description'] ) ) {
update_post_meta( $post_id, '_pablo_meta_description', sanitize_text_field( wp_unslash( $_POST['pablo_meta_description'] ) ) );
}
}
add_action( 'save_post', 'pablo_gp_save_meta_description' );
