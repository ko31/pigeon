<?php get_header(); ?>

<?php
// ペイント使用有無チェック
$is_paint = get_theme_mod( 'pigeon_setting_is_paint', '' );
?>

<div class="container">

<?php
// POST時はメール送信を行う
if ( isset( $_POST['_wpnonce'] ) && wp_verify_nonce( $_POST['_wpnonce'], 'pigeon_nonce' ) ):
    $post_id = $_POST['post_id'];
    $base64 = isset( $_POST['base64'] ) ? $_POST['base64'] : '';
    $result = pigeon_send_mail( $post_id, $base64 );
    if ( $result ):
?>
        <div class="alert alert-success" role="alert">メールを送信しました</div>
<?php
    else:
?>
        <div class="alert alert-danger" role="alert">メールの送信に失敗しました</div>
<?php
    endif;
endif;
?>

<?php
// カスタム投稿メッセージ取得
$args = array(
    'posts_per_page'   => -1,
    'orderby'          => 'date',
    'order'            => 'ASC',
    'post_type'        => 'messages',
    'post_status'      => 'publish',
);
$posts = get_posts( $args );

if ( $posts ):
?>
    <form method="post" id="messageform" class="form-horizontal" action="<?php echo esc_url( home_url( '/' ) ); ?>">
        <input type="hidden" id="post_id" name="post_id" value="" />
        <?php wp_nonce_field( 'pigeon_nonce' );?>
<?php
    foreach ( $posts as $post ):
?>
        <p class="message_list">
<?php
        if ( $is_paint ):
?>
            <a class="btn btn-primary btn-lg btn-block" href="<?php echo get_permalink( $post->ID );?>" role="button"><?php echo $post->post_title;?></a>
<?php
        else:
?>
            <button type="button" id="send_<?php echo $post->ID;?>" class="btn btn-primary btn-lg btn-block send-btn" data-id="<?php echo $post->ID;?>"><?php echo $post->post_title;?></button>
<?php
        endif;
?>
        </p>
<?php
    endforeach;
?>
    </form>
<?php
else:
?>
        <p class="message_list">メッセージが登録されていません。</a>
<?php
endif;
?>

</div><!-- /.container -->

<?php
if ( !$is_paint ):
?>
<script src="<?php echo get_template_directory_uri(); ?>/js/mail.js"></script>
<?php
endif;
?>

<?php get_footer(); ?>
