<?php
/**
 * pigeon functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package pigeon
 */

/**
 * カスタム投稿
 */
add_action('init', 'pigeon_add_message_post_type');
function pigeon_add_message_post_type(){
    $params = array(
        'labels' => array(
            'name' => 'メッセージ',
            'singular_name' => 'メッセージ',
            'add_new' => '新規追加',
            'add_new_item' => 'メッセージを新規追加',
            'edit_item' => 'メッセージを編集する',
            'new_item' => '新規メッセージ',
            'all_items' => 'メッセージ一覧',
            'view_item' => 'メッセージの説明を見る',
            'search_items' => '検索する',
            'not_found' => 'メッセージが見つかりませんでした。',
            'not_found_in_trash' => 'ゴミ箱内にメッセージが見つかりませんでした。',
        ),
        'rewrite' => false,
        'public' => true,
        'has_archive' => true,
        'supports' => array(
            'title',
            'editor',
        )
    );
    register_post_type('messages', $params);
}

/**
 * テーマカスタマイザーにテーマ基本設定を追加
 */
function pigeon_customize_register( $wp_customize ) {
    // セクション設定
    $wp_customize->add_section(
        'pigeon_setting_section',
        array(
            'title' => __( 'テーマ基本設定', 'pigeon' ),
            'priority' => 130,
        )
    );
    // コントロール設定
    $wp_customize->add_setting( 'pigeon_setting_email_from', array( 'transport' => 'postMessage', ) );
    $wp_customize->add_control( new WP_Customize_Control(
        $wp_customize,
        'pigeon_email_from',
        array(
            'label' => __( '送信元メールアドレス（From）', 'pigeon_email_from' ),
            'section' => 'pigeon_setting_section',
            'settings' => 'pigeon_setting_email_from',
        )
    ));
    $wp_customize->add_setting( 'pigeon_setting_email_reply', array( 'transport' => 'postMessage', ) );
    $wp_customize->add_control( new WP_Customize_Control(
        $wp_customize,
        'pigeon_email_reply',
        array(
            'label' => __( '返信先メールアドレス（Reply-To）', 'pigeon_email_reply' ),
            'section' => 'pigeon_setting_section',
            'settings' => 'pigeon_setting_email_reply',
        )
    ));
    $wp_customize->add_setting( 'pigeon_setting_email_to', array( 'transport' => 'postMessage', ) );
    $wp_customize->add_control( new WP_Customize_Control(
        $wp_customize,
        'pigeon_email_to',
        array(
            'label' => __( '送信先メールアドレス（To）', 'pigeon_email_to' ),
            'description' => __( '※カンマ区切りで複数指定可', 'pigeon_email_to' ),
            'section' => 'pigeon_setting_section',
            'settings' => 'pigeon_setting_email_to',
        )
    ));
    $wp_customize->add_setting( 'pigeon_setting_line_token', array( 'transport' => 'postMessage', ) );
    $wp_customize->add_control( new WP_Customize_Control(
        $wp_customize,
        'pigeon_line_token',
        array(
            'label' => __( 'LINE Notify アクセストークン', 'pigeon_line_token' ),
            'description' => __( '<a href="https://notify-bot.line.me/ja/">LINE Notify</a> に通知したい場合、アクセストークンを入力してください', 'pigeonline_token' ),
            'section' => 'pigeon_setting_section',
            'settings' => 'pigeon_setting_line_token',
        )
    ));
    $wp_customize->add_setting( 'pigeon_setting_is_paint', array( 'transport' => 'postMessage', ) );
    $wp_customize->add_control( new WP_Customize_Control(
        $wp_customize,
        'pigeon_is_paint',
        array(
            'label' => __( 'ペイント使用', 'pigeon_is_paint' ),
            'description' => __( 'お絵かき画像をメールに添付できるペイント機能を使用するかどうか選択してください', 'pigeon_is_paint' ),
            'section' => 'pigeon_setting_section',
            'settings' => 'pigeon_setting_is_paint',
            'type' => 'radio',
            'choices' => array(
                '1' => '使用する',
                '0' => '使用しない',
            ),
        )
    ));
    $wp_customize->add_setting( 'pigeon_setting_user_agent', array( 'transport' => 'postMessage', ) );
    $wp_customize->add_control( new WP_Customize_Control(
        $wp_customize,
        'pigeon_user_agent',
        array(
            'label' => __( 'アクセス許可端末', 'pigeon_user_agent' ),
            'description' => __( 'アクセス許可する端末のユーザーエージェント文字列の一部を入力してください（※カンマ区切りで複数指定可）', 'pigeon_user_agent' ),
            'section' => 'pigeon_setting_section',
            'settings' => 'pigeon_setting_user_agent',
        )
    ));
}
add_action( 'customize_register', 'pigeon_customize_register' );

/**
 * スタイルシート読み込み
 */
function pigeon_enqueue_styles() {
    wp_enqueue_style ( 'pigeon-bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css' );
    wp_enqueue_style ( 'pigeon-style', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'pigeon_enqueue_styles' );

/**
 * JavaScript読み込み
 */
function pigeon_enqueue_scripts() {
    wp_enqueue_script ( 'jquery' );
    wp_enqueue_script ( 'html5shiv', get_template_directory_uri() . '/js/html5shiv.min.js' );
    wp_script_add_data( 'html5shiv', 'conditional', 'lt IE 9' );
    wp_enqueue_script ( 'respond', get_template_directory_uri() . '/js/respond.min.js' );
}
add_action( 'wp_enqueue_scripts', 'pigeon_enqueue_scripts' );

/**
 * アクセス許可端末チェック
 */
function pigeon_is_allowed_user_agent() {
    if ( !is_user_logged_in() ) {
        $user_agent = get_theme_mod( 'pigeon_setting_user_agent', '' );
        if ( $user_agent ) {
            $user_agents = explode( ",", $user_agent );
            $pattern = '/' . implode( '|', $user_agents ) . '/i';
            if ( !preg_match( $pattern, $_SERVER['HTTP_USER_AGENT'] ) ){
                header( "HTTP/1.0 403 Forbidden" ); 
                echo "<h1>403 Forbidden</h1>";
                exit;
            }
        }
    }
}
add_action( 'wp_head', 'pigeon_is_allowed_user_agent' );

/**
 * メール送信
 */
function pigeon_send_mail( $post_id = '', $base64 = '' ) {

    if ( !$post_id ) {
        return false;
    }

    $_post = get_post( $post_id );
    if ( !$_post ) {
        return false;
    }

    // タイトル、本文
    $subject = $_post->post_title;
    $content = $_post->post_content;

    $headers = array();

    // From
    $from = get_theme_mod( 'pigeon_setting_email_from', '' );
    if ( $from ) {
        $headers[] = 'From:' . $from;
    }

    // Reply-To
    $reply = get_theme_mod( 'pigeon_setting_email_reply', '' );
    if ( $reply ) {
        $headers[] = 'Reply-to:' . $reply;
    }

    // To
    $to = get_theme_mod( 'pigeon_setting_email_to', '' );
    if ( !$to ) {
        $to = get_option( 'admin_email' );
    }

    // 添付画像ファイル
    $attachments = '';
    if ( $base64 ) {
        $upload_dir = wp_upload_dir();
        $_image = $upload_dir['basedir'] . '/pigeon_'.$post_id.'.jpg';
        $fp = fopen( $_image, 'w' );
        $base64 = str_replace( 'data:image/jpeg;base64,', '', $base64 );
        fwrite( $fp, base64_decode( $base64 ) );
        fclose( $fp );
        $attachments = array( $_image );
    }

    // メール送信
    $result = wp_mail( $to, $subject, $content, $headers, $attachments );

    // LINE Notify 通知
    $token = get_theme_mod( 'pigeon_setting_line_token', '' );
    if ( $token ) {
        if ( $base64 ) {
            $_image = $upload_dir['basedir'] . '/pigeon_'.$post_id.'.jpg';
            $image_notify = $upload_dir['basedir'] . '/pigeon_' . date( 'YmdHis' ) . '.jpg';
            copy( $_image, $image_notify);
            $image_notify_url = $upload_dir['baseurl'] . '/pigeon_' . date( 'YmdHis' ) . '.jpg';
            my_send_linenotify( $token, $content, $image_notify_url, $image_notify_url );
        } else {
            my_send_linenotify( $token, $content );
        }
    }

    return true;
}

/**
 * LINE Notify 通知
 */
if ( ! function_exists( 'my_send_linenotify' ) ) {
    function my_send_linenotify( $token, $message, $image_thumbnail = '', $image_fullsize = '' ) {
        $url = 'https://notify-api.line.me/api/notify';
        $response = wp_remote_post( $url, array(
            'method' => 'POST',
            'headers' => array(
                'Authorization' => 'Bearer '.$token,
            ),
            'body' => array(
                'message' => $message,
                'imageThumbnail' => $image_thumbnail,
                'imageFullsize' => $image_fullsize,
            ),
        ));
        if ( is_wp_error( $response ) ) {
            $error_message = $response->get_error_message();
            echo "Error: $error_message";
            return false;
        }

        return true;
    }
}
