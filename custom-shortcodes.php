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


function display_team_results($team_id) {
    // Arguments for querying the Schedule custom post type
    $args = array(
        'post_type' => 'schedule',  // Make sure 'schedule' is your custom post type
        'posts_per_page' => -1,     // Get all the posts
        'orderby' => 'date',        // Order by date
        'order' => 'ASC',           // Ascending order
    );

    $query = new WP_Query($args);
    
    if ($query->have_posts()) {
        echo '<div class="team-results-container card-container">';
        echo '<h2>Team Results</h2>';
        // echo '<ul class="team-results">';
        ?>
            <table>
                <thead>
                    <tr>
                        <th>Opponent</th>
                        <th>Result</th>
                    </tr>
                </thead>
                <tbody>

        <?php
        while ($query->have_posts()) {
            $query->the_post();

                    // Loop through sheets (1 to 6)
                    for ($i = 1; $i <= 6; $i++) {
                        // Get the relevant fields dynamically based on the sheet number
                        $team_1_field = 'team_1_sheet_' . $i;
                        $team_2_field = 'team_2_sheet_' . $i;
                        $game_result_field = 'game_result_sheet_' . $i;

                        $team_1_post = get_field($team_1_field);
                        $team_2_post = get_field($team_2_field);
                        $current_result = get_field($game_result_field);
                        
                        // Skip if no team found for the sheet or no result for the game
                        if (!$team_1_post || !$team_2_post || !$current_result) {
                            continue;
                        }

                        // Check if the team is involved in this match
                        if ($team_1_post->ID === $team_id || $team_2_post->ID === $team_id) {
                            // Determine which team is the current team
                            if ($team_1_post->ID === $team_id) {
                                $opponent = $team_2_post;
                                // Compare current result to team_1_sheet_X or team_2_sheet_X to determine win/loss
                                if ($current_result === $team_1_field) {
                                    $result = '<span class="win-result">W</span>';
                                } elseif ($current_result === $team_2_field) {
                                    $result = '<span class="loss-result">L</span>';
                                } elseif ($current_result === 'tie') {
                                    $result = '<span class="tie-result">T</span>';
                                } else {
                                    $result = '-'; // If there's an unexpected value
                                }
                            } else {
                                $opponent = $team_1_post;
                                // Compare current result to team_2_sheet_X or team_1_sheet_X to determine win/loss
                                if ($current_result === $team_2_field) {
                                    $result = '<span class="win-result">W</span>';
                                } elseif ($current_result === $team_1_field) {
                                    $result = '<span class="loss-result">L</span>';
                                } elseif ($current_result === 'tie') {
                                    $result = '<span class="tie-result">T</span>';
                                } else {
                                    $result = '-'; // If there's an unexpected value
                                }
                            }

                            echo '<tr>';
                            echo '<td>' . get_the_title($opponent->ID) . '</td>';  
                            echo '<td>' . $result . '</td>';
                            echo '</tr>';

                    // // Output the result for this match
                    // echo '<li>';
                    // echo 'vs ' . get_the_title($opponent->ID) . ' : ' . $result;
                    // echo '</li>';
                }
            }
        }
        echo '</tbody>';
        echo '</table>';
        // echo '</ul>';
        echo '</div>';
    } else {
        echo 'No results found for this team.';
    }

    wp_reset_postdata();
}



function display_condensed_standings($atts) {
    // Set default attributes (can be overridden with [team_standings season="season-slug"])
    $atts = shortcode_atts(
        array(
            'season' => 'winter-2025', // Default season
        ), 
        $atts
    );

    // Query teams based on the selected season
    $args = array(
        'post_type'      => 'teams',
        'posts_per_page' => -1,
        'tax_query'      => array(
            array(
                'taxonomy' => 'season',
                'field'    => 'slug',
                'terms'    => $atts['season'],
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
                'points' => $points,
            );
        }
    }
    wp_reset_postdata();

    // Sort teams by Points DESC
    usort($teams, function ($a, $b) {
        return $b['points'] - $a['points']; // Sort by points DESC
    });

    // Start the output
    ob_start();
    ?>
    <h2>Standings</h2>

    <!-- Display the Standings Table with only Team Name and Points -->
    <?php if (!empty($teams)) : ?>
        <table>
            <thead>
                <tr>
                    <th>Team Name</th>
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
                        <td><?php echo esc_html($team['points']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="<?php echo home_url('/standings'); ?>">View Full Standings</a>
    <?php else : ?>
        <p>No data found for this season.</p>
    <?php endif; ?>

    <?php
    // Capture the output and return it
    return ob_get_clean();
}

// Register the shortcode
add_shortcode('condensed_standings', 'display_condensed_standings');





function upcoming_schedule_shortcode($atts) {
    // Get today's date and calculate the date 6 days from now
    $today = current_time('Y-m-d'); 
    $seven_days_later = date('Y-m-d', strtotime($today . ' +6 days'));
    
    // Query the 'schedule' custom post type
    $args = array(
        'post_type' => 'schedule',
        'posts_per_page' => -1, // Get all posts
        'meta_query' => array(
            array(
                'key' => 'date',
                'value' => array($today, $seven_days_later),
                'compare' => 'BETWEEN',
                'type' => 'DATE',
            ),
        ),
    );
    $query = new WP_Query($args);

    if ($query->have_posts()) {
        $output = '<div class="upcoming-schedule">';

        // Loop through the posts
        while ($query->have_posts()) {
            $query->the_post();

            // Get and format the date
            $date = get_field('date');
            $formatted_date = date('F j, Y g:i a', strtotime($date)); // format date

            // Start post output
            $output .= '<div class="schedule-post">';
            $output .= '<h2>Upcoming Schedule</h2>';
            $output .= '<h3>' . get_the_title() . ' - ' . $formatted_date . '</h3>';
            
            // Loop through sheets (1 to 6)
            for ($sheet = 1; $sheet <= 6; $sheet++) {
                // Retrieve the Post Objects for team 1 and team 2
                $team_1 = get_field("team_1_sheet_{$sheet}");
                $team_2 = get_field("team_2_sheet_{$sheet}");


                // Check if both teams are valid Post Objects and get their titles
                if ($team_1 && $team_2) {
                    // Get the post titles from the Post Objects
                    $team_1_name = is_a($team_1, 'WP_Post') ? get_the_title($team_1) : '';
                    $team_2_name = is_a($team_2, 'WP_Post') ? get_the_title($team_2) : '';

                    $output .= '<div class="sheet">';
                    $output .= '<strong>Sheet ' . $sheet . ':</strong> ';
                    $output .= esc_html($team_1_name) . ' vs ' . esc_html($team_2_name);
                    $output .= '</div>';
                }
            }

            $output .= '</div>'; // Close schedule-post
        }

        $output .= '</div>'; // Close upcoming-schedule
        wp_reset_postdata();
    } else {
        $output = '<p>No upcoming schedules found within the next 7 days.</p>';
    }

    return $output;
}

add_shortcode('upcoming_schedule', 'upcoming_schedule_shortcode');



function past_schedule_shortcode($atts) {
    // Get today's date and calculate the date 7 days ago, excluding today
    $today = current_time('Y-m-d'); 
    $seven_days_ago = date('Y-m-d', strtotime($today . ' -7 days'));
    $yesterday = date('Y-m-d', strtotime($today . ' -1 day'));

    // Query the 'schedule' custom post type
    $args = array(
        'post_type' => 'schedule',
        'posts_per_page' => -1, // Get all posts
        'meta_query' => array(
            array(
                'key' => 'date',
                'value' => array($seven_days_ago, $yesterday),
                'compare' => 'BETWEEN',
                'type' => 'DATE',
            ),
        ),
    );
    $query = new WP_Query($args);

    if ($query->have_posts()) {
        $output = '<div class="past-schedule">';

        // Loop through the posts
        while ($query->have_posts()) {
            $query->the_post();

            // Get and format the date
            $date = get_field('date');
            $formatted_date = date('F j, Y g:i a', strtotime($date)); // format date

            // Start post output
            $output .= '<div class="schedule-post">';
            $output .= '<h2>Recent Results</h2>';
            $output .= '<h3>' . get_the_title() . ' - ' . $formatted_date . '</h3>';
            
            // Loop through sheets (1 to 6)
            for ($sheet = 1; $sheet <= 6; $sheet++) {
                // Retrieve the Post Objects for team 1 and team 2
                $team_1 = get_field("team_1_sheet_{$sheet}");
                $team_2 = get_field("team_2_sheet_{$sheet}");
                $game_result_field = "game_result_sheet_{$sheet}";
                $current_result = get_field($game_result_field); // Get the result

                // Check if both teams are valid Post Objects and get their titles
                if ($team_1 && $team_2) {
                    // Get the post titles from the Post Objects
                    $team_1_name = is_a($team_1, 'WP_Post') ? get_the_title($team_1) : '';
                    $team_2_name = is_a($team_2, 'WP_Post') ? get_the_title($team_2) : '';

                    // Initialize the results
                    $team_1_result = '-';
                    $team_2_result = '-';

                    // Determine the results for both teams
                    if ($current_result) {
                        if ($current_result === "team_1_sheet_{$sheet}") {
                            $team_1_result = '<span class="win-result">W</span>';
                            $team_2_result = '<span class="loss-result">L</span>';
                        } elseif ($current_result === "team_2_sheet_{$sheet}") {
                            $team_1_result = '<span class="loss-result">L</span>';
                            $team_2_result = '<span class="win-result">W</span>';
                        } elseif ($current_result === 'tie') {
                            $team_1_result = '<span class="tie-result">T</span>';
                            $team_2_result = '<span class="tie-result">T</span>';
                        }
                    }

                    // Output the match info with both teams' results
                    $output .= '<div class="sheet">';
                    $output .= esc_html($team_1_name) . ' - ' . $team_1_result . ' vs ' . esc_html($team_2_name) . ' - ' . $team_2_result;
                    $output .= '</div>';
                }
            }

            $output .= '</div>'; // Close schedule-post
        }

        $output .= '</div>'; // Close past-schedule
        wp_reset_postdata();
    } else {
        $output = '<p>No schedules found in the past 7 days.</p>';
    }

    return $output;
}

add_shortcode('past_schedule', 'past_schedule_shortcode');




