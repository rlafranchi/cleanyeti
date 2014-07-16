<?php
include( ABSPATH . 'wp-admin/includes/image.php' );
/**
* Custom image sizes
*
* These should be named to match Foundations media queries as they will be automatically used in
* Interchange for responsive images
*/

add_image_size('interchange-small', 640, 9999);
add_image_size('interchange-medium', 1020, 9999);
add_image_size('interchange-large', 1440, 9999);
add_image_size('interchange-xlarge', 1600, 9999);

function cleanyeti_update_attachments() {
  $args = array( 'post_type' => 'attachment', 'numberposts' => -1, 'post_status' => null, 'post_parent' => null, 'post_mime_type' => 'image' );
  $attachments = get_posts( $args );
  if ($attachments) {
      foreach ( $attachments as $post ) {
          $file = get_attached_file( $post->ID );
          $attach_id = wp_insert_attachment( $post, $file, $post->post_parent );
          $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
          wp_update_attachment_metadata( $attach_id,  $attach_data );
      }
  }
}

function cleanyeti_custom_image_sizes($sizes) {
  $myimgsizes = array(
    "interchange-small" => __( "Interchange-Small" ),
    "interchange-medium" => __( "Interchange-Medium" ),
    "interchange-large" => __( "Interchange-Large" ),
    "interchange-xlarge" => __( "Interchange-Extra Large" )
  );
  $myimgsizes = array_merge($sizes, $myimgsizes);
  return $myimgsizes;
}
add_filter('image_size_names_choose', 'cleanyeti_custom_image_sizes');

/**
 * Responsive Images Shortcodes
 * 
 * Uses Foundation Interchange
 * @see http://foundation.zurb.com/docs/components/interchange.html
 */

function cleanyeti_interchange_shortcode($atts) {
  extract(shortcode_atts(array(
      'id' => 1,
      'class' => ''
                  ), $atts));

  $imageSizes = wp_get_attachment_metadata($atts['id']);
  $dataInterchange = '';
  

  //Output our image sizes using interchange for images format
  foreach ($imageSizes['sizes'] as $size => $info) {
    $attachment_info = wp_get_attachment_image_src($id, $size);
    
    if ( preg_match("/interchange/U", $size) ) {
      $size = substr($size, 12);

      $dataInterchange .= '[';
      $dataInterchange .= $attachment_info[0] . ', ';
      $dataInterchange .= '(' . $size . ')';
      $dataInterchange .= '],';

    }
  }
  
  $attachment_info = wp_get_attachment_image_src($id, 'full');
  
  if ( $size == 'small' ) {
      $dataInterchange .= '[' . $attachment_info[0] . ', (medium)]';
  } elseif ( $size == 'medium' ) {
      $dataInterchange .= '[' . $attachment_info[0] . ', (large)]';
  } elseif ( $size == 'large' ) {
      $dataInterchange .= '[' . $attachment_info[0] . ', (xlarge)]';
  }
  //Build the interchange <img /> tag
  $html = sprintf('<img alt="%2$s" data-interchange="%1$s" width="%4$d" height="%5$d" class="%6$s" /><noscript><img src="%3$s"></noscript>', $dataInterchange, get_the_title($atts['id']), $imageSizes['file'], $imageSizes['width'], $imageSizes['height'], $atts['class']);

  return $html;
}

add_shortcode('interchange-image', 'cleanyeti_interchange_shortcode');

/*
 * Manipulate the <img /> tag inserted by the html editor
 * Should output images compatible with foundation interchange
 */

function cleanyeti_get_image_tag($html, $id, $title) {
  $imageSizes = wp_get_attachment_metadata($id);
  $placeholder = $imageSizes['file'];

  //keep img classes as set by wordpress
  $doc = new DOMDocument();
  @$doc->loadHTML($html);
  $tags = $doc->getElementsByTagName('img');
  foreach ($tags as $tag) {
    $class = $tag->getAttribute('class');
    $width = $tag->getAttribute('width');
  }

  // Responsive only if this is full size image 
  // && larger than small image size (or no point)
  if (strstr($html, 'size-full') && $width>640) {
    return "[interchange-image id=\"$id\" placeholder=\"$placeholder\" class=\"$class\"]";
  } else {
    return $html;
  }
}

add_filter('get_image_tag', 'cleanyeti_get_image_tag', 10, 3);
?>
