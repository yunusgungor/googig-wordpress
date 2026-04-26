<?php 
/* Social Share Buttons template for Wordpress */

function osty_share_post() {
    $out = '<div class="single-post__share">';
    $out .= '<section class="sharing-box content-margin content-background clearfix">';
    $out .= '<div class="share-button-wrapper">';
    $out .= '<a target="_blank" class="share-button share-twitter" href="https://twitter.com/intent/tweet?url=' . get_permalink() . '&text=' . get_the_title() . '" title="' . esc_attr__('Tweet this', 'osty') . '"><i class="fa-brands fa-twitter"></i></a>';
    $out .= '<a target="_blank" class="share-button share-facebook" href="https://www.facebook.com/sharer/sharer.php?u=' . get_permalink() . '" title="' . esc_attr__('Share on Facebook', 'osty') . '"><i class="fa-brands fa-facebook-f"></i></a>';
    $out .= '<a class="share-button share-envelope" href="mailto:' . get_the_author_meta('user_email') . '"><i class="fa-solid fa-envelope"></i></a>';
    $out .= '<a class="share-button share-pinterest" href="http://www.pinterest.com/pin/create/button/?url=' . urlencode(get_permalink()) . '&media=' . wp_get_attachment_url(get_post_thumbnail_id()) . '&description=' .  get_the_title() . '" target="_blank"><i class="fa-brands fa-pinterest-p"></i></a>';
    $out .= '<a class="share-button share-copy" data-copy-link-url="' . get_permalink() . '" data-message="' . esc_attr__('Copied!', 'osty') . '" nopopup="true" href="#" title="' . esc_attr__('Copy URL to clipboard', 'osty') . '"><i class="fa-solid fa-link"></i></a>';
    $out .= '</div>';
    $out .= '</div>';
    $out .= '</section>';
    $out .= '</div>';
    return $out;
}

?>