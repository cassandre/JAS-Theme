<?php
/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function jas_widgets_init() {
    register_sidebar( array(
        'name'          => esc_html__( 'Sidebar', 'jas' ),
        'id'            => 'sidebar-1',
        'description'   => esc_html__( 'Add widgets here.', 'jas' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );
    register_sidebar(array(
        'name' => esc_html__('Info Area', 'jas'),
        'id' => 'sidebar-info-area',
        'description' => esc_html__('Add widgets here.', 'jas'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Footer', 'jas'),
        'id' => 'sidebar-footer',
        'description' => esc_html__('Add widgets here.', 'jas'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));
    register_sidebar(array(
        'name' => esc_html__('Front Page Boxes', 'jas'),
        'id' => 'front-page-boxes',
        'description' => esc_html__('Add widgets here.', 'jas'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));

    register_widget("JaS_Front_Page_Boxes");
}
add_action( 'widgets_init', 'jas_widgets_init' );

/*
 * Add Front Page Badges Widget
 */
class JaS_Front_Page_Boxes extends WP_Widget {

    public function __construct() {
        // actual widget processes
        parent::__construct(
            'front-page-box',  // Base ID
            'Front Page Box'   // Name
        );
    }

    public $args = array(
        'before_title'  => '<h4 class="widgettitle">',
        'after_title'   => '</h4>',
        'before_widget' => '<div class="widget-wrap">',
        'after_widget'  => '</div></div>'
    );

    public function widget( $args, $instance ) {
        // outputs the content of the widget ?>
        <div class="widget_box box-<?php echo esc_html($instance['color']); ?>">
            <a href="<?php echo get_permalink($instance['page_id'])?>">
                <i class="<?php echo esc_html($instance['icon']); ?> fa-2x"></i>
                <span><?php echo esc_html($instance['text']); ?></span>
            </a>
        </div>
        <?php
    }

    public function form( $instance ) {
        // outputs the options form in the admin
        $icon = ! empty( $instance['icon'] ) ? $instance['icon'] : esc_html__( '', 'jas' );
        $text = ! empty( $instance['text'] ) ? $instance['text'] : esc_html__( '', 'jas' );
        $color = ! empty( $instance['color'] ) ? $instance['color'] : esc_html__( '', 'jas' );
        $page_id = ! empty( $instance['page_id'] ) ? $instance['page_id'] : esc_html__( '', 'jas' );
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>"><?php echo esc_html__( 'Text:', 'jas' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'text' ) ); ?>" type="text" value="<?php echo esc_attr( $text ); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'icon' ) ); ?>"><?php echo esc_html__( 'Fontawesome-Klasse:', 'jas' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'icon' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'icon' ) ); ?>" type="text" value="<?php echo esc_attr( $icon ); ?>">
        <p class="description">Das Icon definiert sich über die FontAwesome-Klasse. Diese kann auf <a href="https://fontawesome.com/icons?d=gallery&m=free">https://fontawesome.com/icons</a> ausgewählt werden. In der Regel sind zwei Klassen erforderlich "far" oder "fas" für die Icon-Familie und die eigentliche Icon-Klasse, durch ein Leerzeichen getrennt. Beispiel: far fa-newspaper</p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'color' ) ); ?>"><?php echo esc_html__( 'Color:', 'jas' ); ?></label>
            <select id="<?php echo esc_attr( $this->get_field_name( 'color' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'color' ) ); ?>">
                <option value="lila" <?php selected($color, 'lila');?>>lila</option>
                <option value="gelb" <?php selected($color, 'gelb');?>>gelb</option>
                <option value="gruen" <?php selected($color, 'gruen');?>>grün</option>
            </select>
        </p>
        <p>
            <?php
            $args = array(
                'id' => $this->get_field_id('page_id'),
                'name' => $this->get_field_name('page_id'),
                'selected' => $page_id
            );
            wp_dropdown_pages( $args ); ?>
        </p>
        <?php
    }

    public function update( $new_instance, $old_instance ) {
        // processes widget options to be saved
        $instance = array();
        $instance['text'] = ( !empty( $new_instance['text'] ) ) ? strip_tags( $new_instance['text'] ) : '';
        $instance['icon'] = ( !empty( $new_instance['icon'] ) ) ? strip_tags( $new_instance['icon'] ) : '';
        $instance['color'] = ( !empty( $new_instance['color'] ) ) ? strip_tags( $new_instance['color'] ) : '';
        $instance['page_id'] = ( !empty( $new_instance['page_id'] ) ) ? strip_tags( $new_instance['page_id'] ) : '';
        return $instance;
    }
}