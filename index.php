<?php get_header(); ?>

    <div class="container">

      <div>

<?php
    $is_paint = get_theme_mod( 'pigeon_setting_is_paint', '' );

    $args = array(
        'posts_per_page'   => -1,
        'orderby'          => 'date',
        'order'            => 'ASC',
        'post_type'        => 'messages',
        'post_status'      => 'publish',
    );
    $posts = get_posts( $args );

    foreach ( $posts as $post ):
        if ( $is_paint ):
?>
<a class="btn btn-primary btn-lg btn-block" href="<?php echo get_permalink( $post->ID );?>" role="button"><?php echo $post->post_title;?></a>
<?php
        else:
?>

<button type="button" id="send_<?php echo $post->ID;?>" class="btn btn-primary btn-lg btn-block send" data-id="<?php echo $post->ID;?>"><?php echo $post->post_title;?></button>

<?php
        endif;
    endforeach;
?>

      </div>

<!--
<div id="success_<?php echo $post->ID;?>" class="alert alert-success" role="alert">メールを送信しました</div>

<div id="warning_<?php echo $post->ID;?>" class="alert alert-warning" role="alert">メール送信に失敗しました</div>
-->

    </div><!-- /.container -->

<?php
    if ( !$is_paint ):
?>
<script src="<?php echo get_template_directory_uri(); ?>/js/mail.js"></script>
<?php
    endif;
?>

<?php get_footer(); ?>
