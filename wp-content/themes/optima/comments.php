<?php
if (post_password_required()) {
    ?>
    <p class="nocomments"><?php esc_html_e('This post is password protected. Enter the password to view comments.', 'optima'); ?></p>
    <?php return;
}
?>

<div id="comments"><?php
#Required for nested reply function that moves reply inline with JS
if (is_singular()) wp_enqueue_script('comment-reply');

if (have_comments()) : ?>
    <h4> <?php echo esc_html__('Comments', 'optima'); echo " ("; ?><?php echo comments_number('0', '1', '%') . ")"; ?></h4>
    <ol class="commentlist">
    <?php
        if (gt3_option("post_pingbacks") == "1") {
            wp_list_comments('type=all&callback=gt3_theme_comment');
        } else {
            wp_list_comments('type=comment&callback=gt3_theme_comment');
        }
    ?>
    </ol>
    <div class="dn"><?php paginate_comments_links(); ?></div>
    <?php if ('open' == $post->comment_status) : ?>
    <?php else : // comments are closed ?>
    <?php endif; ?>
<?php endif; ?>
<?php if ('open' == $post->comment_status) :
    $comment_form = array(
        'fields' => apply_filters('comment_form_default_fields', array(
            'author' => '<div class="span4"><label class="label-name"></label><input type="text" placeholder="' . esc_html__('Name *', 'optima') . '" title="' . esc_html__('Name *', 'optima') . '" id="author" name="author" class="form_field"></div>',
            'email' => '<div class="span4"><label class="label-email"></label><input type="text" placeholder="' . esc_html__('Email *', 'optima') . '" title="' . esc_html__('Email *', 'optima') . '" id="email" name="email" class="form_field"></div>',
            'url' => '<div class="span4"><label class="label-email"></label><input type="text" placeholder="' . esc_html__('Website', 'optima') . '" title="' . esc_html__('Website', 'optima') . '" id="url" name="url" class="form_field"></div>'
        )),
        'comment_field' => '<div class="span12"><label class="label-message"></label><textarea name="comment" cols="45" rows="5" placeholder="' . esc_html__('Your Comment', 'optima') . '" id="comment-message" class="form_field"></textarea></div>',
        'comment_form_before' => '',
        'comment_form_after' => '',
        'must_log_in' => esc_html__('You must be logged in to post a comment.', 'optima'),
        'title_reply' => esc_html__('Leave a Comment!', 'optima'),
        'label_submit' => esc_html__('Post comment', 'optima'),
        'logged_in_as' => '<p class="logged-in-as">' . esc_html__('Logged in as', 'optima') . ' <a href="' . esc_url(admin_url('profile.php')) . '">' . $user_identity . '</a>. <a href="' . esc_url(wp_logout_url(apply_filters('the_permalink', get_permalink()))) . '">' . esc_html__('Log out?', 'optima') . '</a></p>',
    );

    add_filter('comment_form_fields', 'gt3_reorder_comment_fields');

    if (!function_exists('gt3_reorder_comment_fields')) {
        function gt3_reorder_comment_fields($fields ) {
            $new_fields = array();

            $myorder = array('author', 'email', 'url', 'comment');

            foreach( $myorder as $key ){
                $new_fields[ $key ] = $fields[ $key ];
                unset( $fields[ $key ] );
            }

            if( $fields ) {
                foreach( $fields as $key => $val ) {
                    $new_fields[ $key ] = $val;
                }
            }

            return $new_fields;
        }
    }
    

    comment_form($comment_form, $post->ID);

else : // Comments are closed ?>
<?php endif; ?></div>