<?php

function display_standings_shortcode($atts) {
    // Extract shortcode attributes (e.g., season="winter-2025")
    $atts = shortcode_atts(array(
        'season' => 'winter-2025', // Default season
    ), $atts, 'standings');

    ob_start(); // Start output buffering

    // Get selected season from shortcode or query string
    $season_slug = isset($_GET['season']) ? sanitize_text_field($_GET['season']) : $atts['season'];

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
    $teams = array();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();

            // Get ACF fields safely
            $wins   = get_field('wins') ?: 0;
            $losses = get_field('losses') ?: 0;
            $ties   = get_field('ties') ?: 0;
            $points = ($wins * 2) + $ties;

            // Store data for sorting
            $teams[] = array(
                'name'   => get_the_title(),
                'wins'   => $wins,
                'losses' => $losses,
                'ties'   => $ties,
                'points' => $points,
            );
        }
    }
    wp_reset_postdata();

    // Sort teams by Points DESC, Wins DESC, Losses ASC
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
    <!-- Standings Table -->
    <form method="get" action="">
        <label for="season">Select Season:</label>
        <select name="season" id="season" onchange="this.form.submit()">
            <?php 
            $seasons = get_terms(array('taxonomy' => 'season', 'orderby' => 'name', 'order' => 'ASC', 'hide_empty' => false));
            if (!empty($seasons) && !is_wp_error($seasons)) :
                foreach ($seasons as $season) : ?>
                    <option value="<?php echo esc_attr($season->slug); ?>" <?php selected($season_slug, $season->slug); ?>>
                        <?php echo esc_html($season->name); ?>
                    </option>
                <?php endforeach;
            else : ?>
                <option value="">No seasons available</option>
            <?php endif; ?>
        </select>
    </form>

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
            <?php if (!empty($teams)) :
                foreach ($teams as $team) : ?>
                    <tr>
                        <td><?php echo esc_html($team['name']); ?></td>
                        <td><?php echo esc_html($team['wins']); ?></td>
                        <td><?php echo esc_html($team['losses']); ?></td>
                        <td><?php echo esc_html($team['ties']); ?></td>
                        <td><?php echo esc_html($team['points']); ?></td>
                    </tr>
                <?php endforeach;
            else : ?>
                <tr><td colspan="5">No teams found for this season.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
    <?php

    return ob_get_clean(); // Return buffered content
}

// Register the shortcode
add_shortcode('standings', 'display_standings_shortcode');
