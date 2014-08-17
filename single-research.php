<?php get_header(); ?>

      <div id="content" class="m-all t-4of5 d-9of10 last-col">

          <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class('cf'); ?> role="article">

              <header>
                <h1 class="single-title" itemprop="name"><?php the_title(); ?></h1>
              </header>

              <section class="cf">
                <?php the_content(); ?>
              </section>

              <footer class="article-footer">

              </footer>

              <?php comments_template(); ?>

            </article>

          <?php endwhile; ?>

          <?php else : ?>

            <article id="post-not-found" class="hentry cf">
              <header class="article-header">
                <h1><?php _e( 'Oops, Post Not Found!', 'jcgtheme' ); ?></h1>
              </header>
              <section class="entry-content">
                <p><?php _e( 'Uh Oh. Something is missing. Try double checking things.', 'jcgtheme' ); ?></p>
              </section>
              <footer class="article-footer">
                <p><?php _e( 'This is the error message in the single-custom_type.php template.', 'jcgtheme' ); ?></p>
              </footer>
            </article>

          <?php endif; ?>

      </div>

<?php get_footer(); ?>
