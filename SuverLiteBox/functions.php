<?php
/**
 * Настройки темы Suver Lite Box
 */
function suver_setup() {
    // Поддержка миниатюры записи
    add_theme_support('post-thumbnails');
    
    // Регистрация основного меню
    register_nav_menus(
        array(
            'primary-menu' => __('Главное меню', 'suver'),
        )
    );
}
add_action('after_setup_theme', 'suver_setup');

function suver_widgets_init() {
    register_sidebar([
        'name'          => __('Основная', 'suver'),
        'id'            => 'main-sidebar',
        'description'   => '',
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ]);
}
add_action( 'widgets_init', 'suver_widgets_init' );