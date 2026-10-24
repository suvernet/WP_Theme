<?php 
// Если комментарии отключены, ничего не показываем
if ( !comments_open() && !have_comments() ) { return; }
?>



<?php comment_form(); // Стандартная форма комментирования WP ?>

<?php if ( have_comments() ) : ?>
    <ol class="comment-list">
        <?php wp_list_comments( array( 'style' => 'ol' ) ); ?>
    </ol>
<?php endif; ?>