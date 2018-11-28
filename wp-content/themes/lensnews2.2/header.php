<!doctype html>
<html <?php language_attributes(); ?>>
<?php global $salong;?>

<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="author" content="萨龙网络">
    <meta name="viewport" content="width=device-width,height=device-height, initial-scale=1.0, user-scalable=no" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta http-equiv="Cache-Control" content="no-transform">
    <meta http-equiv="Cache-Control" content="no-siteapp">
    <title><?php echo salong_theme_title(); ?></title>
    <?php if($salong[ 'switch_seo']){ get_template_part( 'includes/seo'); } ?>
    <?php wp_head(); ?>
</head>
<?php flush(); ?>

<body <?php body_class(); ?>>
   <?php if(!is_page_template('template-login.php')){ ?>
    <!--头部-->
    <?php if(wp_is_mobile()){?>
    <?php get_template_part( 'content/header', 'mobile'); ?>
    <?php } else { ?>
    <?php get_template_part( 'content/header', 'pc'); ?>
    <?php } ?>
    <!--头部end-->
    <?php }?>