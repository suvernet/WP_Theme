<?php
add_action( 'after_setup_theme', 'whitepingvin_setup' );
function whitepingvin_setup() {
load_theme_textdomain( 'whitepingvin', get_template_directory() . '/languages' );
add_theme_support( 'title-tag' );
add_theme_support( 'automatic-feed-links' );
add_theme_support( 'post-thumbnails' );
add_theme_support( 'custom-logo' );
add_theme_support( 'html5', array( 'search-form', 'comment-list', 'comment-form', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' ) );
add_theme_support( 'responsive-embeds' );
add_theme_support( 'align-wide' );
add_theme_support( 'wp-block-styles' );
add_theme_support( 'editor-styles' );
add_editor_style( 'editor-style.css' );
add_theme_support( 'appearance-tools' );
add_theme_support( 'woocommerce' );
global $content_width;
if ( !isset( $content_width ) ) {
$content_width = 1920;
}
register_nav_menus( array( 'main-menu' => esc_html__( 'Main Menu', 'whitepingvin' ) ) );
}


add_action( 'wp_enqueue_scripts', 'whitepingvin_enqueue' );
function whitepingvin_enqueue() {
wp_enqueue_style( 'whitepingvin-style', get_stylesheet_uri() );
wp_enqueue_script( 'jquery' );
}
add_action( 'wp_footer', 'whitepingvin_footer' );
function whitepingvin_footer() {
?>
<script>
(function() {
const ua = navigator.userAgent.toLowerCase();
const html = document.documentElement;
if (/(iphone|ipod|ipad)/.test(ua)) {
html.classList.add('ios', 'mobile');
}
else if (/android/.test(ua)) {
html.classList.add('android', 'mobile');
}
else {
html.classList.add('desktop');
}
if (/chrome/.test(ua) && !/edg|brave/.test(ua)) {
html.classList.add('chrome');
}
else if (/safari/.test(ua) && !/chrome/.test(ua)) {
html.classList.add('safari');
}
else if (/edg/.test(ua)) {
html.classList.add('edge');
}
else if (/firefox/.test(ua)) {
html.classList.add('firefox');
}
else if (/brave/.test(ua)) {
html.classList.add('brave');
}
else if (/opr|opera/.test(ua)) {
html.classList.add('opera');
}
})();
</script>
<?php
}
add_filter( 'document_title_separator', 'whitepingvin_document_title_separator' );
function whitepingvin_document_title_separator( $sep ) {
$sep = esc_html( '|' );
return $sep;
}
add_filter( 'the_title', 'whitepingvin_title' );
function whitepingvin_title( $title ) {
if ( $title == '' ) {
return esc_html( '...' );
} else {
return wp_kses_post( $title );
}
}
function whitepingvin_schema_type() {
$schema = 'https://schema.org/';
if ( is_single() ) {
$type = "Article";
} elseif ( is_author() ) {
$type = 'ProfilePage';
} elseif ( is_search() ) {
$type = 'SearchResultsPage';
} else {
$type = 'WebPage';
}
echo 'itemscope itemtype="' . esc_url( $schema ) . esc_attr( $type ) . '"';
}
add_filter( 'nav_menu_link_attributes', 'whitepingvin_schema_url', 10 );
function whitepingvin_schema_url( $atts ) {
$atts['itemprop'] = 'url';
return $atts;
}
if ( !function_exists( 'whitepingvin_wp_body_open' ) ) {
function whitepingvin_wp_body_open() {
do_action( 'wp_body_open' );
}
}
add_action( 'wp_body_open', 'whitepingvin_skip_link', 5 );
function whitepingvin_skip_link() {
echo '<a href="#content" class="skip-link screen-reader-text">' . esc_html__( 'Skip to the content', 'whitepingvin' ) . '</a>';
}
add_filter( 'the_content_more_link', 'whitepingvin_read_more_link' );
function whitepingvin_read_more_link() {
if ( !is_admin() ) {
return ' <a href="' . esc_url( get_permalink() ) . '" class="more-link">' . sprintf( __( '...%s', 'whitepingvin' ), '<span class="screen-reader-text">  ' . esc_html( get_the_title() ) . '</span>' ) . '</a>';
}
}
add_filter( 'excerpt_more', 'whitepingvin_excerpt_read_more_link' );
function whitepingvin_excerpt_read_more_link( $more ) {
if ( !is_admin() ) {
global $post;
return ' <a href="' . esc_url( get_permalink( $post->ID ) ) . '" class="more-link">' . sprintf( __( '...%s', 'whitepingvin' ), '<span class="screen-reader-text">  ' . esc_html( get_the_title() ) . '</span>' ) . '</a>';
}
}
add_filter( 'big_image_size_threshold', '__return_false' );
add_filter( 'intermediate_image_sizes_advanced', 'whitepingvin_image_insert_override' );
function whitepingvin_image_insert_override( $sizes ) {
unset( $sizes['medium_large'] );
unset( $sizes['1536x1536'] );
unset( $sizes['2048x2048'] );
return $sizes;
}
add_action( 'widgets_init', 'whitepingvin_widgets_init' );
function whitepingvin_widgets_init() {
register_sidebar( array(
'name' => esc_html__( 'Sidebar Widget Area', 'whitepingvin' ),
'id' => 'primary-widget-area',
'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
'after_widget' => '</li>',
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
}
add_action( 'wp_head', 'whitepingvin_pingback_header' );
function whitepingvin_pingback_header() {
if ( is_singular() && pings_open() ) {
printf( '<link rel="pingback" href="%s">' . "\n", esc_url( get_bloginfo( 'pingback_url' ) ) );
}
}
add_action( 'comment_form_before', 'whitepingvin_enqueue_comment_reply_script' );
function whitepingvin_enqueue_comment_reply_script() {
if ( get_option( 'thread_comments' ) ) {
wp_enqueue_script( 'comment-reply' );
}
}
function whitepingvin_custom_pings( $comment ) {
?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>"><?php comment_author_link(); ?></li>
<?php
}
add_filter( 'get_comments_number', 'whitepingvin_comment_count', 0 );
function whitepingvin_comment_count( $count ) {
if ( !is_admin() ) {
global $id;
$get_comments = get_comments( 'status=approve&post_id=' . $id );
$comments_by_type = separate_comments( $get_comments );
return count( $comments_by_type['comment'] );
} else {
return $count;
}
}