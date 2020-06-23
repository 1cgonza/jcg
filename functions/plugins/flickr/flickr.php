<?php
	require_once 'class-jcg-plugins-flickr.php';

	$flickr = new Flickr_API();

	$currentPage = isset($_GET['paged']) && is_numeric($_GET['paged']) ? (int)$_GET['paged'] : 1;
	$perPage     = 20;
	$imagesArray = $flickr->get_images_list($perPage, $currentPage);

	/*==================================
	=            PAGINATION            =
	==================================*/
	$totalPages = (int)($flickr->total_images / $perPage);
	$pagesCounter = 1;
	$nav = '';

	if ($totalPages > 1) {

	$nav .= '<div class="jcg-admin-nav">';
		if ($currentPage > 1) {
		$nav .= $flickr->create_pagination_link('jcg-admin-nav-item first-page', 1, '&laquo;');
		$nav .= $flickr->create_pagination_link('jcg-admin-nav-item prev-page', ($currentPage - 1), '&lsaquo;');
		}

		while ($pagesCounter <= $totalPages) {
		if ($currentPage == $pagesCounter) {
			$nav .= '<span class="jcg-admin-nav-item current">' . $pagesCounter . '</span>';
		} else {
			$nav .= $flickr->create_pagination_link('jcg-admin-nav-item', $pagesCounter, $pagesCounter);
		}
		$pagesCounter++;
		}

		if ($currentPage < $totalPages) {
		$nav .= $flickr->create_pagination_link('jcg-admin-nav-item next-page', ($currentPage + 1), '&rsaquo;');
		$nav .= $flickr->create_pagination_link('jcg-admin-nav-item last-page', $totalPages, '&raquo;');
		}

	$nav .= '</div>';
	}
	/*-----  End of PAGINATION  ------*/

	if ( is_array($imagesArray) ) :
	?>
	<div id="jcg-flickr-gallery" class="wrap" data-apikey="<?php echo $flickr->api_key; ?>">
	<?php echo $nav; ?>

	<?php foreach ($imagesArray as $image) { ?>
		<a class="jcg-flickr-img" title="<?php echo $image['title']; ?>" href="#" data-id="<?php echo $image['id']; ?>">
		<img src="<?php echo $image['url']; ?>">
		</a>
	<?php } ?>

	<?php echo $nav; ?>

	<div class="jcg-flickr-data-container"></div>
	</div>
<?php endif;
