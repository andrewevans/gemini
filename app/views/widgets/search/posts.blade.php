<?php if ( $posts->have_posts() ) : ?>

    <!-- pagination here -->

    <!-- the loop -->
    <?php while ( $posts->have_posts() ) : $posts->the_post(); ?>
        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
    <?php endwhile; ?>
    <!-- end of the loop -->

    <!-- pagination here -->

    <?php wp_reset_postdata(); ?>

<?php else:  ?>
    <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
<?php endif; ?>