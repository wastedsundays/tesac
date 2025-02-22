<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package tesac-curl
 */

get_header();
?>

	<main id="primary" class="team-page">

		<?php
		while ( have_posts() ) :
			the_post();

			// get_template_part( 'template-parts/content', get_post_type() );
			

			$positions = ['skip', 'third', 'second', 'lead', 'alt']; // Positions array
			$wins = get_field('wins');
			$losses = get_field('losses');
			$ties = get_field('ties');
			// calculate points
			$points = ($wins * 2) + $ties;

			?>
			<div class="team-info-container card-container">
				<h1><?php echo get_the_title(); ?></h1>
				<p><?php echo $wins; ?> - <?php echo $losses; ?> - <?php echo $ties; ?> (<?php echo $points; ?> Pts)</p>
				
			</div>
			<div class="team-roster-container card-container">
				<h2>Team Roster</h2>
				<table>
					<thead>
						<tr>
							<th>Position</th>
							<th>Name</th>
						</tr>
					</thead>
					<tbody>
						<?php
							foreach ($positions as $position) {
								$player = get_field($position); // Get the player for each position
								if ($player) {
									echo '<tr>';
									echo '<td>' . ucfirst($position) . '</td>';
									echo '<td>' . get_the_title($player->ID) . '</td>';
									echo '</tr>';
								}
							}

						?>
					</tbody>
				</table>	
			</div>


			<?php	


			$team_id = get_the_ID();  // Get the current team ID
			display_team_results($team_id);
			

		endwhile; // End of the loop.
		?>

	</main><!-- #main -->

<?php

get_footer();
