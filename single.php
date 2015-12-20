<?php get_header(); ?>

<div class="container">

    <div class="canvas">

        <p><?php the_title(); ?></p>

        <canvas id="c" width="500" height="300"></canvas>
        <style>
        canvas { border: 1px solid #ccc }
        </style>

        <p>
        <button type="button" id="clear" class="btn btn-default btn-lg">絵を消す</button>
        <button type="button" id="save" class="btn btn-primary btn-lg">絵をメールする</button>
        </p>

        <input type="hidden" id="post_id" name="post_id" value="<?php echo $post->ID;?>">
        <input type="hidden" id="base64" name="base64" value="">

    </div>

</div><!-- /.container -->

<script src="<?php echo get_template_directory_uri(); ?>/js/canvas.js"></script>

<?php get_footer(); ?>
