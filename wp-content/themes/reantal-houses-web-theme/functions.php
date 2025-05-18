<?php

// ===========================
//  AJAX SEARCH
// ===========================
function ajax_search() {
    $args = [
        'post_type' => 'home',
        'posts_per_page' => -1,
        'meta_query' => [
            [
                'key' => 'availability',
                'value' => 1,
                'compare' => '='
            ]
        ]
    ];

    if (!empty($_POST['search'])) {
        $args['s'] = sanitize_text_field($_POST['search']);
    }

    if (!empty($_POST['price_min'])) {
        $args['meta_query'][] = [
            'key' => 'price',
            'value' => sanitize_text_field($_POST['price_min']),
            'type' => 'NUMERIC',
            'compare' => '>='
        ];
    }

    if (!empty($_POST['price_max'])) {
        $args['meta_query'][] = [
            'key' => 'price',
            'value' => sanitize_text_field($_POST['price_max']),
            'type' => 'NUMERIC',
            'compare' => '<='
        ];
    }

    $query = new WP_Query($args);

    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
            generate_small_home_card();
        endwhile;
    else :
        echo '<p class="text-center">No results found.</p>';
    endif;

    wp_die();
}
add_action('wp_ajax_ajax_search', 'ajax_search');
add_action('wp_ajax_nopriv_ajax_search', 'ajax_search');

function generate_small_home_card() {
    $price = get_post_meta(get_the_ID(), 'price', true);
    $location = get_post_meta(get_the_ID(), 'location', true);
    $image = get_field('image'); ?>

    <div class="col">
        <div class="card h-100">
            <?php if ($image) : ?>
                <img style="width: 100%; height: 200px; object-fit: cover;" src="<?php echo esc_url($image); ?>" class="card-img-top" alt="Home Image">
            <?php else : ?>
                <img style="width: 100%; height: 200px; object-fit: cover;" src="https://via.placeholder.com/600x400" class="card-img-top" alt="Placeholder Image">
            <?php endif; ?>
            <div class="card-body">
                <h5 class="card-title">
                    <a href="<?php the_permalink(); ?>" class="text-decoration-none text-dark">
                        <?php the_title(); ?>
                    </a>
                </h5>
                <p class="card-text"><strong>Price:</strong> <?php echo esc_html($price); ?> USD</p>
                <p class="card-text"><strong>Location:</strong> <?php echo esc_html($location); ?></p>
            </div>
            <div class="card-footer text-center">
                <a href="<?php the_permalink(); ?>" class="btn btn-primary">View Details</a>
            </div>
        </div>
    </div>
<?php
}

// ===========================
//  BOOTSTRAP & FONT AWESOME
// ===========================
function add_bootstrap_to_theme() {
    wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css');
    wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js', [], null, true);
}
add_action('wp_enqueue_scripts', 'add_bootstrap_to_theme');

function enqueue_font_awesome() {
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css', [], '6.5.1');
}
add_action('wp_enqueue_scripts', 'enqueue_font_awesome');

// ===========================
//  ASSET FRONTEND
// ===========================
function rental_homes_assets() {
    wp_enqueue_style('rental_homes_style', get_stylesheet_uri());
    wp_enqueue_script('rental_homes_script', get_template_directory_uri() . '/js/main.js', ['jquery'], false, true);
    wp_localize_script('rental_homes_script', 'ajaxurl', admin_url('admin-ajax.php'));
}
add_action('wp_enqueue_scripts', 'rental_homes_assets');

// ===========================
//  THEME SETUP
// ===========================
function rental_homes_setup() {
    add_theme_support('post-thumbnails');

    register_post_type('home', [
        'label' => 'Homes',
        'public' => true,
        'supports' => ['title', 'editor', 'thumbnail'],
        'has_archive' => true,
        'rewrite' => ['slug' => 'free-now'],
    ]);

    register_taxonomy('home_types', 'home', [
        'label' => 'Home Types',
        'public' => true,
        'hierarchical' => false,
        'rewrite' => ['slug' => 'home-types'],
    ]);

    register_taxonomy('home_category', 'home', [
        'label' => 'Home Categories',
        'public' => true,
        'hierarchical' => true,
        'rewrite' => ['slug' => 'home-category'],
    ]);
}
add_action('init', 'rental_homes_setup');

// ===========================
//  MENU SETUP
// ===========================
function rental_homes_menus() {
    register_nav_menus([
        'primary' => __('Primary Menu', 'rental_homes')
    ]);
}
add_action('after_setup_theme', 'rental_homes_menus');

// ===========================
//  DISPLAY TAXONOMIES
// ===========================
function display_home_types() {
    $home_types = wp_get_post_terms(get_the_ID(), 'home_types');
    if (!empty($home_types) && !is_wp_error($home_types)) {
        echo '<ul class="home-types">';
        foreach ($home_types as $type) {
            echo '<li>' . esc_html($type->name) . '</li>';
        }
        echo '</ul>';
    }
}

function display_home_category() {
    $home_categories = wp_get_post_terms(get_the_ID(), 'home_category');
    if (!empty($home_categories) && !is_wp_error($home_categories)) {
        echo '<ul class="home-categories">';
        foreach ($home_categories as $category) {
            echo '<li>' . esc_html($category->name) . '</li>';
        }
        echo '</ul>';
    }
}

// ===========================
//  TGM PLUGIN ACTIVATION
// ===========================
require_once get_template_directory() . '/inc/class-tgm-plugin-activation.php';

add_action('tgmpa_register', 'rental_homes_register_required_plugins');

function rental_homes_register_required_plugins() {
    $plugins = [
        [
            'name' => 'Advanced Custom Fields',
            'slug' => 'advanced-custom-fields',
            'required' => true,
        ]
    ];

    $config = [
        'id' => 'rental_homes',
        'menu' => 'tgmpa-install-plugins',
        'has_notices' => true,
        'dismissable' => true,
        'is_automatic' => true,
    ];

    tgmpa($plugins, $config);
}

// ===========================
//  REGISTRAZIONE CAMPI ACF
// ===========================
add_action('acf/init', 'rental_homes_register_acf_fields');

function rental_homes_register_acf_fields() {
    if (function_exists('acf_add_local_field_group')) {
        acf_add_local_field_group([
            'key' => 'group_home_fields',
            'title' => 'Home Fields',
            'fields' => [
                [
                    'key' => 'field_price',
                    'label' => 'Price',
                    'name' => 'price',
                    'type' => 'number',
                ],
                [
                    'key' => 'field_location',
                    'label' => 'Location',
                    'name' => 'location',
                    'type' => 'text',
                ],
                [
                    'key' => 'field_image',
                    'label' => 'Image',
                    'name' => 'image',
                    'type' => 'image',
                    'return_format' => 'url',
                ],
                [
                    'key' => 'field_availability',
                    'label' => 'Availability',
                    'name' => 'availability',
                    'type' => 'true_false',
                    'ui' => 1,
                ],
            ],
            'location' => [[
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'home',
                ]
            ]],
        ]);
    }
}



//importanzione automatica dei gruppi di campo per le case 'home details'
add_action( 'acf/include_fields', function() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	acf_add_local_field_group( array(
	'key' => 'group_6792fc36a11a1',
	'title' => 'home detail',
	'fields' => array(
		array(
			'key' => 'field_678e2629f09a9',
			'label' => 'availability',
			'name' => 'availability',
			'aria-label' => '',
			'type' => 'true_false',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'default_value' => 1,
			'allow_in_bindings' => 0,
			'ui' => 0,
			'ui_on_text' => '',
			'ui_off_text' => '',
		),
		array(
			'key' => 'field_678d247783497',
			'label' => 'price',
			'name' => 'price',
			'aria-label' => '',
			'type' => 'number',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'min' => 1,
			'max' => '',
			'allow_in_bindings' => 0,
			'placeholder' => '',
			'step' => '',
			'prepend' => '',
			'append' => '',
		),
		array(
			'key' => 'field_678d24e98349c',
			'label' => 'image',
			'name' => 'image',
			'aria-label' => '',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'url',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
			'allow_in_bindings' => 0,
			'preview_size' => 'medium',
		),
		array(
			'key' => 'field_678d249b83498',
			'label' => 'location',
			'name' => 'location',
			'aria-label' => '',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'maxlength' => '',
			'allow_in_bindings' => 1,
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
		),
		array(
			'key' => 'field_678d24b183499',
			'label' => 'size',
			'name' => 'size',
			'aria-label' => '',
			'type' => 'number',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'min' => 1,
			'max' => '',
			'allow_in_bindings' => 0,
			'placeholder' => '',
			'step' => '',
			'prepend' => '',
			'append' => '',
		),
		array(
			'key' => 'field_678d24d08349a',
			'label' => 'rooms',
			'name' => 'rooms',
			'aria-label' => '',
			'type' => 'number',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'min' => 1,
			'max' => '',
			'allow_in_bindings' => 0,
			'placeholder' => '',
			'step' => '',
			'prepend' => '',
			'append' => '',
		),
		array(
			'key' => 'field_678d24da8349b',
			'label' => 'description',
			'name' => 'description',
			'aria-label' => '',
			'type' => 'textarea',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'maxlength' => '',
			'allow_in_bindings' => 0,
			'rows' => '',
			'placeholder' => '',
			'new_lines' => '',
		),
		array(
			'key' => 'field_67917063126ec',
			'label' => 'services',
			'name' => 'services',
			'aria-label' => '',
			'type' => 'group',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'layout' => 'block',
			'sub_fields' => array(
				array(
					'key' => 'field_6792f17ca8e85',
					'label' => 'basic amenities',
					'name' => 'basic_amenities',
					'aria-label' => '',
					'type' => 'group',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'layout' => 'block',
					'sub_fields' => array(
						array(
							'key' => 'field_6792f3a2a8e8d',
							'label' => 'heating',
							'name' => 'heating',
							'aria-label' => '',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => '',
							'default_value' => 0,
							'allow_in_bindings' => 0,
							'ui' => 0,
							'ui_on_text' => '',
							'ui_off_text' => '',
						),
						array(
							'key' => 'field_6792f3d6a8e8e',
							'label' => 'air conditioning',
							'name' => 'air_conditioning',
							'aria-label' => '',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => '',
							'default_value' => 0,
							'allow_in_bindings' => 0,
							'ui' => 0,
							'ui_on_text' => '',
							'ui_off_text' => '',
						),
						array(
							'key' => 'field_6792f3efa8e8f',
							'label' => 'free wifi',
							'name' => 'free_wifi',
							'aria-label' => '',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => '',
							'default_value' => 0,
							'allow_in_bindings' => 1,
							'ui' => 0,
							'ui_on_text' => '',
							'ui_off_text' => '',
						),
						array(
							'key' => 'field_6792f419a8e90',
							'label' => 'electricity included',
							'name' => 'electricity_included',
							'aria-label' => '',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => '',
							'default_value' => 0,
							'allow_in_bindings' => 0,
							'ui' => 0,
							'ui_on_text' => '',
							'ui_off_text' => '',
						),
						array(
							'key' => 'field_6792f455a8e91',
							'label' => 'hot water',
							'name' => 'hot_water',
							'aria-label' => '',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => '',
							'default_value' => 0,
							'allow_in_bindings' => 0,
							'ui' => 0,
							'ui_on_text' => '',
							'ui_off_text' => '',
						),
						array(
							'key' => 'field_6792f469a8e92',
							'label' => 'gas supply',
							'name' => 'gas_supply',
							'aria-label' => '',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => '',
							'default_value' => 0,
							'allow_in_bindings' => 0,
							'ui' => 0,
							'ui_on_text' => '',
							'ui_off_text' => '',
						),
						array(
							'key' => 'field_6792f479a8e93',
							'label' => 'bed linens and towels',
							'name' => 'bed_linens_and_towels',
							'aria-label' => '',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => '',
							'default_value' => 0,
							'allow_in_bindings' => 0,
							'ui' => 0,
							'ui_on_text' => '',
							'ui_off_text' => '',
						),
					),
				),
				array(
					'key' => 'field_6792f2cba8e86',
					'label' => 'bathroom facilities',
					'name' => 'bathroom_facilities',
					'aria-label' => '',
					'type' => 'group',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'layout' => 'block',
					'sub_fields' => array(
						array(
							'key' => 'field_6792f542a8e94',
							'label' => 'private bathroom',
							'name' => 'private_bathroom',
							'aria-label' => '',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => '',
							'default_value' => 0,
							'allow_in_bindings' => 0,
							'ui' => 0,
							'ui_on_text' => '',
							'ui_off_text' => '',
						),
						array(
							'key' => 'field_6792f59ba8e95',
							'label' => 'bathtub',
							'name' => 'bathtub',
							'aria-label' => '',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => '',
							'default_value' => 0,
							'allow_in_bindings' => 0,
							'ui' => 0,
							'ui_on_text' => '',
							'ui_off_text' => '',
						),
						array(
							'key' => 'field_6792f5aca8e96',
							'label' => 'shower',
							'name' => 'shower',
							'aria-label' => '',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => '',
							'default_value' => 0,
							'allow_in_bindings' => 0,
							'ui' => 0,
							'ui_on_text' => '',
							'ui_off_text' => '',
						),
						array(
							'key' => 'field_6792f5c1a8e97',
							'label' => 'bidet',
							'name' => 'bidet',
							'aria-label' => '',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => '',
							'default_value' => 0,
							'allow_in_bindings' => 0,
							'ui' => 0,
							'ui_on_text' => '',
							'ui_off_text' => '',
						),
						array(
							'key' => 'field_6792f5cfa8e98',
							'label' => 'hairdryer',
							'name' => 'hairdryer',
							'aria-label' => '',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => '',
							'default_value' => 0,
							'allow_in_bindings' => 0,
							'ui' => 0,
							'ui_on_text' => '',
							'ui_off_text' => '',
						),
						array(
							'key' => 'field_6792f5dda8e99',
							'label' => 'complimentary toiletries',
							'name' => 'complimentary_toiletries',
							'aria-label' => '',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => '',
							'default_value' => 0,
							'allow_in_bindings' => 0,
							'ui' => 0,
							'ui_on_text' => '',
							'ui_off_text' => '',
						),
					),
				),
				array(
					'key' => 'field_6792f645a8e9a',
					'label' => 'kitchen',
					'name' => 'kitchen',
					'aria-label' => '',
					'type' => 'group',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'layout' => 'block',
					'sub_fields' => array(
						array(
							'key' => 'field_6792f66da8e9b',
							'label' => 'fully equipped kitchen',
							'name' => 'fully_equipped_kitchen',
							'aria-label' => '',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => '',
							'default_value' => 0,
							'allow_in_bindings' => 0,
							'ui' => 0,
							'ui_on_text' => '',
							'ui_off_text' => '',
						),
						array(
							'key' => 'field_6792f684a8e9c',
							'label' => 'microwave',
							'name' => 'microwave',
							'aria-label' => '',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => '',
							'default_value' => 0,
							'allow_in_bindings' => 0,
							'ui' => 0,
							'ui_on_text' => '',
							'ui_off_text' => '',
						),
						array(
							'key' => 'field_6792f691a8e9d',
							'label' => 'oven',
							'name' => 'oven',
							'aria-label' => '',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => '',
							'default_value' => 0,
							'allow_in_bindings' => 0,
							'ui' => 0,
							'ui_on_text' => '',
							'ui_off_text' => '',
						),
						array(
							'key' => 'field_6792f6a2a8e9e',
							'label' => 'freezer',
							'name' => 'freezer',
							'aria-label' => '',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => '',
							'default_value' => 0,
							'allow_in_bindings' => 0,
							'ui' => 0,
							'ui_on_text' => '',
							'ui_off_text' => '',
						),
						array(
							'key' => 'field_6792f6c6a8e9f',
							'label' => 'dishwasher',
							'name' => 'dishwasher',
							'aria-label' => '',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => '',
							'default_value' => 0,
							'allow_in_bindings' => 0,
							'ui' => 0,
							'ui_on_text' => '',
							'ui_off_text' => '',
						),
						array(
							'key' => 'field_6792f6dba8ea0',
							'label' => 'coffe machine',
							'name' => 'coffe_machine',
							'aria-label' => '',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => '',
							'default_value' => 0,
							'allow_in_bindings' => 0,
							'ui' => 0,
							'ui_on_text' => '',
							'ui_off_text' => '',
						),
						array(
							'key' => 'field_6792f6fca8ea1',
							'label' => 'toaster',
							'name' => 'toaster',
							'aria-label' => '',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => '',
							'default_value' => 0,
							'allow_in_bindings' => 0,
							'ui' => 0,
							'ui_on_text' => '',
							'ui_off_text' => '',
						),
						array(
							'key' => 'field_6792f717a8ea2',
							'label' => 'eletric kettle',
							'name' => 'eletric_kettle',
							'aria-label' => '',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => '',
							'default_value' => 0,
							'allow_in_bindings' => 0,
							'ui' => 0,
							'ui_on_text' => '',
							'ui_off_text' => '',
						),
						array(
							'key' => 'field_6792f736a8ea3',
							'label' => 'set of pots and kitchen utensils',
							'name' => 'set_of_pots_and_kitchen_utensils',
							'aria-label' => '',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => '',
							'default_value' => 0,
							'allow_in_bindings' => 0,
							'ui' => 0,
							'ui_on_text' => '',
							'ui_off_text' => '',
						),
					),
				),
				array(
					'key' => 'field_6792f76ea8ea4',
					'label' => 'entertainment',
					'name' => 'entertainment',
					'aria-label' => '',
					'type' => 'group',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'layout' => 'block',
					'sub_fields' => array(
						array(
							'key' => 'field_6792f782a8ea5',
							'label' => 'hdtv',
							'name' => 'hdtv',
							'aria-label' => '',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => '',
							'default_value' => 0,
							'allow_in_bindings' => 0,
							'ui' => 0,
							'ui_on_text' => '',
							'ui_off_text' => '',
						),
						array(
							'key' => 'field_6792f792a8ea6',
							'label' => 'streaming services',
							'name' => 'streaming_services',
							'aria-label' => '',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => '',
							'default_value' => 0,
							'allow_in_bindings' => 0,
							'ui' => 0,
							'ui_on_text' => '',
							'ui_off_text' => '',
						),
						array(
							'key' => 'field_6792f7cba8ea7',
							'label' => 'surround sound system',
							'name' => 'surround_sound_system',
							'aria-label' => '',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => '',
							'default_value' => 0,
							'allow_in_bindings' => 0,
							'ui' => 0,
							'ui_on_text' => '',
							'ui_off_text' => '',
						),
						array(
							'key' => 'field_6792f7e1a8ea8',
							'label' => 'gaming console',
							'name' => 'gaming_console',
							'aria-label' => '',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => '',
							'default_value' => 0,
							'allow_in_bindings' => 0,
							'ui' => 0,
							'ui_on_text' => '',
							'ui_off_text' => '',
						),
						array(
							'key' => 'field_6792f7fea8ea9',
							'label' => 'board games',
							'name' => 'board_games',
							'aria-label' => '',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => '',
							'default_value' => 0,
							'allow_in_bindings' => 0,
							'ui' => 0,
							'ui_on_text' => '',
							'ui_off_text' => '',
						),
					),
				),
				array(
					'key' => 'field_6792f811a8eaa',
					'label' => 'security features',
					'name' => 'security_features',
					'aria-label' => '',
					'type' => 'group',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'layout' => 'block',
					'sub_fields' => array(
						array(
							'key' => 'field_6792f82ca8eab',
							'label' => 'smoke detectors',
							'name' => 'smoke_detectors',
							'aria-label' => '',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => '',
							'default_value' => 0,
							'allow_in_bindings' => 0,
							'ui' => 0,
							'ui_on_text' => '',
							'ui_off_text' => '',
						),
						array(
							'key' => 'field_6792f83ea8eac',
							'label' => 'carbon monoxide detectors',
							'name' => 'carbon_monoxide_detectors',
							'aria-label' => '',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => '',
							'default_value' => 0,
							'allow_in_bindings' => 0,
							'ui' => 0,
							'ui_on_text' => '',
							'ui_off_text' => '',
						),
						array(
							'key' => 'field_6792f84ea8ead',
							'label' => 'fire extinguisher',
							'name' => 'fire_extinguisher',
							'aria-label' => '',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => '',
							'default_value' => 0,
							'allow_in_bindings' => 0,
							'ui' => 0,
							'ui_on_text' => '',
							'ui_off_text' => '',
						),
						array(
							'key' => 'field_6792f863a8eae',
							'label' => 'safe',
							'name' => 'safe',
							'aria-label' => '',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => '',
							'default_value' => 0,
							'allow_in_bindings' => 0,
							'ui' => 0,
							'ui_on_text' => '',
							'ui_off_text' => '',
						),
						array(
							'key' => 'field_6792f877a8eaf',
							'label' => 'video intercom',
							'name' => 'video_intercom',
							'aria-label' => '',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => '',
							'default_value' => 0,
							'allow_in_bindings' => 0,
							'ui' => 0,
							'ui_on_text' => '',
							'ui_off_text' => '',
						),
					),
				),
				array(
					'key' => 'field_6792f896a8eb0',
					'label' => 'accessibility',
					'name' => 'accessibility',
					'aria-label' => '',
					'type' => 'group',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'layout' => 'block',
					'sub_fields' => array(
						array(
							'key' => 'field_6792f8c2a8eb1',
							'label' => 'wheelchair accessible',
							'name' => 'wheelchair_accessible',
							'aria-label' => '',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => '',
							'default_value' => 0,
							'allow_in_bindings' => 0,
							'ui' => 0,
							'ui_on_text' => '',
							'ui_off_text' => '',
						),
						array(
							'key' => 'field_6792f8d0a8eb2',
							'label' => 'elevator',
							'name' => 'elevator',
							'aria-label' => '',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => '',
							'default_value' => 0,
							'allow_in_bindings' => 0,
							'ui' => 0,
							'ui_on_text' => '',
							'ui_off_text' => '',
						),
						array(
							'key' => 'field_6792f8dca8eb3',
							'label' => 'accessible bathroom',
							'name' => 'accessible_bathroom',
							'aria-label' => '',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => '',
							'default_value' => 0,
							'allow_in_bindings' => 0,
							'ui' => 0,
							'ui_on_text' => '',
							'ui_off_text' => '',
						),
					),
				),
				array(
					'key' => 'field_6792f912a8eb4',
					'label' => 'outdoor and garden',
					'name' => 'outdoor_and_garden',
					'aria-label' => '',
					'type' => 'group',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'layout' => 'block',
					'sub_fields' => array(
						array(
							'key' => 'field_6792f924a8eb5',
							'label' => 'balcony',
							'name' => 'balcony',
							'aria-label' => '',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => '',
							'default_value' => 0,
							'allow_in_bindings' => 0,
							'ui' => 0,
							'ui_on_text' => '',
							'ui_off_text' => '',
						),
						array(
							'key' => 'field_6792f93ca8eb6',
							'label' => 'terrace',
							'name' => 'terrace',
							'aria-label' => '',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => '',
							'default_value' => 0,
							'allow_in_bindings' => 0,
							'ui' => 0,
							'ui_on_text' => '',
							'ui_off_text' => '',
						),
						array(
							'key' => 'field_6792f948a8eb7',
							'label' => 'private garden',
							'name' => 'private_garden',
							'aria-label' => '',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => '',
							'default_value' => 0,
							'allow_in_bindings' => 0,
							'ui' => 0,
							'ui_on_text' => '',
							'ui_off_text' => '',
						),
						array(
							'key' => 'field_6792f95aa8eb8',
							'label' => 'barbecue area',
							'name' => 'barbecue_area',
							'aria-label' => '',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => '',
							'default_value' => 0,
							'allow_in_bindings' => 0,
							'ui' => 0,
							'ui_on_text' => '',
							'ui_off_text' => '',
						),
						array(
							'key' => 'field_6792f968a8eb9',
							'label' => 'pool',
							'name' => 'pool',
							'aria-label' => '',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => '',
							'default_value' => 0,
							'allow_in_bindings' => 0,
							'ui' => 0,
							'ui_on_text' => '',
							'ui_off_text' => '',
						),
						array(
							'key' => 'field_6792f982a8eba',
							'label' => 'free parking',
							'name' => 'free_parking',
							'aria-label' => '',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => '',
							'default_value' => 0,
							'allow_in_bindings' => 1,
							'ui' => 0,
							'ui_on_text' => '',
							'ui_off_text' => '',
						),
					),
				),
				array(
					'key' => 'field_6792f9daa8ebb',
					'label' => 'additional services',
					'name' => 'additional_services',
					'aria-label' => '',
					'type' => 'group',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'layout' => 'block',
					'sub_fields' => array(
						array(
							'key' => 'field_6792f9e9a8ebc',
							'label' => 'washing machine',
							'name' => 'washing_machine',
							'aria-label' => '',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => '',
							'default_value' => 0,
							'allow_in_bindings' => 0,
							'ui' => 0,
							'ui_on_text' => '',
							'ui_off_text' => '',
						),
						array(
							'key' => 'field_6792fa00a8ebd',
							'label' => 'dryer',
							'name' => 'dryer',
							'aria-label' => '',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => '',
							'default_value' => 0,
							'allow_in_bindings' => 0,
							'ui' => 0,
							'ui_on_text' => '',
							'ui_off_text' => '',
						),
						array(
							'key' => 'field_6792fa1ba8ebe',
							'label' => 'included cleaning service',
							'name' => 'included_cleaning_service',
							'aria-label' => '',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => '',
							'default_value' => 0,
							'allow_in_bindings' => 0,
							'ui' => 0,
							'ui_on_text' => '',
							'ui_off_text' => '',
						),
						array(
							'key' => 'field_6792fa2ba8ebf',
							'label' => 'pet friendly',
							'name' => 'pet_friendly',
							'aria-label' => '',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => '',
							'default_value' => 0,
							'allow_in_bindings' => 0,
							'ui' => 0,
							'ui_on_text' => '',
							'ui_off_text' => '',
						),
						array(
							'key' => 'field_6792fa3da8ec0',
							'label' => 'luggage storage',
							'name' => 'luggage_storage',
							'aria-label' => '',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => '',
							'default_value' => 0,
							'allow_in_bindings' => 0,
							'ui' => 0,
							'ui_on_text' => '',
							'ui_off_text' => '',
						),
						array(
							'key' => 'field_6792fa4ca8ec1',
							'label' => 'bicycle rental',
							'name' => 'bicycle_rental',
							'aria-label' => '',
							'type' => 'true_false',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'message' => '',
							'default_value' => 0,
							'allow_in_bindings' => 0,
							'ui' => 0,
							'ui_on_text' => '',
							'ui_off_text' => '',
						),
					),
				),
			),
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'home',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
	'show_in_rest' => 0,
) );
} );






?>