<?php 

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
        'rewrite'               => array('slug' => 'teams/%season%',
                                        'with_front' => false,
                                        'feeds' => true,
                                    ),
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
        'has_archive'                => false,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'query_var'                  => true,
        'rewrite'                    => array( 'slug' => 'season',
                                            'with_front' => false,
                                        ),
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