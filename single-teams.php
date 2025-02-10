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

	<main id="primary" class="site-main">

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', get_post_type() );

			$positions = ['skip', 'third', 'second', 'lead', 'alt']; // Positions array
			$wins = get_field('wins');
			$losses = get_field('losses');
			$ties = get_field('ties');
			// calculate points
			$points = ($wins * 2) + $ties;

			?>

			<p>Wins: <?php echo $wins; ?> | Losses: <?php echo $losses; ?> | Ties: <?php echo $ties; ?> | Points: <?php echo $points; ?></p>
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


			<?php	


			

			the_post_navigation(
				array(
					'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous:', 'tesac-curl' ) . '</span> <span class="nav-title">%title</span>',
					'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next:', 'tesac-curl' ) . '</span> <span class="nav-title">%title</span>',
				)
			);


		endwhile; // End of the loop.
		?>

	</main><!-- #main -->

<?php
get_sidebar();
get_footer();
