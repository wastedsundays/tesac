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

	<main id="primary" class="schedule-page">

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', 'page' );

			$season_slug = get_option('tesac_current_season', 'winter-2025'); // Default to 'winter-2025' if no option is set



			$args = array(
				'post_type' => 'schedule',
				'posts_per_page' => -1,
				'orderby' => 'date',
				'order' => 'ASC',
				'tax_query' => array(
					array(
						'taxonomy' => 'season', // Replace 'season' with your actual taxonomy name if it's different
						'field' => 'slug',
						'terms' => $season_slug, // Filter by the season slug
						'operator' => 'IN', // Use 'IN' to match any of the terms in the array
					),
				),
			);
			
			// Execute the query
			$query = new WP_Query($args);
			
			$upcoming_draws = array();
			$past_draws = array();
			
			if ($query->have_posts()) :
			
				while ($query->have_posts()) : $query->the_post();
			
					$date = get_field('date');
					$formatted_date = date('F j, Y g:i a', strtotime($date));
					$current_date = current_time('Y-m-d H:i:s'); // Get current time in proper format
			
					// Store the draw info (Title and Date)
					$draw_info = array(
						'title' => get_the_title(),
						'formatted_date' => $formatted_date,
						'class' => (strtotime($date) < strtotime($current_date)) ? 'previous-draw' : 'upcoming-draw',
						'sheets' => array() 
					);
			
					// Loop through sheets 1 to 6
					for ($sheet_number = 1; $sheet_number <= 6; $sheet_number++) {
						$team_1 = get_field("team_1_sheet_$sheet_number");
						$team_2 = get_field("team_2_sheet_$sheet_number");
			
						if ($team_1) {
							$team_1 = get_the_title($team_1);
						}
						if ($team_2) {
							$team_2 = get_the_title($team_2);
						}
			
						if ($team_1 && $team_2) {
							$draw_info['sheets'][] = array(
								'sheet' => $sheet_number,
								'team_1' => $team_1,
								'team_2' => $team_2
							);
						}
					}
			
					// Organize into past or upcoming draws
					if ($draw_info['class'] == 'previous-draw') {
						$past_draws[] = $draw_info;
					} else {
						$upcoming_draws[] = $draw_info;
					}
			
				endwhile;
			
				// Display upcoming draws
				if (!empty($upcoming_draws)) {
					foreach ($upcoming_draws as $draw) {
						?>
						<div class="schedule-post card-container <?php echo $draw['class']; ?>">
							<h2><?php echo $draw['title']; ?></h2>
							<p class="schedule-date-time"><?php echo $draw['formatted_date']; ?></p>
							<div class="draw-matchups">
							<?php
							// Loop through sheets and display each match
							foreach ($draw['sheets'] as $sheet) {
								?>
								<div class="single-matchup">
									<p class="sheet-header">Sheet <?php echo $sheet['sheet']; ?>:</p>
									<p><?php echo $sheet['team_1']; ?></p>
									<p class="smaller-text">vs</p>
									<p><?php echo $sheet['team_2']; ?></p>
								</div>
								<?php
							}
							?>
							</div>
						</div>
						<?php
					}
				}
			
				// Display past draws
				if (!empty($past_draws)) {
					foreach ($past_draws as $draw) {
						?>
						<div class="schedule-post card-container <?php echo $draw['class']; ?>">
							<h2><?php echo $draw['title']; ?></h2>
							<p class="schedule-date-time"><?php echo $draw['formatted_date']; ?></p>
							<div class="draw-matchups">
							<?php
							// Loop through sheets and display each match
							foreach ($draw['sheets'] as $sheet) {
								?>
								<div class="single-matchup">
									<p class="sheet-header">Sheet <?php echo $sheet['sheet']; ?>:</p>
									<p><?php echo $sheet['team_1']; ?></p>
									<p class="smaller-text">vs</p>
									<p><?php echo $sheet['team_2']; ?></p>
								</div>
								<?php
							}
							?>
							</div>
						</div>
						<?php
					}
				}
			
				// Reset post data after the loop
				wp_reset_postdata();
			
			else :
				echo 'No schedule exists for the current season.';
			endif;
			
			

			

			

		endwhile; // End of the loop.
		?>

	</main><!-- #main -->

<?php

get_footer();
