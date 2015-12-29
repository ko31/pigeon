<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<title><?php echo get_bloginfo( 'name' ); ?></title>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="mobile-web-app-capable" content="yes">
<meta name="description" content="<?php bloginfo( 'description' ); ?>">
<link rel="icon" sizes="192x192" href="<?php echo get_stylesheet_directory_uri(); ?>/images/apple-touch-icon.png">
<link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_stylesheet_directory_uri(); ?>/images/apple-touch-icon.png" />
<link rel="apple-touch-icon-precomposed" href="<?php echo get_stylesheet_directory_uri(); ?>/images/apple-touch-icon.png" />
<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/images/apple-touch-icon.png" />
<?php wp_head(); ?>
</head>

<body>
    <header class="header">
        <div class="container">
            <h1><a href="<?php echo site_url();?>"><?php echo get_bloginfo('name');?></a> <small><?php echo get_bloginfo('description');?></small></h1>
        </div>
    </header>
