<?php
/**
 * Template Name: React Post Template
 */

get_header(); 

?>

<div style="max-width: 1200px; margin: 50px auto;">
    <?= do_shortcode('[coin_price]');?>
</div>

<div id="react-app"></div>

<script>
    var reactpress_post_id = <?php echo get_the_ID(); ?>;
    window.blogPostData = {
        title: '<?php echo esc_js(get_the_title()); ?>',
        content: '<?php echo esc_js(strip_tags(get_the_content(), '<a><b><i><strong><em><img><ul><ol><li><blockquote><h1><h2><h3><h4><h5><h6>')); ?>',
        thumbnail: '<?php echo esc_url(get_the_post_thumbnail_url()); ?>'
    };
</script>

<?php
get_footer(); 
?>