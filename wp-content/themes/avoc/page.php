<?php
/*
* Main Page (Default Template)
*/

//get global prefix
global $sr_prefix;
$theId = sr_getId();

//get template header
get_header();

if (have_posts()) : while (have_posts()) : the_post();

$pTop = '';
if (get_post_meta(get_the_ID(), $sr_prefix.'_paddingtop', true) == 'false') { $pTop = "notoppadding"; }
?>

<?php if (post_password_required()) { ?>
    <div class="wrapper-small align-center">
    <?php the_content(); ?>
    </div>
    <div class="spacer spacer-big"></div>
<?php } else { ?>

<?php if  (get_the_content() != '') {?>
		<!-- SECTION -->
		<section id="section-<?php echo esc_attr($post->post_name); ?>" class="<?php echo esc_attr($pTop); ?>">
          	<div class="section-inner"> 
            
            	<?php if (!get_post_meta($theId, '_sr_pagebuilder_active', true)) { ?>
				<div class="wrapper">
				<?php } ?>
				<?php the_content(); ?>
               	<?php if (!get_post_meta($theId, '_sr_pagebuilder_active', true)) { ?>
				</div><!-- END .wrapper -->
				<?php } ?>
               
                
                <?php if (comments_open() && !post_password_required() ) { comments_template( '', true ); } ?>
                
                <?php 
				if (!get_post_meta($theId, '_sr_pagebuilder_active', true)) {
					echo '<div class="spacer spacer-big spacer-footer"></div>';
				} 
				?>              	
            </div>     
		</section>
		<!-- SECTION -->
<?php } ?>

<?php } ?>
<?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>