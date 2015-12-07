<?php
/**
 * pigeon functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package pigeon
 */

/**
 * Advanced Custom Fields プラグインのビジュアルインターフェースを取り除く
 */
define( 'ACF_LITE', true );

/**
 * Advanced Custom Fields プラグイン読み込み
 */
include_once('advanced-custom-fields/acf.php');

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
        )
    );
    register_post_type('messages', $params);
}

/**
 * カスタム投稿用のカスタムフィールド設定
 */
if(function_exists("register_field_group"))
{
    register_field_group(array (
        'id' => 'pigeon_messages',
        'title' => 'メッセージ',
        'fields' => array (
            array (
                'key' => 'messages_to',
                'label' => 'メールアドレス',
                'name' => 'to',
                'type' => 'email',
                'instructions' => '送信先のメールアドレスを指定してください。
    （複数アドレスを指定する場合はカンマ区切りで入力してください。）',
                'required' => 1,
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
            ),
            array (
                'key' => 'messages_content',
                'label' => '本文',
                'name' => 'content',
                'type' => 'textarea',
                'instructions' => '送信時のメール本文を指定してください。',
                'default_value' => '',
                'placeholder' => '',
                'maxlength' => '',
                'rows' => '',
                'formatting' => 'br',
            ),
            array (
                'key' => 'messages_is_paint',
                'label' => 'ペイント使用',
                'name' => 'is_paint',
                'type' => 'radio',
                'instructions' => 'ペイント機能の使用可否を選択してください。',
                'choices' => array (
                    1 => '使用する',
                    0 => '使用しない',
                ),
                'other_choice' => 0,
                'save_other_choice' => 0,
                'default_value' => '',
                'layout' => 'horizontal',
            ),
        ),
        'location' => array (
            array (
                array (
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'messages',
                    'order_no' => 0,
                    'group_no' => 0,
                ),
            ),
        ),
        'options' => array (
            'position' => 'normal',
            'layout' => 'no_box',
            'hide_on_screen' => array (
            ),
        ),
        'menu_order' => 0,
    ));
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
    $wp_customize->add_setting( 'pigeon_email_from', array( 'default' => '', ) );
    $wp_customize->add_control( new WP_Customize_Control(
        $wp_customize,
        'pigeon_from_address',
        array(
            'label' => __( 'Fromメールアドレス', 'pigeon_email_from' ),
            'section' => 'pigeon_setting_section',
            'settings' => 'pigeon_email_from',
        )
    ));
}
add_action( 'customize_register', 'pigeon_customize_register' );

/**
 * Ajax用グローバル変数設定
 */
function pigeon_set_ajax_url() {
    $script = "";
    $script .= "<script>";
    $script .= "var ajax_url = '" . admin_url( 'admin-ajax.php') . "'";
    $script .= "</script>";
    echo $script;
}
add_action( 'wp_head', 'pigeon_set_ajax_url' );

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
function pigeon_ajax_send_mail() {

    $post_id = isset($_POST['post_id']) ? $_POST['post_id'] : '';
    $base64 = isset($_POST['base64']) ? $_POST['base64'] : '';

    // メール情報取得
    if ( $post_id ) {
        $to = get_post_meta( $post_id, 'to', true );
        $content = get_post_meta( $post_id, 'content', true );
        $_post = get_post( $post_id );
        $subject = $_post->post_title;
        if ( !( $to && $content && $subject ) ) {
            return;
        }
    } else {
        return;
    }

    // 画像ファイル生成
    $img = '';
    if ( $base64 ) {
        $upload_dir = wp_upload_dir();
        $img = $upload_dir['basedir'] . '/pigeon_'.$post_id.'.jpg';
        $fp = fopen( $img, 'w' );
        $base64 = str_replace( 'data:image/jpeg;base64,', '', $base64 );
        fwrite( $fp, base64_decode( $base64 ) );
        fclose( $fp );
    }

    // メール送信
    $email_from = get_theme_mod( 'pigeon_email_from', '' );
    if ( !$email_from ) {
        $email_from = get_option( 'admin_email' );
    }
    $headers = 'From:' . $email_from . "\r\n";
    if ( $img ) {
        $attachments = array( $img );
    } else {
        $attachments = '';
    }
    $result = wp_mail( $to, $subject, $content, $headers, $attachments );

    echo $result;

    return;
}
add_action( 'wp_ajax_pigeon_ajax_send_mail', 'pigeon_ajax_send_mail' );
add_action( 'wp_ajax_nopriv_pigeon_ajax_send_mail', 'pigeon_ajax_send_mail' );

