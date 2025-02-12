<?php

function enqueue_google_fonts() {
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap', false);
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap', false);
}
add_action('wp_enqueue_scripts', 'enqueue_google_fonts');


function custom_enqueue_styles() {
    // Enqueue main theme stylesheet (optional)
    wp_enqueue_style('theme-style', get_stylesheet_uri());
    
    // Enqueue additional stylesheet
    wp_enqueue_style('custom-style', get_template_directory_uri() . '/style-custom.css');
}
add_action('wp_enqueue_scripts', 'custom_enqueue_styles');


function register_teams_cpt() {
    $labels = array(
        'name'                  => _x( 'Teams', 'Post Type General Name', 'textdomain' ),
        'singular_name'         => _x( 'Team', 'Post Type Singular Name', 'textdomain' ),
        'menu_name'             => __( 'Teams', 'textdomain' ),
        'name_admin_bar'        => __( 'Team', 'textdomain' ),
        'archives'              => __( 'Team Archives', 'textdomain' ),
        'attributes'            => __( 'Team Attributes', 'textdomain' ),
        'parent_item_colon'     => __( 'Parent Team:', 'textdomain' ),
        'all_items'             => __( 'All Teams', 'textdomain' ),
        'add_new_item'          => __( 'Add New Team', 'textdomain' ),
        'add_new'               => __( 'Add New', 'textdomain' ),
        'new_item'              => __( 'New Team', 'textdomain' ),
        'edit_item'             => __( 'Edit Team', 'textdomain' ),
        'update_item'           => __( 'Update Team', 'textdomain' ),
        'view_item'             => __( 'View Team', 'textdomain' ),
        'view_items'            => __( 'View Teams', 'textdomain' ),
        'search_items'          => __( 'Search Team', 'textdomain' ),
        'not_found'             => __( 'Not found', 'textdomain' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'textdomain' ),
        'featured_image'        => __( 'Featured Image', 'textdomain' ),
        'set_featured_image'    => __( 'Set featured image', 'textdomain' ),
        'remove_featured_image' => __( 'Remove featured image', 'textdomain' ),
        'use_featured_image'    => __( 'Use as featured image', 'textdomain' ),
        'insert_into_item'      => __( 'Insert into team', 'textdomain' ),
        'uploaded_to_this_item' => __( 'Uploaded to this team', 'textdomain' ),
        'items_list'            => __( 'Teams list', 'textdomain' ),
        'items_list_navigation' => __( 'Teams list navigation', 'textdomain' ),
        'filter_items_list'     => __( 'Filter teams list', 'textdomain' ),
    );
    
    $args = array(
        'label'                 => __( 'Team', 'textdomain' ),
        'description'           => __( 'Curling league teams', 'textdomain' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'custom-fields' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'supports'              => array( 'title','custom-fields' ),
        'show_in_menu'          => true,
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => false,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
    );
    
    register_post_type( 'teams', $args );
}

add_action( 'init', 'register_teams_cpt', 0 );


// Register Custom Taxonomy - Season - for teams and schedule
function register_season_taxonomy() {
    $labels = array(
        'name'                       => _x( 'Seasons', 'Taxonomy General Name', 'textdomain' ),
        'singular_name'              => _x( 'Season', 'Taxonomy Singular Name', 'textdomain' ),
        'menu_name'                  => __( 'Seasons', 'textdomain' ),
        'all_items'                  => __( 'All Seasons', 'textdomain' ),
        'parent_item'                => __( 'Parent Season', 'textdomain' ),
        'parent_item_colon'          => __( 'Parent Season:', 'textdomain' ),
        'new_item_name'              => __( 'New Season Name', 'textdomain' ),
        'add_new_item'               => __( 'Add New Season', 'textdomain' ),
        'edit_item'                  => __( 'Edit Season', 'textdomain' ),
        'update_item'                => __( 'Update Season', 'textdomain' ),
        'view_item'                  => __( 'View Season', 'textdomain' ),
        'separate_items_with_commas' => __( 'Separate seasons with commas', 'textdomain' ),
        'add_or_remove_items'        => __( 'Add or remove seasons', 'textdomain' ),
        'choose_from_most_used'      => __( 'Choose from the most used', 'textdomain' ),
        'popular_items'              => __( 'Popular Seasons', 'textdomain' ),
        'search_items'               => __( 'Search Seasons', 'textdomain' ),
        'not_found'                  => __( 'Not Found', 'textdomain' ),
        'no_terms'                   => __( 'No seasons', 'textdomain' ),
        'items_list'                 => __( 'Seasons list', 'textdomain' ),
        'items_list_navigation'      => __( 'Seasons list navigation', 'textdomain' ),
    );
    
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'query_var'                  => true,
        'rewrite'                    => array( 'slug' => 'season' ),
    );
    
    register_taxonomy( 'season', array( 'teams', 'schedule' ), $args );
}

add_action( 'init', 'register_season_taxonomy', 0 );


// Register Custom Post Type - Players
function register_players_cpt() {
    $labels = array(
        'name'                  => _x( 'Players', 'Post Type General Name', 'textdomain' ),
        'singular_name'         => _x( 'Player', 'Post Type Singular Name', 'textdomain' ),
        'menu_name'             => __( 'Players', 'textdomain' ),
        'name_admin_bar'        => __( 'Player', 'textdomain' ),
        'archives'              => __( 'Player Archives', 'textdomain' ),
        'attributes'            => __( 'Player Attributes', 'textdomain' ),
        'parent_item_colon'     => __( 'Parent Player:', 'textdomain' ),
        'all_items'             => __( 'All Players', 'textdomain' ),
        'add_new_item'          => __( 'Add New Player', 'textdomain' ),
        'add_new'               => __( 'Add New', 'textdomain' ),
        'new_item'              => __( 'New Player', 'textdomain' ),
        'edit_item'             => __( 'Edit Player', 'textdomain' ),
        'update_item'           => __( 'Update Player', 'textdomain' ),
        'view_item'             => __( 'View Player', 'textdomain' ),
        'view_items'            => __( 'View Players', 'textdomain' ),
        'search_items'          => __( 'Search Player', 'textdomain' ),
        'not_found'             => __( 'Not found', 'textdomain' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'textdomain' ),
        'featured_image'        => __( 'Featured Image', 'textdomain' ),
        'set_featured_image'    => __( 'Set featured image', 'textdomain' ),
        'remove_featured_image' => __( 'Remove featured image', 'textdomain' ),
        'use_featured_image'    => __( 'Use as featured image', 'textdomain' ),
        'insert_into_item'      => __( 'Insert into player', 'textdomain' ),
        'uploaded_to_this_item' => __( 'Uploaded to this player', 'textdomain' ),
        'items_list'            => __( 'Players list', 'textdomain' ),
        'items_list_navigation' => __( 'Players list navigation', 'textdomain' ),
        'filter_items_list'     => __( 'Filter players list', 'textdomain' ),
    );

    $args = array(
        'label'                 => __( 'Player', 'textdomain' ),
        'description'           => __( 'Curling league players', 'textdomain' ),
        'labels'                => $labels,
        'supports'              => array( 'title' ),  // We only need the player name
        'hierarchical'          => false,
        'public'                => false, // Not visible on the frontend
        'show_ui'               => true,
        'show_in_menu'          => true,
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => false, // Prevent it from showing in menus
        'can_export'            => true,
        'has_archive'           => false,
        'exclude_from_search'   => true, // Don’t show in search results
        'publicly_queryable'    => false, // Not publicly accessible
        'capability_type'       => 'post',
    );

    register_post_type( 'player', $args );
}

add_action( 'init', 'register_players_cpt', 0 );


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
