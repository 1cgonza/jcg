<?php

class Flickr_API {

	public function __construct() {
		$this->api_key      = '019702f1d4d01c6b2c7e1c6e8627f9a2';
		$this->user_id      = '51087543@N08';
		$this->total_images = 0;
		$this->thumbSize    = 'url_q';
	}

	public function get_images_list($perPage, $page) {
		$thumbnails = [];
		$params = array(
			'api_key'     => $this->api_key,
			'user_id'     => $this->user_id,
			'safe_search' => 3,
			'per_page'    => $perPage,
			'page'        => $page,
			'extras'      => $this->thumbSize,
			'method'      => 'flickr.people.getPublicPhotos',
			'format'      => 'php_serial'
		);

		$encoded_params = $this->encode_params($params);
		$imagesList = $this->make_api_request($encoded_params);

		if ( is_array($imagesList) ) {
			$this->total_images = $imagesList['photos']['total'];

			foreach ($imagesList['photos']['photo'] as $image) {
				$thumbnails[] = array(
					'id'    => $image['id'],
					'title' => $image['title'],
					'url'   => $image[$this->thumbSize]
				);
			}
		} else {
			echo $imagesList;
			return;
		}

		return $thumbnails;
	}

	public function render_sizes_data($imageSizes) {
		foreach ($imageSizes['sizes']['size'] as $sizes) {
			echo '<p>' . $sizes['width'] . ' x ' . $sizes['height'] . ' | ' . $sizes['source'] . '</p>';
		}
	}

	public function encode_params($params) {
		$encoded_params = array();

		foreach ($params as $key => $value) {
			$encoded_params[] = urlencode($key) . '=' . urlencode($value);
		}

		return $encoded_params;
	}

	public function make_api_request($encoded_params) {
		$url         = "https://api.flickr.com/services/rest/?" . implode('&', $encoded_params);
		$response    = file_get_contents($url);
		$responseObj = unserialize($response);

		if ($responseObj['stat'] == 'ok') {
			return $responseObj;
		} else {
			return "Call failed!";
		}
	}

	public function create_pagination_link($class, $page, $text) {
		return '<a class="' . $class . '" href="' . $_SERVER['PHP_SELF'] . '?page=jcg_flickr&paged=' . $page . '">' . $text . '</a>';
	}
}
