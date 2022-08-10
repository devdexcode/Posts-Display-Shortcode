<?php
/*
Plugin Name: Posts Display Shortcode
Plugin URI: n/a
Description: [pds] [pds post_type='' limit='' cate='' excerpt_length='' feat_img=''] | Dated: 10th Aug, 2022
Author:  Aamir Hussain
Version: 1.0
Author URI: n/a
Text Domain:  
 */
add_shortcode('pds', 'loop_posts');
function loop_posts($atts)
{
    error_reporting(0);
    global $post;
    foreach ($atts as $k => $v) {
        $$k = $v;
    }
// print_r($atts); exit;
    $n = 1;
    $the_args = array(
        // 'row_class' => $row_class,
        // 'col_class' => $col_class,
        'post_type'         => $post_type,
        'category_name'     => $cate,
        'posts_per_page'    => $per_page,
        'orderby'           => $order_by,
        'order'             => $order,
        'posts_per_page'    => $limit,
        'post__not_in'      => array(get_the_ID()),
    );

  if(!post_type_exists( $post_type )){
    echo "<div class='lead text-danger'><h4>Error!</h4> <em>Please check your mentioned post_type as the post type <strong>'$post_type'</strong> does not exist in this system!</em></div>";
    return;
  }  

    $query = new WP_Query($the_args);
    ob_start();
    ?>
<div class="row">
    <?php while ($query->have_posts()): $query->the_post();?>

	    <div class="col-lg-4 col-sm-6 portfolio-item post-<?php echo $n?>">
	            
            <div class="card h-100">
            <a style="max-height:220px;display:block;overflow:hidden;" href="<?php echo get_the_permalink(get_the_ID()); ?>">
                <?php include 'inc/feat_img.php';?>
            </a>    
                <div class="card-body">
                    <?php include 'inc/the_title.php';?>
                    <?php include 'inc/the_excerpt.php';?>
                </div>

	        </div>

	    </div>
	    
        <?php endwhile;?>
</div>
<?php
$html = ob_get_clean();
    return $html;
}