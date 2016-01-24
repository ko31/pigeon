<?php get_header(); ?>

<div class="container">

    <h2><?php the_title(); ?></h2>

    <form method="post" id="messageform" class="form-horizontal" action="<?php echo esc_url( home_url( '/' ) ); ?>">
        <input type="hidden" id="post_id" name="post_id" value="<?php echo $post->ID;?>">
        <input type="hidden" id="base64" name="base64" value="">
        <?php wp_nonce_field( 'pigeon_nonce' );?>

        <div id="canvas_area">
            <canvas id="canvas"></canvas>
            <p>
            <button type="button" id="send-btn" class="btn btn-primary btn-lg">メールを送る</button>
            <button type="button" id="clear-btn" class="btn btn-default btn-lg">絵を消す</button>
            </p>
        </div><!-- /#canvas_area -->

    </form>

</div><!-- /.container -->

<script src="<?php echo get_template_directory_uri(); ?>/js/canvas.js"></script>

<?php get_footer(); ?>
