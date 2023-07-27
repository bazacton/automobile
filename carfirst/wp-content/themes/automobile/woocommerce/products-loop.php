<?php

/**
 * Shop Products Lisitng
 * 
 */
if (is_shop()) {

    $automobile_shop_id = wc_get_page_id('shop');

    if (have_posts()) :
        echo "<div class='cs-shop-wrap row'>"
        . do_action('woocommerce_before_shop_loop')
        . "<ul class='products'>";
        while (have_posts()) : the_post();

            get_template_part('woocommerce/content', 'product');

        endwhile; // end of the loop. 

        echo "</ul><div class='col-md-12 col-lg-12'>";

        wc_get_template('loop/pagination.php');

        echo "</div></div>";

    endif;
}