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
    wp_enqueue_script ( 'html5shiv', get_template_directory_uri() . '/js/html5shiv.min.js' );
    wp_script_add_data( 'html5shiv', 'conditional', 'lt IE 9' );
    wp_enqueue_script ( 'respond', get_template_directory_uri() . '/js/respond.min.js' );
}
add_action( 'wp_enqueue_scripts', 'pigeon_enqueue_scripts' );

/**
 * メール送信
 */
if(function_exists("pigeon_send_mail"))
{
    function pigeon_send_mail( $id ) {
//        $to = get_post_meta( $post->ID, 'to', true );
//        $subject = $post->post_title;
//        $message = get_post_meta( $post->ID, 'content', true );
//        $headers = 'From: pigeon <pigeon@example.jp>' . "\r\n";
//        $attachments = array( '/var/vhost/wp-demo.go-sign.info/html/pigeon/wp-content/themes/pigeon/screenshot.png' );
//        wp_mail( $to, $subject, $message , $headers, $attachments );

    }
}
