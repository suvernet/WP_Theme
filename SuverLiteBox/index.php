<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?= get_bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
<?php 
if (is_home() || is_front_page()) {
    bloginfo( 'name' ); // Название сайта
} else if (is_single() || is_page()) { // Посты и статичные страницы
    single_post_title(); echo ' | '; bloginfo( 'name' );
} else { // Архивы категорий/тегов
    wp_title('', true); echo ' | '; bloginfo( 'name' );
}
?>
</title>
    <!-- Подключаем стили -->
    <link rel="stylesheet" href="<?= get_stylesheet_uri(); ?>">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div class="container">


<!-- Шапка -->
<header class="site-header">
<?php
if ( is_front_page() || is_home() || is_front_page() && is_home() ) { echo '<h1>'; }
echo '<a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name' ) ) . '" rel="home" itemprop="url"><span itemprop="name">' . esc_html( get_bloginfo( 'name' ) ) . '</span></a>';
if ( is_front_page() || is_home() || is_front_page() && is_home() ) { echo '</h1>'; }
?>
    <!-- Бургер-меню -->
    <button id="menu-toggle">☰</button>

    <!-- Навигация -->
    <nav id="site-navigation" role="navigation" style="display:none;">
        <?php 
        wp_nav_menu(array(
            'theme_location' => 'primary-menu',
            'menu_id' => 'primary-menu'
        ));
        ?>
    </nav>
</header>
<div class="attachment_content">
<!-- Контент -->
<main class="content">
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <header>
            <h2 class="title_post"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        </header>
        <span class="date_author">Опубликовано: <?= get_the_date(); ?> | Автор: <?php the_author(); ?></span>
        <div class="entry-content">
            <?= is_single() || is_page() ? the_content() : the_content(); ?>
        </div>

        <footer class="post_footer">             
             Рубрика: <?= get_the_category_list(', '); ?><br>
             Теги: <?= get_the_tag_list('', ', ', ''); ?>
        </footer>
    </article>
    <?php if ( comments_open() || get_comments_number() ) { // Если комменты разрешены или есть хотя бы один комментарий ?>
    <?php 
        /* 
         * Функция comments_template() подключает файл comments.php из твоей темы.
         * По умолчанию WordPress использует стандартный шаблон комментариев,
         * поэтому тебе не обязательно создавать свой файл comments.php.
         */
        comments_template();
    ?>
<?php } ?>
<?php endwhile; else : ?>
    <p>Записей нет.</p>
<?php endif; ?>
</main>
<!-- Сайдбар (будет внизу или справа на десктопе) -->
<aside>
    <?php get_sidebar(); ?>
</aside>
</div> <!--  конец .attachment_content -->
<!-- Подвал -->
<footer>
    © <?= date('Y') ?> - <?= bloginfo('name'); ?>
</footer>

</div> <!-- /.container -->

<script>
// Простая логика открытия меню через CSS-селекторы
document.addEventListener("DOMContentLoaded", function () {
    const toggle = document.getElementById('menu-toggle');
    const nav = document.getElementById('site-navigation');

    toggle.onclick = function(e) {
        e.preventDefault();
        nav.style.display = nav.style.display === 'none' ? 'block' : 'none';
    };
});
</script>

<?php wp_footer(); ?>
</body>
</html>