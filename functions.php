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
    $wp_customize->add_setting( 'pigeon_setting_email_to', array( 'transport' => 'postMessage', ) );
    $wp_customize->add_control( new WP_Customize_Control(
        $wp_customize,
        'pigeon_email_to',
        array(
            'label' => __( '送信先メールアドレス（To）', 'pigeon_email_to' ),
            'section' => 'pigeon_setting_section',
            'settings' => 'pigeon_setting_email_to',
        )
    ));
    $wp_customize->add_setting( 'pigeon_setting_is_paint', array( 'transport' => 'postMessage', ) );
    $wp_customize->add_control( new WP_Customize_Control(
        $wp_customize,
        'pigeon_is_paint',
        array(
            'label' => __( 'ペイント使用', 'pigeon_is_paint' ),
            'section' => 'pigeon_setting_section',
            'settings' => 'pigeon_setting_is_paint',
            'type' => 'radio',
            'choices' => array(
                '1' => '使用する',
                '0' => '使用しない',
            ),
        )
    ));
}
add_action( 'customize_register', 'pigeon_customize_register' );

/**
 * スタイルシート読み込み
 */
function pigeon_enqueue_styles() {
    wp_enqueue_style ( 'pigeon-style', get_stylesheet_uri() );
    wp_enqueue_style ( 'pigeon-bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css' );
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
 * メール送信
 */
function pigeon_send_mail( $post_id = '', $base64 = '' ) {

    if ( !$post_id ) {
        return false;
    }

    // タイトル、本文
    $_post = get_post( $post_id );
    $subject = $_post->post_title;
    $content = $_post->post_content;

    // From
    $from = get_theme_mod( 'pigeon_setting_email_from', '' );
    if ( !$from ) {
        $from = get_option( 'admin_email' );
    }
    $headers = 'From:' . $from . "\r\n";

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

    $result = wp_mail( $to, $subject, $content, $headers, $attachments );

    return true;
}
