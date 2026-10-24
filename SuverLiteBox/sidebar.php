<?php if (is_active_sidebar('main-sidebar')) : ?>
    <aside class="widget-area">
        <?php dynamic_sidebar( 'main-sidebar' ); ?> <!-- Здесь будут ваши виджеты -->
    </aside>
<?php else : ?>
    <p>Активируйте боковую панель "Основная" в настройках виджетов.</p>
<?php endif; ?>