<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package My_Theme
 */

get_header();
    $min_price = '';
    $max_price = '';
    $size = '';
    $color = '';
    $selected = '';
    if ( $_GET['min-price'] && !empty( $_GET['min-price'])) {
        $min_price = $_GET['min-price'];
    }
    else {
        $min_price = 0;
    }
    if ( $_GET['max-price'] && !empty( $_GET['max-price'])) {
        $max_price = $_GET['max-price'];
    }
    else {
        $max_price = 100000;
    }
    if ( $_GET['size'] && !empty( $_GET['size'])) {
        $size = $_GET['size'];
    }
    if ( $_GET['color'] && !empty( $_GET['color'])) {
        $color = $_GET['color'];
    }
    function displayZ_selected( $size, $val ) 
    {
        if ( $val === $size ) {
            return 'selected';
        }
    }
?>

    <div class="container">
        <h4 class="lesson-title">WP Custom Query - Basics</h4>
        <form action="/" method="get">
            <label for="min-price">Min:</label>
            <input type="number" id="min-price" value="<?php echo $min_price; ?>">
            <label for="max-price">Max:</label>
            <input type="number" id="max-price" value="<?php echo $min_price; ?>">
            <label for="size">Size:</label>
            <select name="size" id="size">
                <option value="">Any</option>
                <option value="s" <?php echo display_selected( $size, 's'); ?>>S</option>
                <option value="m" <?php echo display_selected( $size, 'm'); ?>>M</option>
                <option value="l" <?php echo display_selected( $size, 'l'); ?>>l</option>
                <option value="xl" <?php echo display_selected( $size, 'xl'); ?>>xl</option>
            </select>

            <select name="color" id="color">
                <option value="">Any</option>
                <option value="blue" <?php echo display_selected( $color, 'blue'); ?>>Blue</option>
                <option value="red" <?php echo display_selected( $color, 'red'); ?>>Red</option>
                <option value="green" <?php echo display_selected( $color, 'green'); ?>>Green</option>
            </select>
            <button type="submit" name="">Filter</button>
        </form>

        <?php 
        $args = [
            'post_type' => 'post',
            'posts_per_page' => -1,
            'meta_query' => [
                'relation' => 'AND',
                [
                    'key' => 'price',
                    'value' => [$min_price, $max_price],
                    'type' => 'NUMERIC',
                    'compare' => 'BETWEEN',
                ]
            ]
        ];

        function push_arguements( $field_name = '', $field_args ) {
            global $args;
            if ( $field_name ) {
                array_push( $args['meta_query'], $field_args );
            }
        }
        push_arguements( $size, [
            'key' => 'size',
            'value' => $size,
            'type' => 'CHAR',
            'compare' => '=',
        ]);
        push_arguements( $color, [
            'key' => 'color',
            'value' => $color,
            'type' => 'CHAR',
            'compare' => '=',
        ]);

        $the_query = new WP_Query( $args );
        ?>
        <?php while( $the_query->have_posts() ) : $query->the_post(); ?>
        <div class="post clearfix">
            <h5><?php the_title(); ?></h5>
            <div class="taxonomy clearfix">
                <div class="categories">
                    <strong>Price:</strong>
                    <?php the_field('price'); ?>
                </div>
                <div class="tags">
                    <strong>Size:</strong><?php the_field('size'); ?><br/>
                    <strong>Color:</strong><?php the_field('color'); ?><br/>
                </div>
            </div>
        </div>
        <?php endwhile;
        wp_reset_postdata();
        ?>
    </div>

<?php
get_sidebar();
get_footer();
