<?php
/**
 * The template for displaying comments
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package WordPress
 * @subpackage Automobile
 * @since Auto Mobile 1.0
 */
/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if (post_password_required()) {
    return;
}
$var_arrays = array('post_id', 'automobile_var_static_text');
$comment_global_vars = AUTOMOBILE_VAR_GLOBALS()->globalizing($var_arrays);
extract($comment_global_vars);
?>

<?php
if (have_comments()) :
    if (function_exists('the_comments_navigation')) {
        the_comments_navigation();
    }
    ?>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div id="comments" class="cs-comments">
            <h3 class="comments-title">
                <?php
                $comments_number = get_comments_number();
                if (1 == $comments_number) {
                    /* translators: %s: post title */
                    printf(_x('One thought on &ldquo;%s&rdquo;', 'comments title', 'automobile'), get_the_title());
                } else {
                    printf(
                            /* translators: 1: number of comments, 2: post title */
                            _nx(
                                    '%1$s comment', '%1$s comments', $comments_number, 'comments title', 'automobile'
                            ), number_format_i18n($comments_number), get_the_title()
                    );
                }
                ?>
            </h3>
            <ul>
                <?php  wp_list_comments(array('callback' => 'automobile_var_comment')); ?>

            </ul>	
        </div>
    </div><!-- .comment-list -->

    <?php
    if (function_exists('the_comments_navigation')) {
        the_comments_navigation();
    }

endif; // Check for have_comments().  
// If comments are closed and there are comments, let's leave a little note, shall we?
if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) :
    ?>
    <p class="no-comments"><?php echo automobile_var_theme_text_srt('automobile_var_comments_closed'); ?></p>
<?php endif; ?>

<?php
//  comment_form( array(
//  'title_reply_before' => '<h2 id="reply-title" class="comment-reply-title">',
//  'title_reply_after'  => '</h2>',
//  ) );
?>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div id="respond" class="cs-contact-form">

        <?php
        $automobile_msg_class = '';
        if (is_user_logged_in()) {
            $automobile_msg_class = ' cs-message';
        }


        $you_may_use = automobile_var_theme_text_srt('automobile_var_you_may');
        $must_login = '<a href="%s">logged in</a>' . automobile_var_theme_text_srt('automobile_var_you_must');
        $logged_in_as = ''. automobile_var_theme_text_srt('automobile_var_log_in'). ' <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">' . automobile_var_theme_text_srt('automobile_var_log_out') . '</a>';
        $required_fields_mark = ' ' . automobile_var_theme_text_srt('automobile_var_require_fields');
        $required_text = sprintf($required_fields_mark, '<span class="required">*</span>');
        $defaults = array(
            'fields' => apply_filters('comment_form_default_fields', array(
                'author' => '<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
				<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><div class="input-holder">
                <label>' . automobile_var_theme_text_srt('automobile_var_name') . '</label>
                <input id="author"  name="author" class="nameinput" type="text" placeholder="' . automobile_var_theme_text_srt('automobile_var_full_name') . '" value=""' .
                esc_attr($commenter['comment_author']) . ' tabindex="1"><i class="icon-user"></i></div>' .
                '<!-- #form-section-author .form-section -->',
                'email' => '<div class="input-holder">' .
                '<label>' . automobile_var_theme_text_srt('automobile_var_email') . '</label>
                <input id="email" name="email" class="emailinput" type="text" placeholder="' . automobile_var_theme_text_srt('automobile_var_enter_email') . '"  value=""' .
                esc_attr($commenter['comment_author_email']) . ' size="30" tabindex="2">' .
                '<i class="icon-email"></i></div>'
                . '<!-- #form-section-email .form-section -->',
                'url' => '<div class="input-holder">' .
                '<label>' . automobile_var_theme_text_srt('automobile_var_website') . '</label>
                    <input id="url" name="url" type="text" class="websiteinput" placeholder="' . automobile_var_theme_text_srt('automobile_var_sc_url_field') . '" value="" size="30" tabindex="3">' .
                '<i class="icon-web"></i></div></div></div></div>'
            )),
            'comment_field' => '<div class="input-holder">' . $automobile_msg_class . '">
            <label>' . automobile_var_theme_text_srt('automobile_var_message') . '</label>
            <textarea id="comment_mes" name="comment"  placeholder="' . automobile_var_theme_text_srt('automobile_var_text_here') . '" class="commenttextarea" rows="55" cols="15"></textarea>' .
            '</div>',
            'must_log_in' => '<span>' . sprintf($must_login, wp_login_url(apply_filters('the_permalink', get_permalink($post_id)))) . '</span>',
            'logged_in_as' => '<span>' . sprintf($logged_in_as, admin_url('profile.php'), $user_identity, wp_logout_url(apply_filters('the_permalink', get_permalink($post_id)))) . '</span>',
            'comment_notes_before' => '',
            'comment_notes_after' => '',
            'class_form' => 'comment-form contact-form',
            'id_form' => 'form-style',
            'class_submit' => 'cs-button cs-bgcolor',
            'id_submit' => 'cs-bg-color',
            'title_reply' => automobile_var_theme_text_srt('automobile_var_post_comment'),
            'title_reply_to' => '<h2 class="cs-element-title">' . automobile_var_theme_text_srt('automobile_var_leave_comment') . '</h2>',
            'cancel_reply_link' => automobile_var_theme_text_srt('automobile_var_cancel_reply'),
            'label_submit' => automobile_var_theme_text_srt('automobile_var_post_comment'),
        );
        comment_form($defaults, $post_id);
        ?>

    </div>
</div><!-- .comments-area -->
