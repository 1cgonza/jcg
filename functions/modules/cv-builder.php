<?php
	class CV_Builder {
    public function __construct($category) {
      $this->category = $category;
      $this->separator = ', ';
      $this->date_format = 'Y';
    }

    public function render() {
      $args = array (
        'post_type'      => 'cv_meta',
        'cv_cat'         => $this->category,
        'posts_per_page' => -1,
        'meta_key'       => '_cv_date_end',
        'orderby'        => 'meta_value_num',
        'order'          => 'DESC',
      );
      $cvMetaQuery = new WP_Query($args);

      $HTML = '';

      if ( $cvMetaQuery->have_posts() ) {
        $this->parent_category_data = get_term_by('slug', $this->category, 'cv_cat');
        $HTML .= '<h2 id="jcg-cv-section-' . $this->category . '">' . $this->parent_category_data->name . '</h2>';
        $HTML .= '<table class="jcg-cv-table"><tbody>';
        while ( $cvMetaQuery->have_posts() ) : $cvMetaQuery->the_post();
          $HTML .= $this->jcg_cv_get_item( get_the_ID() );
        endwhile; wp_reset_postdata();
        $HTML .= '</tbody></table>';
      } else {
        return '';
      }

      return $HTML;
    }

    public function jcg_cv_get_item($postID) {
      $prefix     = '_cv_';
      $dateStart  = get_post_meta($postID, $prefix . 'date_start',    true);
      $dateEnd    = get_post_meta($postID, $prefix . 'date_end',      true);
      $url        = get_post_meta($postID, $prefix . 'website_url',   true);
      $city       = get_post_meta($postID, $prefix . 'city',          true);
      $country    = get_post_meta($postID, $prefix . 'country',       true);
      $desc       = get_post_meta($postID, $prefix . 'description',   true);
      $degree     = get_post_meta($postID, $prefix . 'degree',        true);
      $awardTitle = get_post_meta($postID, $prefix . 'award_title',   true);
      $insti      = get_post_meta($postID, $prefix . 'institution',   true);
      $current    = get_post_meta($postID, $prefix . 'date_current',  1);
      $title      = get_the_title();

      $cvItemType = '';
      $cvItemDate = $this->get_date($dateStart, $dateEnd, $current);

      $cvItemFields = [];

      if ($this->category == 'education') {
        $cvItemType = $degree;
      } else {
        $cvItemType = $this->item_type($postID);
      }

      if ( $this->category == 'awards' && !empty($awardTitle) ) {
        $cvItemFields['award_title'] = '<span class="jcg-cv-award-title">' . $awardTitle . '</span>';
      }

      if ( !empty($title) ) {
        $wrapTitle = !empty($url) ? '<a href="' . $url . '" target="_blank">' . $title . '</a>' : $title;
        $cvItemFields['title'] = '<span class="jcg-cv-title">' . $wrapTitle . '</span>';
      }

      /*==========  DESCRIPTION  ==========*/
      $description = '';
      if ( !empty($desc) ) {
        $description = '<div class="jcg-cv-item-description">' . apply_filters('the_content', $desc) . '</div>';
      }

      /*==========  INSTITUTION  ==========*/
      if ( !empty($insti) ) {
        $cvItemFields['institution'] = '<span class="jcg-cv-item-intitution">' . $insti . '</span>';
      }

      /*==========  PLACE  ==========*/
      if ( strcmp($city, $country) !== 0 ) {
        $cityCheck = empty($city) ? '' : $city . $this->separator;
        $cvItemFields['place'] = '<span class="jcg-cv-item-place">' . $cityCheck . $country . '</span>';
      } else {
        $cvItemFields['place'] = '<span class="jcg-cv-item-place">' . $country . '</p>';
      }

      $educationItem = '<tr class="jcg-cv-item">';
        $educationItem .= '<td class="jcg-cv-item-col1 years">' . $cvItemDate . '</td>';
        $educationItem .= '<td class="jcg-cv-item-col2 education-info">';

        if ( !empty($cvItemType) ) {
          $educationItem .= '<span class="jcg-cv-item-type">' . $cvItemType . '</span>';
        }
        if ( !empty($cvItemFields) ) {
          $educationItem .= implode($this->separator, $cvItemFields);
        }
        if ( !empty($description) ) {
          $educationItem .= $description;
        }
        $educationItem .= '</td>'; // end .jcg-cv-item-col2
      $educationItem .= '</tr>'; // end .jcg-cv-item

      return $educationItem;
    }

    public function item_type($postID) {
      $cvType    = '';
      $childrens = [];
      $postTerms = get_the_terms($postID, 'cv_cat');

      foreach ($postTerms as $term) {
        if ( term_is_ancestor_of($this->parent_category_data->term_id, $term->term_id, 'cv_cat') ) {
          $childrens[] = '<span class="jcg-cv-item-type jcg-cv-item-type-' . $this->category . ' jcg-cv-item-type-' . $this->category . '-' . $term->slug . '">' . $term->name . '</span>';
        }
      }

      if ( !empty($childrens) ) {
        $cvType = implode('- ', $childrens);
      }

      return $cvType;
    }

    public function get_date($dateStart, $dateEnd, $currentCheck) {
      $date = '';

      if ( !empty($dateStart) ) {
        $startYear = date_i18n($this->date_format, $dateStart);
        $datesRange = $startYear;

        if ($currentCheck == 'on') {
          $datesRange .= ' - ' . 'Currently';
        } elseif ( !empty($dateEnd) ) {
          $endYear = date_i18n($this->date_format, $dateEnd);

          if ( strcmp($startYear, $endYear) ) {
            $datesRange .= ' - ' . $endYear;
          }
        }

        $date = $datesRange;
      }

      return $date;
    }
}
