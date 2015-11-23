<?php get_header(); ?>

    <div class="container">

      <div>

<p><?php the_title(); ?></p>

<canvas id="c" width="500" height="300"></canvas>
<style>
canvas { border: 1px solid #ccc }
</style>

<script src="<?php echo get_template_directory_uri(); ?>/js/canvas.js"></script>

<p>
  <button type="button" id="clear" class="btn btn-default btn-lg">絵を消す</button>
  <button type="button" id="save" class="btn btn-primary btn-lg">絵をメールする</button>
</p>

      </div>

    </div><!-- /.container -->

<?php get_footer(); ?>
