<?php
/*
Plugin Name: Posts Display Shortcode
Plugin URI: n/a
Description: [pds] [pds post_type='' row_class='' col_class='' img_position='' display_cate='' per_page='' cate='' excerpt_length='' feat_img='' feat_img_height='' display_author='' date_format='' cate='' link_title='' display_price=''] | Dated: 17 Aug, 2022
Author:  Aamir Hussain
Version: 4
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
    $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
    $the_args = array(
        'post_type'         => $post_type,
        'category_name'     => $cate,
        'posts_per_page'    => $per_page,
        'orderby'           => $order_by,
        'order'             => $order,
        'post__not_in'      => array(get_the_ID()),
        'paged'             => $paged
    );

  if(!post_type_exists( $post_type )){
    echo "<div class='lead text-danger'><h4>Error!</h4> <em>Please check your mentioned post_type as the post type <strong>'$post_type'</strong> does not exist in this system!</em></div>";
    return;
  }  

    $query = new WP_Query($the_args);
    ob_start();
    if($query->have_posts()):
    ?>
<div class="row <?php apply_css_class($row_class)?>">
    <?php while ($query->have_posts()): $query->the_post();?>
<?php $n++;?>
	    <div class="<?php apply_css_class($col_class)?> portfolio-item post-<?php echo $n?>">
            
        <?php the_layout($feat_img, get_the_ID(), '32', $img_position, $display_cate,$display_author,$date_format, $link_title,$display_price, $post_type);?> 

	    </div>
	    
        <?php endwhile; ?>
</div>

    <div class="row pb-2 pl-0 pr-0 ml-auto mr-auto">
        <div class="col ml-0 pl-0">
            <nav class="pagination">
            <?php pagination_bar($query); wp_reset_postdata();?>
            </nav>
        </div>
    </div>
<?php
    endif;
$html = ob_get_clean();
    return $html;
}


/* * * * 
 *  
 * FUNCTIONS 
 *
 * * * */
//THE LAYOUT
function the_layout($feat_img_height = null, $the_id, $excerpt_length=null, $img_position=null, $display_cate=null, $display_author=null, $date_format=null, $link_title=null, $display_price=null, $post_type=null){
    ob_start();
    ?><?php if($img_position =="" || $img_position == "top"){?>
        <div class="card h-100">
        <?php display_feat_img($feat_img_height,$the_id);?><!---ends post feat image--->   
        <div class="card-body">
        <?php  display_title($the_id);?>
            <?php display_date($date_format,$the_id)?>
            <?php display_categories($display_cate, $the_id);?>
             <?php  display_author($display_author, $the_id); ?> 
            <?php display_excerpt($the_id, $excerpt_length);?>
            <?php display_price($post_type, $display_price, $the_id );?>
        </div><!---ends card body--->
        <?php read_more(get_the_ID(), $link_title);?>
        </div> <!---ends card div--->
    <?php 
}elseif($img_position == "bottom"){?>
        <div class="card h-100">
         
        <div class="card-body">
        <?php  display_title($the_id);?>
            <?php display_date($date_format,$the_id)?>
            <?php display_categories($display_cate, $the_id);?>
            <?php  display_author($display_author, $the_id); ?> 
            <?php display_excerpt($the_id, $excerpt_length);?>  
            <?php display_price($post_type, $display_price, $the_id );?>        
        </div><!---ends card body--->
        <?php display_feat_img($feat_img_height,$the_id);?><!---ends post feat image--->  
        <?php read_more(get_the_ID(), $link_title);?>
        </div> <!---ends card div--->
    <?php 
}elseif($img_position == "left"){
    ?>
    <div class="row border ml-auto mr-auto">
        <div class="col-md-4 p-0"><?php display_feat_img($feat_img_height,$the_id);?><!---ends post feat image---></div>
        <div class="col-md-8 p-0 pl-4 pr-3 pt-3">
        <?php  display_title($the_id);?>
            <?php display_date($date_format,$the_id)?>
            <?php display_categories($display_cate, $the_id);?>
            <?php  display_author($display_author, $the_id); ?> 
            <?php display_excerpt($the_id, $excerpt_length);?>
            <?php display_price($post_type, $display_price, $the_id );?>
        </div>
        <div class="col-md-12 pl-0 pr-0 pt-2 text-right"><?php read_more(get_the_ID(), $link_title);?></div>
    </div>
    <?php
}elseif($img_position == "right"){
    ?>
    <div class="row border ml-auto mr-auto">
    <div class="col-md-8 p-0 pr-4 pl-3 pt-3">
    <?php  display_title($the_id);?>
            <?php display_date($date_format,$the_id)?>
             <?php display_categories($display_cate, $the_id);?>
             <?php  display_author($display_author, $the_id); ?> 
            <?php display_excerpt($the_id, $excerpt_length);?>
            <?php display_price($post_type, $display_price, $the_id );?>
        </div>
        <div class="col-md-4 p-0"><?php display_feat_img($feat_img_height,$the_id);?><!---ends post feat image---></div>
        <div class="col-md-12 pl-0 pr-0 pt-2 text-right"><?php read_more(get_the_ID(), $link_title);?></div>
    </div>
    <?php
}    
    $html = ob_get_clean();
    echo $html;
}
// TITLE
function display_title($the_id){
    ob_start();?>
<h4 class="card-title">
    <a href="<?php echo get_the_permalink($the_id); ?>" style="text-decoration:none;color:inherit;"><?php echo get_the_title($the_id); ?></a>
</h4>
    <?php $html = ob_get_clean();
    echo $html;
}
// EXCERPT
function display_excerpt($the_id, $excerpt_length){
    ob_start();?>
<div class="card-text"><?php echo substr( get_the_excerpt($the_id) ,0 ,($excerpt_length?$excerpt_length:'65' ) ); ?></div>
    <?php $html = ob_get_clean();
    echo $html;
}
// FEATURED IMAGE
function display_feat_img($feat_img_height = null,$post_id){
    ob_start();?>
        <a style="max-height:<?php echo ($feat_img_height != "") ? $feat_img_height : '170px';?>;display:block;overflow:hidden;" href="<?php echo get_the_permalink(get_the_ID()); ?>">
        <?php if ($feat_img != "no"):?>
        <?php if (has_post_thumbnail()) {?>
        <?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'full');?>
            <img src="<?php echo $image[0]; ?>" class="img-fluid ml-auto mr-auto card-img-top"/>
        <?php }else{?> 
        <svg height="auto" id="no-img-icon-<?php echo $post_id;?>" viewBox="0 0 32 32" width="100%" xmlns="http://www.w3.org/2000/svg"><defs><style>.cls-1{fill:none;}#no-img-icon-<?php echo $post_id;?>{padding:0;}</style></defs><title/>
            <path fill="#EEE" d="M30,3.4141,28.5859,2,2,28.5859,3.4141,30l2-2H26a2.0027,2.0027,0,0,0,2-2V5.4141ZM26,26H7.4141l7.7929-7.793,2.3788,2.3787a2,2,0,0,0,2.8284,0L22,19l4,3.9973Zm0-5.8318-2.5858-2.5859a2,2,0,0,0-2.8284,0L19,19.1682l-2.377-2.3771L26,7.4141Z"/>
                <path fill="#EEE" d="M6,22V19l5-4.9966,1.3733,1.3733,1.4159-1.416-1.375-1.375a2,2,0,0,0-2.8284,0L6,16.1716V6H22V4H6A2.002,2.002,0,0,0,4,6V22Z"/>
            <rect class="cls-1 p-<?php echo $post_id;?>" data-name="no-img" height="100%" id="no-img" width="100%"/>
        </svg>
        <?php }?>
        <?php endif;?>
        </a> 
    <?php $html = ob_get_clean();
    echo $html;
}

//APPLY CSS CLASS ON ANY OBJECT
function apply_css_class($css_class){
   echo (isset($css_class) && !empty($css_class) ? $css_class : '');
}



// DISPLAY CATEGORIES

function display_categories($display_cate, $the_id ){
    if($display_cate != ""): 
    $cats = get_the_category($the_id);
    ob_start();
    foreach ( $cats as $cat ): ?>
 <a href="<?php echo get_category_link($cat->cat_ID); ?>" class="category"><?php echo $cat->name; ?></a> 
    <?php endforeach;
    endif;
    $html = ob_get_clean();
    echo $html;
}

//DISPLAY AUTHOR NAME
function display_author($display_author,$the_id){
    ob_start();
    if(isset($display_author)):
    ?> 
        <span class="author">By <?php echo ucfirst(get_the_author());?></span>
    <?php
    endif;
    $html = ob_get_clean();
    echo $html;
}
//DISPLAY DATE
function display_date($date_format,$the_id){
    ob_start();
if(isset($date_format)):
?> 
    <em class="date"><?php echo get_the_date( $date_format, $the_id );?></em>
<?php
endif;
$html = ob_get_clean();
echo $html;
}



//DISPLAY PRICE
function display_price($post_type,$display_price,$the_id){
    ob_start();
if($post_type === "product" && isset($display_price)):
?> <?php $price = get_post_meta( $the_id, '_price', true ); ?>
    <span class="price"><?php echo wc_price( $price ); ?></span>
<?php
endif;
$html = ob_get_clean();
echo $html;
}



//DISPLAY LINK BUTTON
function read_more($the_id,$link_title){
ob_start();
if(isset($link_title)):
?><div class="card-footer">
    <a class="btn btn-secondary" href="<?php echo get_the_permalink($the_id);?>"><?php echo $link_title;?></a>
  </div>  
<?php
endif;
$html = ob_get_clean();
echo $html;
}

// DISPLAY PAGINATION
function pagination_bar( $custom_query ) {
    $total_pages = $custom_query->max_num_pages;
    $big = 999999999; // need an unlikely integer
    if ($total_pages > 1){
        $current_page = max(1, get_query_var('paged'));
        echo "<style>  .pagination a, .pagination span {    position: relative;    float: left;    padding: 6px 12px;    margin-left: -1px;    line-height: 1.42857143;    color: #337ab7;    text-decoration: none;    background-color: #fff;    border: 1px solid #ddd;}</style>";
        echo paginate_links(array(
            'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
            'format' => '?paged=%#%',
            'current' => $current_page,
            'total' => $total_pages,
        ));
    }
}