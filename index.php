<?php get_header(); ?>

    <div class="container">

      <div>

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
?>
<a class="btn btn-primary btn-lg btn-block" href="<?php echo get_permalink( $message->ID );?>" role="button"><?php echo $message->post_title;?></a>

<!--
<div class="alert alert-success" role="alert">メールを送信しました</div>
-->

<?php
    endforeach;
?>

      </div>

    </div><!-- /.container -->

<?php get_footer(); ?>
