<?php get_header(); ?>

<div class="container">

    <h2><?php the_title(); ?></h2>

    <form method="post" id="messageform" class="form-horizontal" action="<?php echo esc_url( home_url( '/' ) ); ?>">
        <input type="hidden" id="post_id" name="post_id" value="<?php echo $post->ID;?>">
        <input type="hidden" id="base64" name="base64" value="">

        <div class="canvas">
            <canvas id="c" width="500" height="300"></canvas>
            <style>
            canvas { border: 1px solid #ccc }
            </style>
    
            <p>
            <button type="button" id="send-btn" class="btn btn-primary btn-lg">この絵をメールする</button>
            <button type="button" id="clear-btn" class="btn btn-default btn-lg">絵を書き直す</button>
            </p>
        </div><!-- /.canvas -->

    </form>

</div><!-- /.container -->

<script src="<?php echo get_template_directory_uri(); ?>/js/canvas.js"></script>

<?php get_footer(); ?>
