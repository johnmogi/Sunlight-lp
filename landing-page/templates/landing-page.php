<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sunlight Tarot – The Evolution of the Tarot</title>
    <meta name="description" content="Join the Sunlight Project — a new Tarot system uniting science, spirit, and love.">
    <?php wp_head(); ?>
</head>
<body class="sunlight-landing-page">

<?php
// Display the full landing page using the shortcode
echo do_shortcode('[sunlight_full_page]');
?>

<?php wp_footer(); ?>
</body>
</html>
