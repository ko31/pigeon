<?php get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

<?php
    $args = array(
        'posts_per_page'   => -1,
        'orderby'          => 'date',
        'order'            => 'ASC',
        'post_type'        => 'messages',
        'post_status'      => 'publish',
    );
    $messages = get_posts( $args );
    foreach ( $messages as $message ):
        echo '<a href="'.get_permalink( $message->ID ).'">'.$message->ID.'</a>';
        echo "<br>\n";
        echo $message->post_title;
        echo "<br>\n";
        echo get_post_meta( $message->ID, 'to', true );
        echo "<br>\n";
        echo get_post_meta( $message->ID, 'content', true );
        echo "<br>\n";
        echo get_post_meta( $message->ID, 'is_paint', true );
        echo "<br>\n";
    endforeach;
?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
