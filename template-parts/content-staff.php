<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package JaS
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
		if ( is_singular() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
		else :
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		endif;

		if ( 'post' === get_post_type() ) :
			?>
			<div class="entry-meta">
				<?php
				jas_posted_on();
				//jas_posted_by();
				?>
			</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

    <?php if (is_single()) : ?>
        <div class="entry-content">

            <?php jas_post_thumbnail('medium'); ?>

            <div class="content-staff">
                <?php
                the_content( sprintf(
                    wp_kses(
                        /* translators: %s: Name of current post. Only visible to screen readers */
                        __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'jas' ),
                        array(
                            'span' => array(
                                'class' => array(),
                            ),
                        )
                    ),
                    get_the_title()
                ) );
                $school_ids = get_post_meta($post->ID, 'staff_school', true);
                if (!$school_ids)
                    $school_ids = [];
                if (!is_array($school_ids)) {
                    $school_ids = array($school_ids);
                }
                $schools = [];
                foreach ($school_ids as $school_id) {
                    $schools[] = "<a class=\"school-url\" href=\"" . get_permalink($school_id) . "\">" . get_post($school_id)->post_title . "</a>";
                }
                $school = implode('<br />', $schools);
                $phone = get_post_meta($post->ID, 'staff_phone', true);
                $mobile = get_post_meta($post->ID, 'staff_mobile', true);
                $email = get_post_meta($post->ID, 'staff_email', true);
                $email2 = get_post_meta($post->ID, 'staff_email2', true);
                $room = get_post_meta($post->ID, 'staff_room', true);
                $hours = nl2br(get_post_meta($post->ID, 'staff_hours', true));

                print "<h2>Kontakt</h2>";
                print (!empty($school_id) ? $school : '');
                print "<ul>";
                print (!empty($room) ? "<li>Raum: $room</li>" : '');
                print (!empty($phone) ? "<li>Telefon Festnetz: $phone</li>" : '');
                print (!empty($mobile) ? "<li>Telefon Mobil: $mobile</li>" : '');
                print (!empty($email) ? "<li>E-Mail: <a href=\"mailto:$email\">$email</a></li>" : '');
                print (!empty($email2) ? "<li>E-Mail 2: <a href=\"mailto:$email2\">$email2</a></li>" : '');
                print "</ul>";
                if (!empty($hours)) {
                    print "<h2>Sprechzeiten</h2>". "<p>$hours</p>" ;
                } ?>
            </div><!-- .content-school -->

            <?php wp_link_pages( array(
                'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'jas' ),
                'after'  => '</div>',
            ) );
            ?>
        </div><!-- .entry-content -->
    <?php else: ?>
        <div class="entry-summary">
            <?php
            the_excerpt( sprintf(
                wp_kses(
                /* translators: %s: Name of current post. Only visible to screen readers */
                    __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'jas' ),
                    array(
                        'span' => array(
                            'class' => array(),
                        ),
                    )
                ),
                get_the_title()
            ) );

            wp_link_pages( array(
                'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'jas' ),
                'after'  => '</div>',
            ) );
            ?>
        </div><!-- .entry-content -->
    <?php endif; ?>

	<footer class="entry-footer">
		<?php jas_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
