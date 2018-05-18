<?php
/**
 * Pre-process ACF field groups.
 */

/**
 * Render image HTML. We can render optimized image per device here.
 * @param  [type] $image [description]
 * @return [type]        [description]
 */
function bf_render_acf_image($image, $render_title = false) {
  $alt = $image['alt'] ? $image['alt'] : $image['title'];
  $img = '<img class="img-fluid" alt="' . $alt . '" src="' . $image['url'] . '">';
  //$img = '<img class="img-fluid" alt="' . $alt . '" src="" rel="'.$image['url'].'">';

  return $img;
}

/**
 * Get field list data in ACF group.
 * @param  [type] $name [description]
 * @return [type]       [description]
 */
function bf_get_field_acf_group($name, $post_id = NULL, $render = true) {
  $list = array(
    'blocks'    => TRUE,
    'special_offers_catalog' => TRUE,
    'slide_show' => TRUE,
    'winners_choices' => 'option', // Setting option.
    'order_fee' => 'option', // Setting option.
    'money_back_guarantee_page' => 'option', // Setting option.
    'sponsors' => TRUE,
    'url' => TRUE, // Video url.
  );

  if (!isset($list[$name])) {
    return FALSE;
  }

  $value = $list[$name] === TRUE ? $post_id : $list[$name];
  $func = 'bf_get_field_acf_group_' . $name;
  if (!function_exists($func)) {
    return get_field($name, $value);
  }

  $data = $func($value, $render);
  return $data;
}

/**
 * Get field list data in group.
 *
 * @param  [type] $post_id [description]
 * @param  array  $fields  [description]
 * @return [type]          [description]
 */
function bf_get_field_acf_group_fields($post_id = NULL, $fields = array()) {
  $data = array();
  foreach ($fields as $fname) {
    $value = get_field($fname, $post_id);
    $data[$fname] = $value;
  }

  return $data;
}

/**
 * Get Special offers and catalog data.
 *
 * @param  [type] $post_id [description]
 * @return [type]          [description]
 */
function bf_get_field_acf_group_special_offers_catalog($post_id = NULL) {
  $fields = array('special_offers', 'special_offer_is_visible', 'catalog');
  $data = bf_get_field_acf_group_fields($post_id, $fields);

  return $data;
}

/**
 * Get Sponsors data.
 *
 * @param  [type] $post_id [description]
 * @return [type]          [description]
 */
function bf_get_field_acf_group_sponsors($post_id = NULL) {
  $fields = array('banner', 'sponsors_list');
  $data = bf_get_field_acf_group_fields($post_id, $fields);

  return $data;
}

/**
 * Get field list data in Blocks group.
 *
 * @param  [type] $post_id [description]
 * @return [type]          [description]
 */
function bf_get_field_acf_group_blocks($post_id = NULL, $render = true) {
  $blocks = get_field('blocks', $post_id);
  if (!$blocks) {
    return ;
  }

  if (!$render) {
    return $blocks;
  }

  // Render each sub-block.
  $dir_tpl = get_stylesheet_directory(); // Get absolute child theme directory.
  foreach ($blocks as $block) {
    $tpl_name = 'block-' . str_replace('_', '-', $block['acf_fc_layout']) . '.php';
    $tpl_file = $dir_tpl . '/blocks/' . $tpl_name;
    if (file_exists($tpl_file)) {
      include $tpl_file;
    }
    else {
      echo "<!-- Missing block template: " . $tpl_file . " -->";
    }
  }
}
