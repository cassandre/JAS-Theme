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

            <?php
            $schools = get_post_meta($post->ID, 'project_school', true);
            $contact = get_post_meta($post->ID, 'project_contact', true);
            if (!empty($schools) || !empty($contact)) {
                print '<div class="project-info">';
                    if (!empty($schools)) {
                        if (!is_array($schools))
                            $schools = (array) $schools;
                        echo '<p><strong>Ein Angebot der</strong><br />';
                        foreach ($schools as $school) {
                            echo '<a href="' . get_permalink($school) . '">' . get_the_title($school) . '</a><br />';
                        }
                        echo '</p>';
                    }
                    if (!empty($contact)) {
                        print '<p><strong>Kontakt: </strong><br />'
                            . '<a href="' . get_permalink($contact) . '">' . get_the_title($contact) . '</a></p>';
                    }
                print '</div>';
            } ?>

            <div class="content-project">
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

                $data_specific = get_post_meta($post->ID, 'project_specific', true);
                $selected_schools = get_post_meta($post->ID, 'project_school', true);
                if (!is_array($selected_schools))
                    $selected_schools = (array)$selected_schools;
                if (count($selected_schools) >= 1) {
                    if (!empty($data_specific)) {
                        if (isset($_GET['school']) && is_numeric($_GET['school'])) {
                            print '<hr />';
                            $school_id = $_GET['school'];
                            if (isset($data_specific[$school_id]['text'])) {
                                print '<div>' . $data_specific[$school_id]['text'] . '</div>';
                            }
                            if (isset($data_specific[$school_id]['contact'])) {
                                $contact = $data_specific[$school_id]['contact'];
                                print '<p><strong>Kontakt: </strong> '
                                    . '<a href="' . get_permalink($contact) . '">' . get_the_title($contact) . '</a></p>';
                            }
                        } else {
                            print "<h2 class='circle'>An den einzelnen Schulen:</h2>";
                            foreach ($data_specific as $school_id => $school_data) {
                                if (in_array($school_id, $selected_schools)) {
                                    print '<h3 class="small_title"><a href="' . get_permalink($school_id) . '">' . get_the_title($school_id) . '</a></h3>';
                                    print '<div>' . $school_data['text'];
                                    if (isset($school_data['contact']) && $school_data['contact'] > 0) {
                                        print '<p><strong>Kontakt:</strong> <a href="' . get_permalink($school_data['contact']) . '">' . get_the_title($school_data['contact']) . '</a></p>';
                                    }
                                    print '</div>';
                                }
                            }
                        }
                    }
                }

                ?>

            </div><!-- .content-project -->

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
                    __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'jas' ).'bla',
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
