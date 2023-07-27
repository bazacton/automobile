<?php
/*
 * Start class for facebook page and profile activities 
 */
if ( ! class_exists( 'automobile_var_facebook_module' ) ) {

    class automobile_var_facebook_module extends WP_Widget {
        /**
         * Outputs the content of the widget
         *
         * @param array $args
         * @param array $instance
         */

        /**
         * @Facebook Module
         *
         *
         */
        public function __construct() {

            parent::__construct(
                    'automobile_var_facebook_module', // Base ID
                    esc_html( automobile_var_theme_text_srt( 'automobile_var_facebook' ) ), // Name
                    array( 'classname' => 'facebok_widget', 'description' => esc_html( automobile_var_theme_text_srt( 'automobile_var_facebook_desc' ) ), ) // Args
            );
        }

        /**
         * @Facebook html Form
         *
         *
         */
        function form( $instance ) {
            $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
            $title = $instance['title'];
            $pageurl = isset( $instance['pageurl'] ) ? esc_attr( $instance['pageurl'] ) : '';
            $showfaces = isset( $instance['showfaces'] ) ? esc_attr( $instance['showfaces'] ) : '';
            $showstream = isset( $instance['showstream'] ) ? esc_attr( $instance['showstream'] ) : '';
            $showheader = isset( $instance['showheader'] ) ? esc_attr( $instance['showheader'] ) : '';
//            $fb_bg_color = isset( $instance['fb_bg_color'] ) ? esc_attr( $instance['fb_bg_color'] ) : '';
            $likebox_height = isset( $instance['likebox_height'] ) ? esc_attr( $instance['likebox_height'] ) : '';
            $width = isset( $instance['width'] ) ? esc_attr( $instance['width'] ) : '';
            $hide_cover = isset( $instance['hide_cover'] ) ? esc_attr( $instance['hide_cover'] ) : '';
            $show_posts = isset( $instance['show_posts'] ) ? esc_attr( $instance['show_posts'] ) : '';
//            $hide_cta = isset( $instance['hide_cta'] ) ? esc_attr( $instance['hide_cta'] ) : '';
//            $small_header = isset( $instance['small_header'] ) ? esc_attr( $instance['small_header'] ) : '';
//            $adapt_container_width = isset( $instance['adapt_container_width'] ) ? esc_attr( $instance['adapt_container_width'] ) : '';
            ?>
            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php echo esc_html( automobile_var_theme_text_srt( 'automobile_var_facebook_title' ) ); ?>
                    <input class="upcoming" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" size='40' name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
                </label>
            </p>

            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'pageurl' ) ); ?>"><?php echo esc_html( automobile_var_theme_text_srt( 'automobile_var_facebook_url' ) ); ?> 
                    <input class="upcoming" id="<?php echo automobile_allow_special_char( $this->get_field_id( 'pageurl' ) ); ?>" size='40' name="<?php echo esc_attr( $this->get_field_name( 'pageurl' ) ); ?>" type="text" value="<?php echo esc_attr( $pageurl ); ?>" />
                    <br />
                    <small><?php echo esc_html( automobile_var_theme_text_srt( 'automobile_var_facebook_profile_url' ) ); ?> http://www.facebook.com/profilename OR <br />
                        https://www.facebook.com/pages/wxyz/123456789101112 </small><br />
                </label>
            </p>
                        <!--			<p>
                                                        <label for="<?php echo esc_attr( $this->get_field_id( 'fb_bg_color' ) ); ?>"><?php echo esc_html( automobile_var_theme_text_srt( 'automobile_var_facebook_bgcolor' ) ); ?> 
                                                                <input type="text" name="<?php echo esc_attr( $this->get_field_name( 'fb_bg_color' ) ); ?>" size='4' id="<?php echo esc_attr( $this->get_field_id( 'fb_bg_color' ) ); ?>"  value="<?php
            if ( ! empty( $fb_bg_color ) ) {
                echo esc_html( $fb_bg_color );
            }
            ?>" class="fb_bg_color upcoming"  />
                                                        </label>
                                                </p>   -->

            <p>
                <label for="<?php echo automobile_allow_special_char($this->get_field_id( 'width' )); ?>"><?php echo esc_html( automobile_var_theme_text_srt( 'automobile_var_facebook_width' ) ); ?> 
                    <input class="upcoming" id="<?php echo esc_attr( $this->get_field_id( 'width' ) ); ?>" size='2' name="<?php echo esc_attr( $this->get_field_name( 'width' ) ); ?>" type="text" value="<?php echo esc_attr( $width ); ?>" />
                </label>
            </p>

            <p>
                <label for="<?php echo automobile_allow_special_char($this->get_field_id( 'likebox_height' )); ?>"><?php echo esc_html( automobile_var_theme_text_srt( 'automobile_var_facebook_lightbox_height' ) ); ?> 
                    <input class="upcoming" id="<?php echo esc_attr( $this->get_field_id( 'likebox_height' ) ); ?>" size='2' name="<?php echo esc_attr( $this->get_field_name( 'likebox_height' ) ); ?>" type="text" value="<?php echo esc_attr( $likebox_height ); ?>" />
                </label>
            </p>

            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'hide_cover' ) ); ?>"><?php echo esc_html( automobile_var_theme_text_srt( 'automobile_var_facebook_hide_cover' ) ); ?> 
                    <input class="upcoming" id="<?php echo esc_attr( $this->get_field_id( 'hide_cover' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'hide_cover' ) ); ?>" type="checkbox" <?php
                    if ( esc_attr( $hide_cover ) != '' ) {
                        echo 'checked';
                    }
                    ?> />
                </label>
            </p>

            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'showfaces' ) ); ?>"><?php echo esc_html( automobile_var_theme_text_srt( 'automobile_var_facebook_show_faces' ) ); ?> 
                    <input class="upcoming" id="<?php echo esc_attr( $this->get_field_id( 'showfaces' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'showfaces' ) ); ?>" type="checkbox" <?php
                    if ( esc_attr( $showfaces ) != '' ) {
                        echo 'checked';
                    }
                    ?> />
                </label>
            </p>


            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'show_posts' ) ); ?>"><?php echo esc_html( automobile_var_theme_text_srt( 'automobile_var_facebook_show_post' ) ); ?> 
                    <input class="upcoming" id="<?php echo esc_attr( $this->get_field_id( 'show_posts' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_posts' ) ); ?>" type="checkbox" <?php
                    if ( esc_attr( $show_posts ) != '' ) {
                        echo 'checked';
                    }
                    ?> />
                </label>
            </p>
            <!--			<p>
                            <label for="<?php echo esc_attr( $this->get_field_id( 'hide_cta' ) ); ?>"><?php echo esc_html( automobile_var_theme_text_srt( 'automobile_var_facebook_hide_cta' ) ); ?> 
                                            <input class="upcoming" id="<?php echo esc_attr( $this->get_field_id( 'hide_cta' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'hide_cta' ) ); ?>" type="checkbox" <?php
            if ( esc_attr( $hide_cta ) != '' ) {
                echo 'checked';
            }
            ?> />
                            </label>
            </p>

            <p>
                            <label for="<?php echo esc_attr( $this->get_field_id( 'small_header' ) ); ?>"><?php echo esc_html( automobile_var_theme_text_srt( 'automobile_var_facebook_hide_cta' ) ); ?> 
                                            <input class="upcoming" id="<?php echo esc_attr( $this->get_field_id( 'small_header' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'small_header' ) ); ?>" type="checkbox" <?php
            if ( esc_attr( $small_header ) != '' ) {
                echo 'checked';
            }
            ?> />
                            </label>
            </p>

            <p>
                <label for="<?php echo esc_attr( $this->get_field_id( 'adapt_container_width' ) ); ?>"><?php echo esc_html( automobile_var_theme_text_srt( 'automobile_var_facebook_adaptwidth' ) ); ?> 
                    <input class="upcoming" id="<?php echo esc_attr( $this->get_field_id( 'adapt_container_width' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'adapt_container_width' ) ); ?>" type="checkbox" <?php
            if ( esc_attr( $adapt_container_width ) != '' ) {
                echo 'checked';
            }
            ?> />
                </label>
            </p>
            -->
            <?php
        }

        /**
         * @Facebook Update Form Data
         *
         *
         */
        function update( $new_instance, $old_instance ) {
            $instance = $old_instance;
            $instance['title'] = $new_instance['title'];
            $instance['pageurl'] = $new_instance['pageurl'];
            $instance['showfaces'] = $new_instance['showfaces'];
            $instance['showstream'] = $new_instance['showstream'];
            $instance['showheader'] = $new_instance['showheader'];
//            $instance['fb_bg_color'] = $new_instance['fb_bg_color'];
            $instance['likebox_height'] = $new_instance['likebox_height'];
            $instance['width'] = $new_instance['width'];
            $instance['hide_cover'] = $new_instance['hide_cover'];
            $instance['show_posts'] = $new_instance['show_posts'];
//            $instance['hide_cta'] = $new_instance['hide_cta'];
//            $instance['small_header'] = $new_instance['small_header'];
//            $instance['adapt_container_width'] = $new_instance['adapt_container_width'];
            return $instance;
        }

        /**
         * @Facebook Widget Display
         *
         *
         */
        function widget( $args, $instance ) {
            extract( $args, EXTR_SKIP );
            $title = empty( $instance['title'] ) ? '' : apply_filters( 'widget_title', $instance['title'] );
            $title = wp_specialchars_decode( stripslashes( $title ) );
            $pageurl = empty( $instance['pageurl'] ) ? ' ' : apply_filters( 'widget_title', $instance['pageurl'] );
            $showfaces = empty( $instance['showfaces'] ) ? ' ' : apply_filters( 'widget_title', $instance['showfaces'] );
            $showstream = empty( $instance['showstream'] ) ? ' ' : apply_filters( 'widget_title', $instance['showstream'] );
            $showheader = empty( $instance['showheader'] ) ? ' ' : apply_filters( 'widget_title', $instance['showheader'] );
//            $fb_bg_color = empty( $instance['fb_bg_color'] ) ? ' ' : apply_filters( 'widget_title', $instance['fb_bg_color'] );
            $likebox_height = empty( $instance['likebox_height'] ) ? ' ' : apply_filters( 'widget_title', $instance['likebox_height'] );
            $width = empty( $instance['width'] ) ? ' ' : apply_filters( 'widget_title', $instance['width'] );
            $hide_cover = empty( $instance['hide_cover'] ) ? ' ' : apply_filters( 'widget_title', $instance['hide_cover'] );
            $show_posts = empty( $instance['show_posts'] ) ? ' ' : apply_filters( 'widget_title', $instance['show_posts'] );
//            $hide_cta = empty( $instance['hide_cta'] ) ? ' ' : apply_filters( 'widget_title', $instance['hide_cta'] );
//            $small_header = empty( $instance['small_header'] ) ? ' ' : apply_filters( 'widget_title', $instance['small_header'] );
//            $adapt_container_width = empty( $instance['adapt_container_width'] ) ? ' ' : apply_filters( 'widget_title', $instance['adapt_container_width'] );

            if ( isset( $showfaces ) AND $showfaces == 'on' ) {
                $showfaces = 'true';
            } else {
                $showfaces = 'false';
            }
            if ( isset( $showstream ) AND $showstream == 'on' ) {
                $showstream = 'true';
            } else {
                $showstream = 'false';
            }

            if ( isset( $hide_cover ) AND $hide_cover == 'on' ) {
                $hide_cover = 'true';
            } else {
                $hide_cover = 'false';
            }
//			if ( isset( $show_posts ) AND $show_posts == 'on' ) {
//				$show_posts = 'true';
//			} else {
//				$show_posts = 'false';
//			}
//            if ( isset( $hide_cta ) AND $hide_cta == 'on' ) {
//                $hide_cta = 'true';
//            } else {
//                $hide_cta = 'false';
//            }
//            if ( isset( $small_header ) AND $small_header == 'on' ) {
//                $small_header = 'true';
//            } else {
//                $small_header = 'false';
//            }
//            if ( isset( $adapt_container_width ) AND $adapt_container_width == 'on' ) {
//                $adapt_container_width = 'true';
//            } else {
//                $adapt_container_width = 'false';
//            }

            //echo ($before_widget);
            echo '<div class="widget widget-facebook">';
            if ( ! empty( $title ) && $title <> ' ' ) {
                //echo automobile_allow_special_char( $before_title );
                echo '<div class="widget-title"><h5>' . $title . '</h5></div>';
                //echo automobile_allow_special_char( $after_title );
            }
            global $wpdb, $post;
            ?>		

            <div id="fb-root"></div>
            <script>(function (d, s, id) {
                    var js, fjs = d.getElementsByTagName(s)[0];
                    if (d.getElementById(id))
                        return;
                    js = d.createElement(s);
                    js.id = id;
                    js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.6";
                    fjs.parentNode.insertBefore(js, fjs);
                }(document, 'script', 'facebook-jssdk'));</script>
            <?php
            $output = '';
            $output .= '<div';
//			if ( isset( $instance['fb_bg_color'] ) && $instance['fb_bg_color'] != '' )
//				$output .= ' style="background:' . esc_attr( $instance['fb_bg_color'] ) . ';" ';
            $output .=' class="fb-page" ';
            if ( isset( $pageurl ) && $pageurl != '' )
                $output .= ' data-href="' . esc_url( $pageurl ) . '"';
            if ( isset( $width ) && $width != '' )
                $output .= ' data-width="' . $width . '" ';
            if ( isset( $likebox_height ) && $likebox_height != '' )
                $output .= ' data-height="' . $likebox_height . '" ';
            if ( isset( $hide_cover ) && $hide_cover != '' )
                $output .= ' data-hide-cover="' . $hide_cover . '" ';
            if ( isset( $showfaces ) && $showfaces != '' )
                $output .= ' data-show-facepile="' . $showfaces . '" ';
            if ( isset( $show_posts ) && $show_posts == 'on' )
                $output .= ' data-tabs="timeline" ';
//            if ( isset( $adapt_container_width ) && $adapt_container_width != '' )
//                $output .= 'data-adapt-container-width="'.$adapt_container_width.'"';
            $output .= '>';
            $output .= '</div></div>';
            echo automobile_allow_special_char( $output );
            // echo ($after_widget);
        }

    }

}
if (function_exists('cs_widget_register')) {
    cs_widget_register("automobile_var_facebook_module");
}
