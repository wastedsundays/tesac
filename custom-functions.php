<?php

// Register Google Fonts
function enqueue_google_fonts() {
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap', false);
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap', false);
}
add_action('wp_enqueue_scripts', 'enqueue_google_fonts');

// Register custom script
function enqueue_custom_script() {

    if (is_page('Schedule')) { 
        wp_enqueue_script('custom-scripts', get_template_directory_uri() . '/js/custom-script.js', array(), null, true);
    }
    
}
add_action('wp_enqueue_scripts', 'enqueue_custom_script');

// Register theme editor styles
function my_theme_editor_styles() {

    add_editor_style( 'style.css' );
}
add_action( 'after_setup_theme', 'my_theme_editor_styles' );



// This adds a 'current-menu-item' class to the 'Teams' menu item when on a team page
function custom_active_teams_class($classes, $item, $args) {
    // Check if we are on a team page
    if (is_single() && strpos($_SERVER['REQUEST_URI'], '/teams/') !== false) {
        // If we're on the teams page or any individual team page
        if ($item->title == 'Teams') {
            // Add a custom class to the "Teams" menu item
            $classes[] = 'current-menu-item';
        }
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'custom_active_teams_class', 10, 3);






// This function will add a custom permalink structure for the 'teams' CPT to include the season slug
function custom_team_permalink( $permalink, $post ) {
    // Check if it's a team post type
    if ( 'teams' === get_post_type( $post ) ) {
        // Get the terms for the season taxonomy
        $terms = wp_get_post_terms( $post->ID, 'season' );
        
        // Check if the team has a season assigned
        if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
            // Use the season slug in the permalink
            $season_slug = $terms[0]->slug;
            $permalink = str_replace( '%season%', $season_slug, $permalink );
        }
    }
    return $permalink;
}

add_filter( 'post_type_link', 'custom_team_permalink', 10, 2 );


// these 2 functions exist to prevent the season taxonomy from being treated as a taxonomy archive for the 'teams' CPT

function custom_rewrite_rules() {
    // Exclude season slugs from being treated as a taxonomy archive under the "teams" CPT
    add_rewrite_rule(
        '^teams/([^/]+)/$',
        'index.php?post_type=teams&season=$matches[1]',
        'top'
    );
}

add_action('init', 'custom_rewrite_rules');

function prevent_season_archive_redirect() {
    // Check if we are viewing a 'teams' post type and the URL is in the 'season' taxonomy archive format
    if (is_tax('season')) {
        // Get the current taxonomy term (season)
        $term = get_queried_object();

        // Check if it's a valid season term and not a team post
        if ($term && !is_singular('teams')) {
            // Set the 404 status to trigger the 404 template
            global $wp_query;
            $wp_query->set_404();
            status_header(404);
            // Load the 404 template
            get_template_part( '404' );
            exit();
        }
    }
}

add_action('template_redirect', 'prevent_season_archive_redirect');





function register_games_schedule_cpt() {
    $labels = array(
        'name'                  => 'Schedule',
        'singular_name'         => 'Schedule',
        'menu_name'             => 'Schedule',
        'name_admin_bar'        => 'Draw',
        'add_new'               => 'Add New',
        'add_new_item'          => 'Add New Draw',
        'new_item'              => 'New Draw',
        'edit_item'             => 'Edit Draw',
        'view_item'             => 'View Draw',
        'all_items'             => 'All Draws',
        'search_items'          => 'Search Draws',
        'not_found'             => 'No draws found.',
        'not_found_in_trash'    => 'No draws found in Trash.',
        'parent_item_colon'     => '',
        'menu_name'             => 'Schedule',
    );
    
    $args = array(
        'labels'                => $labels,
        'public'                => true,
        'publicly_queryable'    => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'show_in_admin_bar'     => true,
        'show_in_rest'          => true,  // Enable for the block editor
        'rest_base'             => 'schedule',  // Optional, to modify the endpoint URL
        'supports'              => array('title', 'custom-fields'),
        'has_archive'           => false,  // No archive page for games
        // 'rewrite'               => array('slug' => 'games'),  // Set custom slug
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-calendar',  // You can use any WordPress Dashicon here
    );
    
    register_post_type('schedule', $args);
}
add_action('init', 'register_games_schedule_cpt');


function team_record_columns($columns) {
    $columns['record'] = 'Record';  // Add a custom column called 'Record'
    return $columns;
}
add_filter('manage_teams_posts_columns', 'team_record_columns');

function record_columns_content($column, $post_id) {
    if ($column == 'record') {
        // Get the ACF field values for 'wins', 'losses', and 'ties'
        $wins = get_field('wins', $post_id);
        $losses = get_field('losses', $post_id);
        $ties = get_field('ties', $post_id);

        // Display the combined record as 'Wins - Losses - Ties'
        echo $wins . ' - ' . $losses . ' - ' . $ties;
    }
}
add_action('manage_teams_posts_custom_column', 'record_columns_content', 10, 2);

function sortable_record_columns($columns) {
    $columns['record'] = 'wins';  // Make the 'Record' column sortable based on 'wins'
    return $columns;
}
add_filter('manage_edit-teams_sortable_columns', 'sortable_record_columns');

function my_sort_by_wins($query) {
    // Check if we're on the admin page for the 'teams' post type and sorting by 'wins'
    if (is_admin() && $query->is_main_query() && isset($_GET['orderby']) && $_GET['orderby'] === 'wins') {
        // Modify the query to sort by the 'wins' field (this assumes you're using ACF)
        $query->set('meta_key', 'wins');  // Set the meta key to the 'wins' ACF field
        $query->set('orderby', 'meta_value_num');  // Sort as a numeric value
    }
}
add_action('pre_get_posts', 'my_sort_by_wins');


// function to allow the team names to be dynamically populated in the game outcome field.
add_filter('acf/load_field/name=game_result_sheet_1', 'populate_game_result_field');
add_filter('acf/load_field/name=game_result_sheet_2', 'populate_game_result_field');
add_filter('acf/load_field/name=game_result_sheet_3', 'populate_game_result_field');
add_filter('acf/load_field/name=game_result_sheet_4', 'populate_game_result_field');
add_filter('acf/load_field/name=game_result_sheet_5', 'populate_game_result_field');
add_filter('acf/load_field/name=game_result_sheet_6', 'populate_game_result_field');

add_filter('acf/load_value/name=game_result_sheet_1', 'set_default_game_result');
add_filter('acf/load_value/name=game_result_sheet_2', 'set_default_game_result');
add_filter('acf/load_value/name=game_result_sheet_3', 'set_default_game_result');
add_filter('acf/load_value/name=game_result_sheet_4', 'set_default_game_result');
add_filter('acf/load_value/name=game_result_sheet_5', 'set_default_game_result');
add_filter('acf/load_value/name=game_result_sheet_6', 'set_default_game_result');

function populate_game_result_field($field) {
    // Ensure we're in the context of a post
    if (isset($_GET['post'])) {
        $post_id = $_GET['post']; // Get the current post ID

        // Initialize an empty array for options
        $options = [];

        // Get the sheet number from the filter name
        // The sheet number is part of the field name (game_outcome_sheet_X)
        preg_match('/game_result_sheet_(\d)/', $field['name'], $matches);
        $sheet_number = isset($matches[1]) ? $matches[1] : 1; // Default to sheet 1 if not found

        // Get the post object fields for team 1 and team 2 on the current sheet
        $team_1_field = 'team_1_sheet_' . $sheet_number;
        $team_2_field = 'team_2_sheet_' . $sheet_number;

        // Get the post objects for team 1 and team 2
        $team_1_post = get_field($team_1_field, $post_id);
        $team_2_post = get_field($team_2_field, $post_id);

        // Check if the team post objects are available and get the titles
        if ($team_1_post) {
            $options['team_1_sheet_' . $sheet_number] = get_the_title($team_1_post->ID); // Use the title as the label
        }
        if ($team_2_post) {
            $options['team_2_sheet_' . $sheet_number] = get_the_title($team_2_post->ID); // Use the title as the label
        }

        // Add "Tie" and "No Result" options
        $options['tie'] = 'Tie';
        $options['no_result'] = 'No Result';

        // Set the options for the game_outcome radio field
        $field['choices'] = $options;
    } else {
        $field['choices'] = [];
    }

    return $field;
}

// Set "No result" as the default selection for new posts
function set_default_game_result($value) {
    // Check if the value is empty (this means it's a new post)
    if (empty($value)) {
        return 'no_result'; // Set "No result" as the default
    }

    return $value;
}


// TRYING SOMETHING NEW HERE

// This hooks into the save_post action (fires on all post types)
add_action('save_post', 'custom_save_schedule_post', 10, 3);

function custom_save_schedule_post($post_id, $post, $update) {
    // Skip revisions and auto-saves
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    // Only proceed if it's a 'Schedule' post type
    if ($post->post_type !== 'schedule') {
        return;
    }

    // Trigger custom action to update team records after schedule is saved
    do_action('save_post_schedule', $post_id, $post, $update);
}

add_action('save_post_schedule', 'update_team_records_on_schedule_save', 10, 3);

function update_team_records_on_schedule_save($post_id, $post, $update) {
    // Only proceed if it's a 'Schedule' post type
    if ($post->post_type !== 'schedule') {
        return;
    }

    // Loop through all the sheets (1-6)
    for ($i = 1; $i <= 6; $i++) {
        // Get the field names dynamically based on the sheet number
        $team_1_field = 'team_1_sheet_' . $i;
        $team_2_field = 'team_2_sheet_' . $i;
        $game_result_field = 'game_result_sheet_' . $i;

        // Get the current game result (win/loss/tie/no_result)
        $current_result = get_field($game_result_field, $post_id);
        error_log('current_result: ' . $current_result); // Log the result to ensure correctness

        // Check if a result already exists (i.e., not "no_result")
        // if ($current_result !== 'no_result') {
        //     error_log('Skipping result update because a result has already been recorded: ' . $current_result);
        //     continue; // If a result already exists, skip this sheet
        // }

        // Get the teams for the current sheet
        $team_1_post = get_field($team_1_field, $post_id);
        $team_2_post = get_field($team_2_field, $post_id); // Set to false to avoid getting an array

        // Ensure both teams are selected
        if ($team_1_post && $team_2_post) {
            $team_1_id = $team_1_post->ID;
            $team_2_id = $team_2_post->ID;

            // Log the team IDs to ensure we have the correct team posts
            error_log("Team 1 ID: " . $team_1_id);
            error_log("Team 2 ID: " . $team_2_id);

            // Get the current win/loss/tie counts for each team
            $team_1_wins = get_field('wins', $team_1_id) ?: 0;
            $team_1_losses = get_field('losses', $team_1_id) ?: 0;
            $team_1_ties = get_field('ties', $team_1_id) ?: 0;

            $team_2_wins = get_field('wins', $team_2_id) ?: 0;
            $team_2_losses = get_field('losses', $team_2_id) ?: 0;
            $team_2_ties = get_field('ties', $team_2_id) ?: 0;

            // Now apply the new result directly
            if ($current_result === 'team_1_sheet_' . $i) {
                // Team 1 wins, Team 2 loses
                $team_1_wins += 1;
                $team_2_losses += 1;
                error_log("Updating result: Team 1 wins, Team 2 loses");
            } elseif ($current_result === 'team_2_sheet_' . $i) {
                // Team 2 wins, Team 1 loses
                $team_1_losses += 1;
                $team_2_wins += 1;
                error_log("Updating result: Team 2 wins, Team 1 loses");
            } elseif ($current_result === 'tie') {
                // Tie
                $team_1_ties += 1;
                $team_2_ties += 1;
                error_log("Updating result: Tie");
            }

            // Log the updated values for debugging
            error_log("Updated Team 1 Wins: " . $team_1_wins);
            error_log("Updated Team 1 Losses: " . $team_1_losses);
            error_log("Updated Team 1 Ties: " . $team_1_ties);

            error_log("Updated Team 2 Wins: " . $team_2_wins);
            error_log("Updated Team 2 Losses: " . $team_2_losses);
            error_log("Updated Team 2 Ties: " . $team_2_ties);

            // Directly update the team records using update_post_meta
            update_post_meta($team_1_id, 'wins', $team_1_wins);
            update_post_meta($team_1_id, 'losses', $team_1_losses);
            update_post_meta($team_1_id, 'ties', $team_1_ties);

            update_post_meta($team_2_id, 'wins', $team_2_wins);
            update_post_meta($team_2_id, 'losses', $team_2_losses);
            update_post_meta($team_2_id, 'ties', $team_2_ties);

            // Log update success
            error_log("Updated Team 1 post: " . wp_update_post(array('ID' => $team_1_id)));
            error_log("Updated Team 2 post: " . wp_update_post(array('ID' => $team_2_id)));
        }
    }
}



//custom filtering of team list when adding new game - filters out teams that aren't in the specified season---must choose season on draw page.
function filter_teams_by_season($args, $field, $post_id) {
    // Get the selected Season taxonomy term for the Schedule post
    $selected_seasons = wp_get_post_terms($post_id, 'season', array('fields' => 'slugs'));

    // If no season is selected, return an empty query (No teams available)
    if (empty($selected_seasons)) {
        $args['post__in'] = array(0); // No results
        return $args;
    }

    // Modify the query to filter by the selected Season taxonomy
    $args['tax_query'] = array(
        array(
            'taxonomy' => 'season',
            'field'    => 'slug',
            'terms'    => $selected_seasons, // Filter teams by selected season
        ),
    );

    return $args;
}

// Apply the filter to all Post Object fields for teams
$team_fields = [
    'team_1_sheet_1', 'team_2_sheet_1',
    'team_1_sheet_2', 'team_2_sheet_2',
    'team_1_sheet_3', 'team_2_sheet_3',
    'team_1_sheet_4', 'team_2_sheet_4',
    'team_1_sheet_5', 'team_2_sheet_5',
    'team_1_sheet_6', 'team_2_sheet_6'
];

foreach ($team_fields as $field_name) {
    add_filter("acf/fields/post_object/query/name={$field_name}", 'filter_teams_by_season', 10, 3);
}


// Custom Admin Page
function tesac_add_admin_page() {
    add_menu_page(
        'League Settings', // Page title
        'League Settings', // Menu title
        'manage_options',  // Capability
        'tesac-league-settings', // Menu slug
        'tesac_display_admin_page', // Function to display the settings page
        'dashicons-admin-generic', // Icon (use dashicons or custom image)
        80 // Position
    );
}
add_action('admin_menu', 'tesac_add_admin_page');

function tesac_display_admin_page() {
    ?>
    <div class="wrap">
        <h1><?php _e('League Settings', 'tesac'); ?></h1>
        <form method="post" action="options.php">
            <?php
            // Add settings fields
            settings_fields('tesac_options_group');
            do_settings_sections('tesac-league-settings');
            ?>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="tesac_current_season"><?php _e('Current Season', 'tesac'); ?></label></th>
                    <td>
                        <?php
                        // Get all terms from the 'season' taxonomy
                        $seasons = get_terms(array(
                            'taxonomy' => 'season',
                            'orderby' => 'name',
                            'order' => 'ASC',
                            'hide_empty' => false
                        ));

                        // Get current season value
                        $current_season = get_option('tesac_current_season', 'winter-2025');

                        // Display the select dropdown
                        if (!empty($seasons) && !is_wp_error($seasons)) {
                            echo '<select name="tesac_current_season" id="tesac_current_season">';
                            foreach ($seasons as $season) {
                                // Compare slug with current season stored in the options
                                $selected = ($current_season === $season->slug) ? 'selected' : ''; 
                                echo '<option value="' . esc_attr($season->slug) . '" ' . $selected . '>' . esc_html($season->name) . '</option>';
                            }
                            echo '</select>';
                        } else {
                            echo '<p>' . __('No seasons found.', 'tesac') . '</p>';
                        }

                        ?>
                    </td>
                </tr>

                <!-- Primary Color Picker -->
                <tr>
                    <th scope="row"><label for="tesac_primary_color"><?php _e('Primary Color', 'tesac'); ?></label></th>
                    <td>
                        <input type="text" name="tesac_primary_color" id="tesac_primary_color" value="<?php echo esc_attr(get_option('tesac_primary_color')); ?>" class="tesac-color-picker" />
                    </td>
                </tr>

                <!-- Secondary Color Picker -->
                <tr>
                    <th scope="row"><label for="tesac_secondary_color"><?php _e('Secondary Color', 'tesac'); ?></label></th>
                    <td>
                        <input type="text" name="tesac_secondary_color" id="tesac_secondary_color" value="<?php echo esc_attr(get_option('tesac_secondary_color')); ?>" class="tesac-color-picker" />
                    </td>
                </tr>

                <!-- Accent Color Picker -->
                <tr>
                    <th scope="row"><label for="tesac_accent_color"><?php _e('Accent Color', 'tesac'); ?></label></th>
                    <td>
                        <input type="text" name="tesac_accent_color" id="tesac_accent_color" value="<?php echo esc_attr(get_option('tesac_accent_color')); ?>" class="tesac-color-picker" />
                    </td>
                </tr>

            </table>

            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

function tesac_register_settings() {

    register_setting('tesac_options_group', 'tesac_current_season');
    register_setting('tesac_options_group', 'tesac_primary_color');
    register_setting('tesac_options_group', 'tesac_secondary_color');
    register_setting('tesac_options_group', 'tesac_accent_color');
}
add_action('admin_init', 'tesac_register_settings');

function tesac_enqueue_color_picker($hook_suffix) {
    // Check if the current page is your custom admin page
    if ('toplevel_page_tesac-league-settings' !== $hook_suffix) {
        return;
    }

    // Enqueue the WordPress color picker styles and script
    wp_enqueue_style('wp-color-picker'); // Load the color picker style
    wp_enqueue_script('wp-color-picker'); // Load the color picker script
    wp_enqueue_script('tesac-color-picker', '', array('wp-color-picker'), false, true); // Initialize custom JS if needed
}
add_action('admin_enqueue_scripts', 'tesac_enqueue_color_picker');

function tesac_inline_color_picker_script() {
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function($){
            // Initialize color pickers for all elements with class .tesac-color-picker
            $('.tesac-color-picker').wpColorPicker();
        });
    </script>
    <?php
}
add_action('admin_footer', 'tesac_inline_color_picker_script');


function tesac_output_dynamic_styles() {
    $primary_color = get_option('tesac_primary_color', '#000080'); // Default Marpole Blue
    $secondary_color = get_option('tesac_secondary_color', '#fdd411'); // Default Marpole Gold
    $accent_color = get_option('tesac_accent_color', '#1f8d1b'); // VCC Green

    echo "<style>
        :root {
            --primary-color: $primary_color;
            --secondary-color: $secondary_color;
            --tertiary-color: $accent_color;
        }
    </style>";
}
add_action('wp_head', 'tesac_output_dynamic_styles');
