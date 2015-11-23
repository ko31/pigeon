<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>pigeon</title>
<link href="<?php echo get_template_directory_uri(); ?>/style.css" rel="stylesheet">
<!-- Bootstrap core CSS -->
<link href="<?php echo get_template_directory_uri(); ?>/css/bootstrap.min.css" rel="stylesheet">
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5shiv.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/respond.min.js"></script>
<![endif]-->
<?php wp_head(); ?>
</head>

<body>

    <header class="header">
      <div class="container">
    <h1><a href="<?php echo site_url();?>"><?php echo get_bloginfo('name');?></a> <small><?php echo get_bloginfo('description');?></small></h1>
      </div>
    </header>
