<?php
/**
 * @author: MadSparrow
 * @version: 1.0
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) { exit( 'Direct script access denied.' ); }

if ( post_password_required() ) {
    return;
}
?>

<div id="comments" class="ms-comments-area">
    <div class="ms-section__comments">
    <?php if ( have_comments() ) : ?>
        <div class="ms-comments-title"><?php osty_comments_number(); ?></div>
        <ul class="ms-comment-list">
            <?php wp_list_comments( array (
                'callback'   => 'osty_comments',
                'style'      => 'ul',
                'short_ping' => true,
                'format'     => 'html5',
            ) ); ?>
        </ul>
        <?php the_comments_navigation();
        if ( ! comments_open() ) : ?>
            <p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'osty' ); ?></p>
        <?php endif;
    endif; ?>
    <?php $commenter = wp_get_current_commenter();
        $args = array(
            'class_form' => 'row',
            'label_submit' => esc_html__( 'Post Comment', 'osty'),
            'title_reply' => esc_html__('Leave a Reply', 'osty') ,
            'title_reply_before' => '<h2 id="reply-title">',
            'title_reply_after' => '</h2>',
            'cancel_reply_before' => ' ',
            'cancel_reply_after' => '',
            'title_reply_to' => esc_html__('Leave a reply to', 'osty') . ' %s',
            'cancel_reply_link' => esc_html__('Cancel Reply', 'osty'),
            'class_submit' => 'btn--comments',
            'submit_button' => '<button type="submit" id="%2$s" class="%3$s" data-title="%4$s">
                <span class="f-btn-l">
                    <svg width="254" height="392" viewBox="0 0 254 392" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 57.647C0 25.8095 25.8095 0 57.647 0C89.4846 0 115.294 25.8095 115.294 57.647C115.294 89.4846 89.4846 115.294 57.647 115.294C25.8095 115.294 0 89.4846 0 57.647Z" fill="#121212"/>
                        <path d="M138.353 196C138.353 164.163 164.163 138.353 196 138.353C227.838 138.353 253.647 164.163 253.647 196C253.647 227.838 227.838 253.647 196 253.647C164.163 253.647 138.353 227.838 138.353 196Z" fill="#121212"/>
                        <path d="M0 334.353C0 302.516 25.8095 276.706 57.647 276.706C89.4846 276.706 115.294 302.516 115.294 334.353C115.294 366.191 89.4846 392 57.647 392C25.8095 392 0 366.191 0 334.353Z" fill="#121212"/>
                    </svg>
                </span>
                <span class="f-btn-r">
                    <span>%4$s</span>
                    <span class="btn-r_icon">
                        <svg width="254" height="392" viewBox="0 0 254 392" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0 57.647C0 25.8095 25.8095 0 57.647 0C89.4846 0 115.294 25.8095 115.294 57.647C115.294 89.4846 89.4846 115.294 57.647 115.294C25.8095 115.294 0 89.4846 0 57.647Z" fill="#121212"/>
                            <path d="M138.353 196C138.353 164.163 164.163 138.353 196 138.353C227.838 138.353 253.647 164.163 253.647 196C253.647 227.838 227.838 253.647 196 253.647C164.163 253.647 138.353 227.838 138.353 196Z" fill="#121212"/>
                            <path d="M0 334.353C0 302.516 25.8095 276.706 57.647 276.706C89.4846 276.706 115.294 302.516 115.294 334.353C115.294 366.191 89.4846 392 57.647 392C25.8095 392 0 366.191 0 334.353Z" fill="#121212"/>
                        </svg>
                    </span>
                </span>
            </button>',
            'fields' => apply_filters('comment_form_default_fields', array(
            'author' => '<div class="form-group form-comment col-md-6"><input id="ms-author" name="author" type="text" class="form-control" placeholder="' . esc_attr__( 'Name', 'osty' ) . '" value="' . esc_attr( $commenter['comment_author'] ) . '" required="required"/></div>', 
            'email' => '<div class="form-group form-comment col-md-6"><input id="ms-email" name="email" class="form-control" placeholder="' . esc_attr__( 'Email', 'osty' ) . '" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" required="required"/></div>',) ),
            'comment_field' => '<div class="form-group form-comment col-12"><textarea id="ms-comment" class="form-control" placeholder="' . esc_attr__( 'Your Comment', 'osty' ) . '" name="comment" rows="8" required="required"></textarea></div>',
            );
        ?>
        <?php comment_form($args); ?>
    </div>
</div>