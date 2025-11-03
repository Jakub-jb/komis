<?php
/**
 * Breadcrumbs.
 *
 * @package pablo-gp
 */

/**
 * Display breadcrumbs markup.
 */
function pablo_gp_breadcrumbs() {
if ( is_front_page() ) {
return;
}

$items = [
[ 'label' => __( 'Startseite', 'pablo-gp' ), 'url' => home_url() ],
];

if ( is_singular() ) {
global $post;

$post_type = get_post_type_object( get_post_type( $post ) );

if ( $post_type && ! is_page() && ! is_single() ) {
$items[] = [
'label' => $post_type->labels->name,
'url'   => get_post_type_archive_link( $post_type->name ),
];
}

$ancestors = array_reverse( get_post_ancestors( $post ) );
foreach ( $ancestors as $ancestor ) {
$items[] = [
'label' => get_the_title( $ancestor ),
'url'   => get_permalink( $ancestor ),
];
}

$items[] = [ 'label' => get_the_title( $post ), 'url' => '' ];
} elseif ( is_archive() ) {
$items[] = [ 'label' => get_the_archive_title(), 'url' => '' ];
} elseif ( is_search() ) {
$items[] = [ 'label' => sprintf( __( 'Suche: %s', 'pablo-gp' ), get_search_query() ), 'url' => '' ];
} elseif ( is_404() ) {
$items[] = [ 'label' => __( 'Seite nicht gefunden', 'pablo-gp' ), 'url' => '' ];
}

if ( empty( $items ) ) {
return;
}

echo '<nav class="breadcrumb" aria-label="' . esc_attr__( 'Breadcrumb', 'pablo-gp' ) . '">';
echo '<ol class="breadcrumb__list" itemscope itemtype="https://schema.org/BreadcrumbList">';

foreach ( $items as $index => $item ) {
$position = $index + 1;
echo '<li class="breadcrumb__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
if ( ! empty( $item['url'] ) ) {
echo '<a class="breadcrumb__link" itemprop="item" href="' . esc_url( $item['url'] ) . '"><span itemprop="name">' . esc_html( $item['label'] ) . '</span></a>';
} else {
echo '<span class="breadcrumb__current" itemprop="name">' . esc_html( $item['label'] ) . '</span>';
}
echo '<meta itemprop="position" content="' . esc_attr( $position ) . '" />';
echo '</li>';
}

echo '</ol>';
echo '</nav>';
}
