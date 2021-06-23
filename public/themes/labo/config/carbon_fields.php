<?php

// Fields for page et page template
add_action('carbon_fields_register_fields', 'bannerText');

add_action('carbon_fields_register_fields', 'enableBannerCalc');

add_action('carbon_fields_register_fields', 'specialPageTitle');

add_action('carbon_fields_register_fields', 'homeBlocks');

add_action('carbon_fields_register_fields', 'pageAccordions');

add_action('carbon_fields_register_fields', 'page2ColImage');

add_action('carbon_fields_register_fields', 'lastPostsOnPage');

// Fields for post and post type
add_action('carbon_fields_register_fields', 'postHeader');

add_action('carbon_fields_register_fields', 'postFooter');

add_action('carbon_fields_register_fields', 'partnerFields');
