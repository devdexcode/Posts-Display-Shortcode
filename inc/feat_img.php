<?php if ($feat_img != "no"):?>
<?php if (has_post_thumbnail()) {?>
<?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');?>
<img src="<?php echo $image[0]; ?>" class="img-fluid ml-auto mr-auto card-img-top"/>
<?php }else{?> 
<svg height="auto" id="no-img-icon-<?php echo $post->ID;?>" viewBox="0 0 32 32" width="100%" xmlns="http://www.w3.org/2000/svg"><defs><style>.cls-1{fill:none;}#no-img-icon-<?php echo $post->ID;?>{padding:0;}</style></defs><title/>
    <path fill="#EEE" d="M30,3.4141,28.5859,2,2,28.5859,3.4141,30l2-2H26a2.0027,2.0027,0,0,0,2-2V5.4141ZM26,26H7.4141l7.7929-7.793,2.3788,2.3787a2,2,0,0,0,2.8284,0L22,19l4,3.9973Zm0-5.8318-2.5858-2.5859a2,2,0,0,0-2.8284,0L19,19.1682l-2.377-2.3771L26,7.4141Z"/>
        <path fill="#EEE" d="M6,22V19l5-4.9966,1.3733,1.3733,1.4159-1.416-1.375-1.375a2,2,0,0,0-2.8284,0L6,16.1716V6H22V4H6A2.002,2.002,0,0,0,4,6V22Z"/>
    <rect class="cls-1 p-<?php echo $post->ID;?>" data-name="no-img" height="100%" id="no-img" width="100%"/>
</svg>
<?php }?>
<?php endif;?>