<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package JaS
 */

global $post;

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

            <?php jas_post_thumbnail(); ?>

            <div class="content-school">
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

                // Projects
                $school_id = $post->ID;
                $args_projects = [
                    'post_type' => 'project',
                    'orderby' => 'title',
                    'order' => 'ASC',
                    'numberposts' => -1,
                    'meta_query' => [
                        [
                            'key' => 'project_school',
                            'value' => get_the_ID(),
                            'compare' => 'LIKE'
                        ],
                    ],
                ];
                $projects = get_posts($args_projects);
                if (count($projects) > 0) {
                    print "<h2 class='circle'>Projekte</h2>";
                    foreach ($projects as $post) {
                        setup_postdata($post);
                        print '<article class="school-project">';
                        if (has_post_thumbnail()) {
                            print '<div class="project-thumbnail">' . get_the_post_thumbnail($post->ID, 'small-thumbnail') . '</div>';
                        }
                        print "<div class=''><h3><a href=\"" . get_permalink($post->ID) . '?school=' . $school_id . "\">" . $post->post_title . "</a></h3>";
                        $project_excerpt = wpautop(get_the_excerpt($post->ID));
                        $project_excerpt = str_replace('</p>', ' <a href="' . get_the_permalink() . '?school=' . $school_id . '">weiterlesen »</a></p>', $project_excerpt);
                        print $project_excerpt;
                        print "</div></article>";
                    }
                    wp_reset_postdata();
                } ?>
            </div><!-- .content-school -->

            <aside class="sidebar-school">
                <?php $url = get_post_meta($post->ID, 'school_url', true);
                print "<p class='school-url'><a href=\"$url\">$url</a></p>";
                // JSA
                $args_staff = array(
                    'post_type' => 'staff',
                    'orderby' => 'title',
                    'order' => 'ASC',
                    'numberposts' => -1,
                    'meta_query' => [
                        'relation' => 'AND',
                        [
                            'key' => 'staff_school',
                            'value' => $school_id,
                            'compare' => 'LIKE'
                        ],
                        [
                            'key' => 'staff_active',
                            'value' => '1'
                        ],
                    ],
                );
                $staffs = get_posts($args_staff);
                if (count($staffs) > 0) {
                    $school_maincontact = get_post_meta($school_id, 'school_maincontact', true);
                    if ($school_maincontact != '') {
                        foreach ($staffs as $k => $staff) {
                            if ($staff->ID == $school_maincontact) {
                                $main_staff = $staffs[$k];
                                unset($staffs[$k]);
                                array_unshift($staffs, $main_staff);
                                break;
                            }
                        }
                    }
                    print "<div class='school-contact'><h2 class='circle'>Kontakt</h2>";
                    foreach ($staffs as $staff) {
                        $phone = get_post_meta($staff->ID, 'staff_phone', true);
                        $mobile = get_post_meta($staff->ID, 'staff_mobile', true);
                        $email = get_post_meta($staff->ID, 'staff_email', true);
                        $room = get_post_meta($staff->ID, 'staff_room', true);
                        $hours = nl2br(get_post_meta($staff->ID, 'staff_hours', true));

                        print "<div class='school-contact-item'>" . get_the_post_thumbnail($staff->ID, 'profile') . "<br /><p class='contact-name'><a href=\"" . get_permalink( $staff->ID ) . "\">" . $staff->post_title . "</a></p>"
                        //    . "<p>" . $staff->post_content . "</p>"
                        //print "<h3>Kontakt:</h3>";
                        . "<ul>"
                        . (!empty($room) ? "<li>Raum: $room</li>" : '')
                        . (!empty($phone) ? "<li>Telefon Festnetz: $phone</li>" : '')
                        . (!empty($mobile) ? "<li>Telefon Mobil: $mobile</li>" : '')
                        . (!empty($email) ? "<li>E-Mail: <a href=\"mailto:$email\">$email</a></li>" : '')
                        . "</ul>"
                        . (!empty($hours) ? "<h3>Sprechzeiten</h3><p>$hours</p>" : '')
                        . "</div>";
                    }
                    print '</div>';
                }
                ?>
            </aside>

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
