<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo get_bloginfo( 'name' ); ?></title>
<?php wp_head(); ?>
</head>

<body>

    <header class="header">
      <div class="container">
    <h1><a href="<?php echo site_url();?>"><?php echo get_bloginfo('name');?></a> <small><?php echo get_bloginfo('description');?></small></h1>
      </div>
    </header>
