<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package tesac-curl
 */

get_header();
?>

	<main id="primary" class="standings-page">
        <div class="card-container">
            <?php
            while (have_posts()) :
            the_post();

            

            // Get all terms in the 'season' taxonomy to populate the dropdown
            $seasons = get_terms(array(
                'taxonomy' => 'season',
                'orderby' => 'name',
                'order' => 'ASC',
                'hide_empty' => false, 
            )               );

            // Default season if no GET parameter is provided
            $season_slug = 'winter-2025'; // Default season

            if (isset($_GET['season'])) {
                if (is_string($_GET['season']) && !empty(trim($_GET['season']))) {
                    $season_slug = sanitize_text_field($_GET['season']);
                } else {
                    echo '<p style="color: red;">Invalid season parameter detected!</p>';
                }
            }

            // Query teams based on the selected season
            $args = array(
                'post_type'      => 'teams',
                'posts_per_page' => -1,
                'tax_query'      => array(
                    array(
                        'taxonomy' => 'season',
                        'field'    => 'slug',
                        'terms'    => $season_slug,
                    ),
                ),
            );

            $query = new WP_Query($args);

            // Store results in an array
            $teams = array();

            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();
                    
                    // Get ACF fields
                    $wins   = get_field('wins') ?: 0;
                    $losses = get_field('losses') ?: 0;
                    $ties   = get_field('ties') ?: 0;
                    $points = ($wins * 2) + $ties;

                    // Store data for sorting
                    $teams[] = array(
                        'name'   => get_the_title(),
                        'ID'     => get_the_ID(),
                        'wins'   => $wins,
                        'losses' => $losses,
                        'ties'   => $ties,
                        'points' => $points,
                    );
                }
            }
            wp_reset_postdata();

            // Sort teams by Points DESC, then Wins DESC, then Losses ASC
            usort($teams, function ($a, $b) {
                if ($a['points'] != $b['points']) {
                    return $b['points'] - $a['points']; // Sort by points DESC
                }
                if ($a['wins'] != $b['wins']) {
                    return $b['wins'] - $a['wins']; // Sort by wins DESC
                }
                return $a['losses'] - $b['losses']; // Sort by losses ASC
            });
            ?>
            <h1><?php echo get_the_title(); ?></h1>

            <!-- Dropdown for selecting season -->
            <form method="get" action="">
                <label for="season">Select Season:</label>
                <select name="season" id="season" onchange="this.form.submit()">
                    <?php if (!empty($seasons) && !is_wp_error($seasons)) : ?>
                        <?php foreach ($seasons as $season) : ?>
                            <option value="<?php echo esc_attr($season->slug); ?>" <?php selected($season_slug, $season->slug); ?>>
                                <?php echo esc_html($season->name); ?>
                            </option>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <option value="">No seasons available</option>
                    <?php endif; ?>
                </select>
            </form>

            <!-- Display the Standings Table -->
            <?php if (!empty($teams)) : ?>
                <table>
                    <thead>
                        <tr>
                            <th>Team Name</th>
                            <th>Wins</th>
                            <th>Losses</th>
                            <th>Ties</th>
                            <th>Points</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($teams as $team) : ?>
                            <tr>
                                <td>
                                    <a href="<?php echo esc_url(get_permalink($team['ID']));?>">
                                    <?php echo esc_html($team['name']); ?>
                                    </a>
                                </td>
                                <td><?php echo esc_html($team['wins']); ?></td>
                                <td><?php echo esc_html($team['losses']); ?></td>
                                <td><?php echo esc_html($team['ties']); ?></td>
                                <td><?php echo esc_html($team['points']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else : ?>
                <p>No data found for this season.</p>
            <?php endif; ?>


            <?php wp_reset_postdata(); ?>


                        
            <?php
                    endwhile; // End of the loop.
            ?>
        </div>
    </main><!-- #main -->

<?php
get_footer();
