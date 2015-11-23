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
//        echo '<a href="'.get_permalink( $message->ID ).'">'.$message->ID.'</a>';
//        echo "<br>\n";
//        echo $message->post_title;
//        echo "<br>\n";
//        echo get_post_meta( $message->ID, 'to', true );
//        echo "<br>\n";
//        echo get_post_meta( $message->ID, 'content', true );
//        echo "<br>\n";
//        echo get_post_meta( $message->ID, 'is_paint', true );
//        echo "<br>\n";
?>
<a class="btn btn-primary btn-lg btn-block" href="<?php echo get_permalink( $message->ID );?>" role="button"><?php echo $message->post_title;?></a>

<div class="alert alert-success" role="alert">メールを送信しました</div>

<?php
    endforeach;
?>

      </div>

    </div><!-- /.container -->

<?php get_footer(); ?>
