<?php if ( $pages->have_posts() ) : ?>

    <!-- pagination here -->

    <!-- the loop -->
    <?php while ( $pages->have_posts() ) : $pages->the_post(); ?>
        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?> (<?php the_category( ', ' ); ?>)</a></h3>
    <?php endwhile; ?>
    <!-- end of the loop -->

    <!-- pagination here -->

    <?php wp_reset_postdata(); ?>

<?php else:  ?>
    <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
<?php endif; ?>