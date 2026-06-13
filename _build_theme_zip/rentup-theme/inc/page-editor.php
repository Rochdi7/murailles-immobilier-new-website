<?php
/**
 * Page editor bridge for template-driven pages.
 *
 * Hardcoded page templates remain in full control of the frontend markup, but
 * their key texts and images become editable from the page editor via
 * per-page post meta. This keeps Polylang translations isolated because each
 * translated page stores its own meta values.
 *
 * @package Murailles Immobilier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Return the meta-box configuration for supported page templates.
 */
function murailles_page_editor_config() {
	return array(
		'front-page' => array(
			'label'    => __( 'Homepage Sections', 'murailles' ),
			'sections' => array(
				array(
					'title'  => __( 'Hero', 'murailles' ),
					'fields' => array(
						array( 'key' => 'hero_bg_image_id', 'label' => __( 'Hero background image', 'murailles' ), 'type' => 'image' ),
						array( 'key' => 'hero_title', 'label' => __( 'Hero title', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'hero_subtitle', 'label' => __( 'Hero subtitle', 'murailles' ), 'type' => 'textarea' ),
					),
				),
				array(
					'title'  => __( 'Affaires du Mois', 'murailles' ),
					'fields' => array(
						array( 'key' => 'adm_heading', 'label' => __( 'Section heading', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'adm_subtitle', 'label' => __( 'Section subtitle', 'murailles' ), 'type' => 'textarea' ),
					),
				),
				array(
					'title'  => __( 'Biens en vedette', 'murailles' ),
					'fields' => array(
						array( 'key' => 'featured_heading', 'label' => __( 'Section heading', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'featured_subtitle', 'label' => __( 'Section subtitle', 'murailles' ), 'type' => 'textarea' ),
						array( 'key' => 'featured_button_label', 'label' => __( 'Button label', 'murailles' ), 'type' => 'text' ),
					),
				),
				array(
					'title'  => __( 'Comment ca marche', 'murailles' ),
					'fields' => array(
						array( 'key' => 'how_heading', 'label' => __( 'Section heading', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'how_subtitle', 'label' => __( 'Section subtitle', 'murailles' ), 'type' => 'textarea' ),
						array( 'key' => 'how_step_1_title', 'label' => __( 'Step 1 title', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'how_step_1_text', 'label' => __( 'Step 1 text', 'murailles' ), 'type' => 'textarea' ),
						array( 'key' => 'how_step_2_title', 'label' => __( 'Step 2 title', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'how_step_2_text', 'label' => __( 'Step 2 text', 'murailles' ), 'type' => 'textarea' ),
						array( 'key' => 'how_step_3_title', 'label' => __( 'Step 3 title', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'how_step_3_text', 'label' => __( 'Step 3 text', 'murailles' ), 'type' => 'textarea' ),
					),
				),
				array(
					'title'  => __( 'Qui sommes-nous', 'murailles' ),
					'fields' => array(
						array( 'key' => 'about_image_id', 'label' => __( 'Section image', 'murailles' ), 'type' => 'image' ),
						array( 'key' => 'about_badge_number', 'label' => __( 'Badge number', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'about_badge_text', 'label' => __( 'Badge label', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'about_eyebrow', 'label' => __( 'Eyebrow', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'about_heading', 'label' => __( 'Heading', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'about_text_1', 'label' => __( 'Paragraph 1', 'murailles' ), 'type' => 'textarea' ),
						array( 'key' => 'about_text_2', 'label' => __( 'Paragraph 2', 'murailles' ), 'type' => 'textarea' ),
						array( 'key' => 'about_text_3', 'label' => __( 'Paragraph 3', 'murailles' ), 'type' => 'textarea' ),
						array( 'key' => 'about_button_label', 'label' => __( 'Button label', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'about_button_url', 'label' => __( 'Button URL', 'murailles' ), 'type' => 'url' ),
					),
				),
				array(
					'title'  => __( 'Homepage Service Cards', 'murailles' ),
					'fields' => array(
						array(
							'key'        => '_murailles_service_cards',
							'label'      => __( 'Service cards', 'murailles' ),
							'type'       => 'repeater',
							'item_label' => __( 'Service card', 'murailles' ),
							'fields'     => array(
								array( 'key' => 'title', 'label' => __( 'Title', 'murailles' ), 'type' => 'text' ),
								array( 'key' => 'description', 'label' => __( 'Description', 'murailles' ), 'type' => 'textarea' ),
								array( 'key' => 'icon_class', 'label' => __( 'Icon class', 'murailles' ), 'type' => 'text' ),
								array( 'key' => 'link_url', 'label' => __( 'Link URL', 'murailles' ), 'type' => 'url' ),
								array( 'key' => 'button_label', 'label' => __( 'Button label', 'murailles' ), 'type' => 'text' ),
								array( 'key' => 'image_id', 'label' => __( 'Optional image', 'murailles' ), 'type' => 'image' ),
								array( 'key' => 'image_url', 'label' => __( 'Fallback image URL', 'murailles' ), 'type' => 'url' ),
								array( 'key' => 'alt_text', 'label' => __( 'Alt text', 'murailles' ), 'type' => 'text' ),
							),
						),
					),
				),
				array(
					'title'  => __( 'Homepage Commitment Block', 'murailles' ),
					'fields' => array(
						array(
							'key'        => '_murailles_commitment_cards',
							'label'      => __( 'Commitment block', 'murailles' ),
							'type'       => 'repeater',
							'item_label' => __( 'Commitment block', 'murailles' ),
							'fields'     => array(
								array( 'key' => 'heading', 'label' => __( 'Services intro heading', 'murailles' ), 'type' => 'text' ),
								array( 'key' => 'title', 'label' => __( 'Block title', 'murailles' ), 'type' => 'text' ),
								array( 'key' => 'subtitle', 'label' => __( 'Block highlight text', 'murailles' ), 'type' => 'textarea' ),
								array( 'key' => 'description', 'label' => __( 'Supporting paragraph', 'murailles' ), 'type' => 'textarea' ),
							),
						),
					),
				),
				array(
					'title'  => __( 'Villes phares', 'murailles' ),
					'fields' => array(
						array( 'key' => 'cities_heading', 'label' => __( 'Section heading', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'cities_subtitle', 'label' => __( 'Section subtitle', 'murailles' ), 'type' => 'textarea' ),
						array(
							'key'        => '_murailles_city_tiles',
							'label'      => __( 'City tiles', 'murailles' ),
							'type'       => 'repeater',
							'item_label' => __( 'City tile', 'murailles' ),
							'fields'     => array(
								array( 'key' => 'title', 'label' => __( 'Title', 'murailles' ), 'type' => 'text' ),
								array( 'key' => 'button_label', 'label' => __( 'Button label', 'murailles' ), 'type' => 'text' ),
								array( 'key' => 'link_url', 'label' => __( 'Link URL', 'murailles' ), 'type' => 'url' ),
								array( 'key' => 'image_id', 'label' => __( 'Tile image', 'murailles' ), 'type' => 'image' ),
								array( 'key' => 'image_url', 'label' => __( 'Fallback image URL', 'murailles' ), 'type' => 'url' ),
								array( 'key' => 'alt_text', 'label' => __( 'Image alt text', 'murailles' ), 'type' => 'text' ),
							),
						),
					),
				),
				array(
					'title'  => __( 'Temoignages', 'murailles' ),
					'fields' => array(
						array( 'key' => 'testimonials_heading', 'label' => __( 'Section heading', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'testimonials_subtitle', 'label' => __( 'Section subtitle', 'murailles' ), 'type' => 'textarea' ),
						array(
							'key'        => '_murailles_home_testimonials',
							'label'      => __( 'Homepage testimonials', 'murailles' ),
							'type'       => 'repeater',
							'item_label' => __( 'Testimonial', 'murailles' ),
							'fields'     => array(
								array( 'key' => 'person_name', 'label' => __( 'Person name', 'murailles' ), 'type' => 'text' ),
								array( 'key' => 'person_role', 'label' => __( 'Person role', 'murailles' ), 'type' => 'text' ),
								array( 'key' => 'rating', 'label' => __( 'Rating', 'murailles' ), 'type' => 'number' ),
								array( 'key' => 'description', 'label' => __( 'Testimonial text', 'murailles' ), 'type' => 'textarea' ),
								array( 'key' => 'image_id', 'label' => __( 'Portrait image', 'murailles' ), 'type' => 'image' ),
								array( 'key' => 'image_url', 'label' => __( 'Fallback image URL', 'murailles' ), 'type' => 'url' ),
								array( 'key' => 'alt_text', 'label' => __( 'Image alt text', 'murailles' ), 'type' => 'text' ),
							),
						),
					),
				),
				array(
					'title'  => __( 'Banniere CTA', 'murailles' ),
					'fields' => array(
						array( 'key' => 'cta_bg_image_id', 'label' => __( 'Background image', 'murailles' ), 'type' => 'image' ),
						array( 'key' => 'cta_eyebrow', 'label' => __( 'Eyebrow', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'cta_title', 'label' => __( 'Heading', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'cta_text', 'label' => __( 'Text', 'murailles' ), 'type' => 'textarea' ),
						array( 'key' => 'cta_primary_label', 'label' => __( 'Primary button label', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'cta_primary_url', 'label' => __( 'Primary button URL', 'murailles' ), 'type' => 'url' ),
						array( 'key' => 'cta_secondary_label', 'label' => __( 'Secondary button label', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'cta_secondary_url', 'label' => __( 'Secondary button URL', 'murailles' ), 'type' => 'url' ),
					),
				),
				array(
					'title'  => __( 'Articles', 'murailles' ),
					'fields' => array(
						array( 'key' => 'blog_heading', 'label' => __( 'Section heading', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'blog_subtitle', 'label' => __( 'Section subtitle', 'murailles' ), 'type' => 'textarea' ),
					),
				),
			),
		),
		'page-templates/about-us.php' => array(
			'label'    => __( 'About Us Sections', 'murailles' ),
			'sections' => array(
				array(
					'title'  => __( 'Hero', 'murailles' ),
					'fields' => array(
						array( 'key' => 'hero_bg_image_id', 'label' => __( 'Hero background image', 'murailles' ), 'type' => 'image' ),
						array( 'key' => 'hero_title', 'label' => __( 'Hero title', 'murailles' ), 'type' => 'text' ),
					),
				),
				array(
					'title'  => __( 'Agency Story', 'murailles' ),
					'fields' => array(
						array( 'key' => 'story_title', 'label' => __( 'Story heading', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'story_subtitle', 'label' => __( 'Story subtitle', 'murailles' ), 'type' => 'textarea' ),
						array( 'key' => 'story_text_1', 'label' => __( 'Story paragraph 1', 'murailles' ), 'type' => 'textarea' ),
						array( 'key' => 'story_text_2', 'label' => __( 'Story paragraph 2', 'murailles' ), 'type' => 'textarea' ),
						array( 'key' => 'story_button_label', 'label' => __( 'Story button label', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'story_button_url', 'label' => __( 'Story button URL', 'murailles' ), 'type' => 'url' ),
						array( 'key' => 'story_image_id', 'label' => __( 'Story image', 'murailles' ), 'type' => 'image' ),
					),
				),
				array(
					'title'  => __( 'Team section', 'murailles' ),
					'fields' => array(
						array( 'key' => 'team_heading', 'label' => __( 'Team heading', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'team_subheading', 'label' => __( 'Team subheading', 'murailles' ), 'type' => 'textarea' ),
					),
				),
				array(
					'title'  => __( 'Distinctions', 'murailles' ),
					'fields' => array(
						array( 'key' => 'awards_eyebrow', 'label' => __( 'Section eyebrow', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'awards_heading', 'label' => __( 'Section heading', 'murailles' ), 'type' => 'textarea' ),
					),
				),
				array(
					'title'  => __( 'Testimonials', 'murailles' ),
					'fields' => array(
						array( 'key' => 'testimonials_heading', 'label' => __( 'Section heading', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'testimonials_subtitle', 'label' => __( 'Section subtitle', 'murailles' ), 'type' => 'textarea' ),
						array(
							'key'        => '_murailles_about_testimonials',
							'label'      => __( 'About page testimonials', 'murailles' ),
							'type'       => 'repeater',
							'item_label' => __( 'Testimonial', 'murailles' ),
							'fields'     => array(
								array( 'key' => 'person_name', 'label' => __( 'Person name', 'murailles' ), 'type' => 'text' ),
								array( 'key' => 'person_role', 'label' => __( 'Person role', 'murailles' ), 'type' => 'text' ),
								array( 'key' => 'rating', 'label' => __( 'Rating', 'murailles' ), 'type' => 'number' ),
								array( 'key' => 'description', 'label' => __( 'Testimonial text', 'murailles' ), 'type' => 'textarea' ),
								array( 'key' => 'image_id', 'label' => __( 'Portrait image', 'murailles' ), 'type' => 'image' ),
								array( 'key' => 'image_url', 'label' => __( 'Fallback image URL', 'murailles' ), 'type' => 'url' ),
								array( 'key' => 'alt_text', 'label' => __( 'Image alt text', 'murailles' ), 'type' => 'text' ),
							),
						),
					),
				),
				array(
					'title'  => __( 'Articles', 'murailles' ),
					'fields' => array(
						array( 'key' => 'blog_heading', 'label' => __( 'Section heading', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'blog_subtitle', 'label' => __( 'Section subtitle', 'murailles' ), 'type' => 'textarea' ),
					),
				),
			),
		),
		'page-templates/contact.php' => array(
			'label'    => __( 'Contact Sections', 'murailles' ),
			'sections' => array(
				array(
					'title'  => __( 'Hero', 'murailles' ),
					'fields' => array(
						array( 'key' => 'hero_bg_image_id', 'label' => __( 'Hero background image', 'murailles' ), 'type' => 'image' ),
						array( 'key' => 'hero_eyebrow', 'label' => __( 'Hero eyebrow', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'hero_title', 'label' => __( 'Hero title', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'hero_subtitle', 'label' => __( 'Hero subtitle', 'murailles' ), 'type' => 'textarea' ),
					),
				),
				array(
					'title'  => __( 'Contact Cards', 'murailles' ),
					'fields' => array(
						array( 'key' => 'phone_label', 'label' => __( 'Phone label', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'phone_value', 'label' => __( 'Phone value', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'phone_note', 'label' => __( 'Phone note', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'email_label', 'label' => __( 'Email label', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'email_value', 'label' => __( 'Email value', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'email_note', 'label' => __( 'Email note', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'address_label', 'label' => __( 'Address label', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'address_line_1', 'label' => __( 'Address line 1', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'address_line_2', 'label' => __( 'Address line 2', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'map_embed_url', 'label' => __( 'Google Maps embed URL', 'murailles' ), 'type' => 'url' ),
					),
				),
				array(
					'title'  => __( 'Form', 'murailles' ),
					'fields' => array(
						array( 'key' => 'form_heading', 'label' => __( 'Form heading', 'murailles' ), 'type' => 'text' ),
					),
				),
				array(
					'title'  => __( 'Latest Properties', 'murailles' ),
					'fields' => array(
						array( 'key' => 'latest_heading', 'label' => __( 'Section heading', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'latest_subtitle', 'label' => __( 'Section subtitle', 'murailles' ), 'type' => 'textarea' ),
					),
				),
				array(
					'title'  => __( 'Articles', 'murailles' ),
					'fields' => array(
						array( 'key' => 'blog_heading', 'label' => __( 'Section heading', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'blog_subtitle', 'label' => __( 'Section subtitle', 'murailles' ), 'type' => 'textarea' ),
					),
				),
			),
		),
		'page-templates/nos-services.php' => array(
			'label'    => __( 'Nos Services Sections', 'murailles' ),
			'sections' => array(
				array(
					'title'  => __( 'Hero', 'murailles' ),
					'fields' => array(
						array( 'key' => 'hero_bg_image_id', 'label' => __( 'Hero background image', 'murailles' ), 'type' => 'image' ),
						array( 'key' => 'hero_eyebrow', 'label' => __( 'Hero eyebrow', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'hero_title', 'label' => __( 'Hero title', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'hero_subtitle', 'label' => __( 'Hero subtitle', 'murailles' ), 'type' => 'textarea' ),
					),
				),
				array(
					'title'  => __( 'Intro', 'murailles' ),
					'fields' => array(
						array( 'key' => 'intro_eyebrow', 'label' => __( 'Intro eyebrow', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'intro_title', 'label' => __( 'Intro title', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'intro_text', 'label' => __( 'Intro text', 'murailles' ), 'type' => 'textarea' ),
					),
				),
				array(
					'title'  => __( 'Callout', 'murailles' ),
					'fields' => array(
						array( 'key' => 'callout_text', 'label' => __( 'Callout text', 'murailles' ), 'type' => 'textarea' ),
					),
				),
			),
		),
		'page-templates/assistance-conseils.php' => array(
			'label'    => __( 'Assistance & Conseils Sections', 'murailles' ),
			'sections' => array(
				array(
					'title'  => __( 'Hero', 'murailles' ),
					'fields' => array(
						array( 'key' => 'hero_bg_image_id', 'label' => __( 'Hero background image', 'murailles' ), 'type' => 'image' ),
						array( 'key' => 'hero_eyebrow', 'label' => __( 'Hero eyebrow', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'hero_title', 'label' => __( 'Hero title', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'hero_subtitle', 'label' => __( 'Hero subtitle', 'murailles' ), 'type' => 'textarea' ),
					),
				),
				array(
					'title'  => __( 'Services intro', 'murailles' ),
					'fields' => array(
						array( 'key' => 'services_eyebrow', 'label' => __( 'Section eyebrow', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'services_heading', 'label' => __( 'Section heading', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'services_subtitle', 'label' => __( 'Section subtitle', 'murailles' ), 'type' => 'textarea' ),
					),
				),
				array(
					'title'  => __( 'Process intro', 'murailles' ),
					'fields' => array(
						array( 'key' => 'process_eyebrow', 'label' => __( 'Section eyebrow', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'process_heading', 'label' => __( 'Section heading', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'process_subtitle', 'label' => __( 'Section subtitle', 'murailles' ), 'type' => 'textarea' ),
					),
				),
				array(
					'title'  => __( 'Partners callout', 'murailles' ),
					'fields' => array(
						array( 'key' => 'partners_eyebrow', 'label' => __( 'Section eyebrow', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'partners_heading', 'label' => __( 'Section heading', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'partners_text', 'label' => __( 'Section text', 'murailles' ), 'type' => 'textarea' ),
						array( 'key' => 'partners_button_label', 'label' => __( 'Button label', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'partners_button_url', 'label' => __( 'Button URL', 'murailles' ), 'type' => 'url' ),
					),
				),
			),
		),
		'page-templates/histoire-marrakech.php' => array(
			'label'    => __( 'Histoire de Marrakech Sections', 'murailles' ),
			'sections' => array(
				array(
					'title'  => __( 'Hero', 'murailles' ),
					'fields' => array(
						array( 'key' => 'hero_bg_image_id', 'label' => __( 'Hero background image', 'murailles' ), 'type' => 'image' ),
						array( 'key' => 'hero_eyebrow', 'label' => __( 'Hero eyebrow', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'hero_title', 'label' => __( 'Hero title', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'hero_subtitle', 'label' => __( 'Hero subtitle', 'murailles' ), 'type' => 'textarea' ),
					),
				),
				array(
					'title'  => __( 'Intro', 'murailles' ),
					'fields' => array(
						array( 'key' => 'intro_quote', 'label' => __( 'Intro quote', 'murailles' ), 'type' => 'textarea' ),
					),
				),
				array(
					'title'  => __( 'Timeline intro', 'murailles' ),
					'fields' => array(
						array( 'key' => 'timeline_eyebrow', 'label' => __( 'Section eyebrow', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'timeline_heading', 'label' => __( 'Section heading', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'timeline_subtitle', 'label' => __( 'Section subtitle', 'murailles' ), 'type' => 'textarea' ),
					),
				),
				array(
					'title'  => __( 'Monuments intro', 'murailles' ),
					'fields' => array(
						array( 'key' => 'monuments_eyebrow', 'label' => __( 'Section eyebrow', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'monuments_heading', 'label' => __( 'Section heading', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'monuments_subtitle', 'label' => __( 'Section subtitle', 'murailles' ), 'type' => 'textarea' ),
					),
				),
			),
		),
		'page-templates/tourisme-marrakech.php' => array(
			'label'    => __( 'Tourisme à Marrakech Sections', 'murailles' ),
			'sections' => array(
				array(
					'title'  => __( 'Hero', 'murailles' ),
					'fields' => array(
						array( 'key' => 'hero_bg_image_id', 'label' => __( 'Hero background image', 'murailles' ), 'type' => 'image' ),
						array( 'key' => 'hero_eyebrow', 'label' => __( 'Hero eyebrow', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'hero_title', 'label' => __( 'Hero title', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'hero_subtitle', 'label' => __( 'Hero subtitle', 'murailles' ), 'type' => 'textarea' ),
					),
				),
				array(
					'title'  => __( 'Places intro', 'murailles' ),
					'fields' => array(
						array( 'key' => 'places_eyebrow', 'label' => __( 'Section eyebrow', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'places_heading', 'label' => __( 'Section heading', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'places_subtitle', 'label' => __( 'Section subtitle', 'murailles' ), 'type' => 'textarea' ),
					),
				),
				array(
					'title'  => __( 'Seasons intro', 'murailles' ),
					'fields' => array(
						array( 'key' => 'seasons_eyebrow', 'label' => __( 'Section eyebrow', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'seasons_heading', 'label' => __( 'Section heading', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'seasons_subtitle', 'label' => __( 'Section subtitle', 'murailles' ), 'type' => 'textarea' ),
					),
				),
				array(
					'title'  => __( 'Food intro', 'murailles' ),
					'fields' => array(
						array( 'key' => 'food_eyebrow', 'label' => __( 'Section eyebrow', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'food_heading', 'label' => __( 'Section heading', 'murailles' ), 'type' => 'text' ),
						array( 'key' => 'food_text', 'label' => __( 'Section text', 'murailles' ), 'type' => 'textarea' ),
					),
				),
			),
		),
	);
}

/**
 * Return visible fallback values for template-driven pages.
 */
function murailles_page_editor_default_values( $template_key, $post_id = 0 ) {
	unset( $post_id );

	switch ( $template_key ) {
		case 'front-page':
			return array(
				'hero_bg_image_id'        => murailles_img( 'villa-luxe-marrakech-hero.webp' ),
				'hero_title'              => murailles_t( 'Trouvez votre prochain bien', false ),
				'hero_subtitle'           => murailles_t( 'Découvrez les nouveaux biens immobiliers à la une dans votre ville.', false ),
				'adm_heading'             => murailles_t( 'Affaires du Mois', false ),
				'adm_subtitle'            => murailles_t( 'Notre sélection du moment : les meilleures opportunités immobilières à ne pas manquer ce mois-ci.', false ),
				'featured_heading'        => murailles_t( 'Biens immobiliers à la une', false ),
				'featured_subtitle'       => murailles_t( 'Une sélection exclusive de riads, villas et appartements à Marrakech, Casablanca, Rabat et dans les plus belles villes du Maroc.', false ),
				'featured_button_label'   => murailles_t( 'Voir tous les biens', false ),
				'how_heading'             => murailles_t( 'Comment ça marche ?', false ),
				'how_subtitle'            => murailles_t( "Trois étapes simples pour trouver le bien immobilier qui vous correspond avec l'Agence Murailles : explorez nos annonces, affinez votre recherche et réservez votre coup de cœur.", false ),
				'how_step_1_title'        => murailles_t( 'Explorez nos annonces', false ),
				'how_step_1_text'         => murailles_t( 'Parcourez notre sélection de riads, villas et appartements à Marrakech, en location ou à la vente.', false ),
				'how_step_2_title'        => murailles_t( 'Trouvez votre bien', false ),
				'how_step_2_text'         => murailles_t( 'Filtrez par ville, type de bien et budget pour découvrir les riads, villas et appartements qui correspondent à vos critères.', false ),
				'how_step_3_title'        => murailles_t( 'Réservez votre bien', false ),
				'how_step_3_text'         => murailles_t( "Contactez notre équipe pour organiser une visite, négocier le prix et finaliser votre acquisition en toute sérénité.", false ),
				'about_image_id'          => murailles_img( 'about-agence-murailles-immobilier.webp' ),
				'about_badge_number'      => '15+',
				'about_badge_text'        => murailles_t( "Années d'expérience", false ),
				'about_eyebrow'           => murailles_t( 'À propos de nous', false ),
				'about_heading'           => murailles_t( 'Qui sommes-nous ?', false ),
				'about_text_1'            => murailles_t( "est sans aucun doute l'agence immobilière la plus investie en termes de suivi et d'accompagnement dans vos projets immobiliers.", false ),
				'about_text_2'            => murailles_t( "Depuis la création de l'agence, le fondateur Youssef MOUMEN a comme principal objectif de dénicher le produit tant espéré par ses clients. La présence et l'implication de notre équipe dans les différents secteurs de Marrakech garantissent une analyse experte de votre bien à vendre ou de votre acquisition au juste prix.", false ),
				'about_text_3'            => murailles_t( "Chaque type de bien et chaque secteur de Marrakech répondent à une logique de marché distincte, c'est l'ensemble de ces savoir-faire que nous mettons à votre disposition.", false ),
				'about_button_label'      => murailles_t( 'Découvrir nos services', false ),
				'about_button_url'        => home_url( '/nos-services/' ),
				'cities_heading'          => murailles_t( 'Villes phares au Maroc', false ),
				'cities_subtitle'         => murailles_t( 'Explorez les biens immobiliers disponibles dans les destinations les plus recherchées du Royaume : Marrakech, Casablanca, Rabat, Tanger et Fès.', false ),
				'testimonials_heading'    => murailles_t( 'Avis de nos clients', false ),
				'testimonials_subtitle'   => murailles_t( 'Découvrez les témoignages de propriétaires et acheteurs qui nous ont fait confiance pour leur projet immobilier au Maroc.', false ),
				'cta_bg_image_id'         => murailles_img( 'villa-luxe-marrakech-hero.webp' ),
				'cta_eyebrow'             => murailles_t( 'Votre projet immobilier', false ),
				'cta_title'               => murailles_t( 'Vous cherchez le lieu idéal pour réaliser votre rêve ?', false ),
				'cta_text'                => murailles_t( "Riads d'exception dans la médina, villas avec piscine à la Palmeraie, appartements modernes à Casablanca ou Rabat — l'Agence Murailles vous accompagne pour trouver le bien qui correspond à votre projet de vie au Maroc.", false ),
				'cta_primary_label'       => murailles_t( 'Voir les biens', false ),
				'cta_primary_url'         => murailles_bien_url(),
				'cta_secondary_label'     => murailles_t( 'Nous contacter', false ),
				'cta_secondary_url'       => home_url( '/contact/' ),
				'blog_heading'            => murailles_t( 'Actualités & Articles', false ),
				'blog_subtitle'           => murailles_t( 'Conseils, tendances du marché et guides pour acheter, vendre ou louer votre bien immobilier au Maroc.', false ),
			);
		case 'page-templates/about-us.php':
			return array(
				'hero_bg_image_id'      => murailles_img( 'about-agence-murailles-immobilier.webp' ),
				'hero_title'            => murailles_t( 'À propos — Qui sommes-nous ?', false ),
				'story_title'           => murailles_t( "L'histoire de notre agence", false ),
				'story_subtitle'        => murailles_t( 'Découvrez notre parcours et notre méthode de travail', false ),
				'story_text_1'          => murailles_t( "Depuis sa création, l'Agence Murailles Immobilier s'investit pleinement dans le suivi et l'accompagnement de ses clients. Nous mettons notre connaissance fine du marché marocain au service de chaque projet : achat, vente, location longue durée ou saisonnière.", false ),
				'story_text_2'          => murailles_t( "Notre équipe sillonne quotidiennement Marrakech et les autres villes du Royaume pour vous proposer une sélection rigoureuse de biens : riads d'exception, villas, appartements modernes, terrains à bâtir et locaux commerciaux.", false ),
				'story_button_label'    => murailles_t( 'En savoir plus', false ),
				'story_button_url'      => home_url( '/contact/' ),
				'story_image_id'        => murailles_img( 'b-1.jpg' ),
				'team_heading'          => murailles_t( 'Notre équipe', false ),
				'team_subheading'       => murailles_t( 'Une équipe professionnelle et dévouée à vos côtés', false ),
				'awards_eyebrow'        => murailles_t( 'Nos distinctions', false ),
				'awards_heading'        => murailles_t( 'Des centaines de clients satisfaits qui continuent à nous faire confiance pour leurs projets immobiliers.', false ),
				'testimonials_heading'  => murailles_t( 'Avis de nos clients', false ),
				'testimonials_subtitle' => murailles_t( 'Découvrez les témoignages de propriétaires et acheteurs qui nous ont fait confiance pour leur projet immobilier au Maroc.', false ),
				'blog_heading'          => murailles_t( 'Actualités & Articles', false ),
				'blog_subtitle'         => murailles_t( 'Conseils, tendances du marché et guides pour acheter, vendre ou louer votre bien immobilier au Maroc.', false ),
			);
		case 'page-templates/contact.php':
			return array(
				'hero_bg_image_id'  => murailles_img( 'contact-agence-immobiliere-marrakech.webp' ),
				'hero_eyebrow'      => murailles_t( 'Contactez-nous', false ),
				'hero_title'        => murailles_t( 'Une équipe à votre écoute', false ),
				'hero_subtitle'     => murailles_t( "Besoin d'aide pour votre projet immobilier ? Nous sommes joignables 7 jours sur 7.", false ),
				'phone_label'       => murailles_t( 'Téléphone', false ),
				'phone_value'       => '+212 (0) 6 61 42 51 50',
				'phone_note'        => murailles_t( 'Joignable 7j/7', false ),
				'email_label'       => murailles_t( 'E-mail', false ),
				'email_value'       => 'contact@murailles-immobilier.com',
				'email_note'        => murailles_t( 'Réponse sous 24h', false ),
				'address_label'     => murailles_t( 'Adresse', false ),
				'address_line_1'    => murailles_t( '13 Rue Mouslim, Résidence Boukar', false ),
				'address_line_2'    => murailles_t( '2ème étage Bureau N°10, Marrakesh 40000', false ),
				'map_embed_url'     => 'https://maps.google.com/maps?q=31.633176,-8.004951&z=16&hl=fr&output=embed',
				'form_heading'      => murailles_t( 'Écrivez-nous', false ),
				'latest_heading'    => murailles_t( 'Nos derniers biens', false ),
				'latest_subtitle'   => murailles_t( "Découvrez les biens immobiliers les plus récemment ajoutés par l'Agence Murailles à travers le Maroc.", false ),
				'blog_heading'      => murailles_t( 'Actualités & Articles', false ),
				'blog_subtitle'     => murailles_t( 'Conseils, tendances du marché et guides pour acheter, vendre ou louer votre bien immobilier au Maroc.', false ),
			);
		case 'page-templates/nos-services.php':
			return array(
				'hero_bg_image_id' => murailles_img( 'nos-services-immobilier-marrakech.webp' ),
				'hero_eyebrow'     => 'Murailles Immobilier',
				'hero_title'       => 'Nos Services',
				'hero_subtitle'    => 'Un savoir-faire complet sur tous les types de biens et tous les secteurs de Marrakech.',
				'intro_eyebrow'    => 'Ce que nous proposons',
				'intro_title'      => "L'Agence Murailles Immobilier vous propose",
				'intro_text'       => "Chaque type de bien et chaque secteur de Marrakech répondent à une logique de marché distincte : c'est l'ensemble de ces savoir-faire que nous mettons à votre disposition.",
				'callout_text'     => "Une approche globale et sécurisante pour votre projet de vie ou d'investissement.",
			);
		case 'page-templates/assistance-conseils.php':
			return array(
				'hero_bg_image_id'      => murailles_img( 'assistance-conseils-immobilier-marrakech.webp' ),
				'hero_eyebrow'          => murailles_t( 'Notre expertise', false ),
				'hero_title'            => murailles_t( 'Assistance & Conseils', false ),
				'hero_subtitle'         => murailles_t( 'Un accompagnement personnalisé à chaque étape de votre projet immobilier au Maroc.', false ),
				'services_eyebrow'      => murailles_t( 'Services', false ),
				'services_heading'      => murailles_t( 'Notre accompagnement', false ),
				'services_subtitle'     => murailles_t( "Murailles Immobilier vous accompagne de A à Z dans votre projet, depuis la première visite jusqu'à la remise des clés.", false ),
				'process_eyebrow'       => murailles_t( 'Processus', false ),
				'process_heading'       => murailles_t( 'Comment nous procédons', false ),
				'process_subtitle'      => murailles_t( 'Une méthode éprouvée en 4 étapes pour sécuriser votre acquisition.', false ),
				'partners_eyebrow'      => murailles_t( 'Notre réseau', false ),
				'partners_heading'      => murailles_t( 'Des partenaires de confiance', false ),
				'partners_text'         => murailles_t( "Banques, notaires, architectes, bureaux d'études, experts-comptables, entrepreneurs, artisans : notre réseau de partenaires marocains met son savoir-faire à votre service pour chaque étape de votre projet immobilier.", false ),
				'partners_button_label' => murailles_t( 'Parlons de votre projet', false ),
				'partners_button_url'   => home_url( '/contact/' ),
			);
		case 'page-templates/histoire-marrakech.php':
			return array(
				'hero_bg_image_id'   => murailles_img( 'histoire-marrakech.webp' ),
				'hero_eyebrow'       => murailles_t( 'Patrimoine', false ),
				'hero_title'         => murailles_t( 'Histoire de Marrakech', false ),
				'hero_subtitle'      => murailles_t( "Mille ans de civilisation, de souks animés et d'architecture berbéro-andalouse au pied de l'Atlas.", false ),
				'intro_quote'        => murailles_t( "Fondée en 1062 par Youssef Ibn Tachfine, Marrakech a tour à tour été capitale des Almoravides, des Almohades et des Saadiens. La ville rouge tient son nom des remparts d'argile qui l'enserrent encore aujourd'hui.", false ),
				'timeline_eyebrow'   => murailles_t( 'Chronologie', false ),
				'timeline_heading'   => murailles_t( 'Une histoire millénaire', false ),
				'timeline_subtitle'  => murailles_t( 'Les grandes dates qui ont façonné la ville rouge.', false ),
				'monuments_eyebrow'  => murailles_t( 'Patrimoine', false ),
				'monuments_heading'  => murailles_t( 'Monuments emblématiques', false ),
				'monuments_subtitle' => murailles_t( "Les joyaux architecturaux qui racontent l'histoire de la ville.", false ),
			);
		case 'page-templates/tourisme-marrakech.php':
			return array(
				'hero_bg_image_id'  => murailles_img( 'tourisme-marrakech.webp' ),
				'hero_eyebrow'      => murailles_t( 'Découvrir', false ),
				'hero_title'        => murailles_t( 'Tourisme à Marrakech', false ),
				'hero_subtitle'     => murailles_t( 'La ville ocre vous ouvre ses portes : palais millénaires, jardins enchantés, gastronomie raffinée et désert mystique.', false ),
				'places_eyebrow'    => murailles_t( 'À ne pas manquer', false ),
				'places_heading'    => murailles_t( 'Lieux incontournables', false ),
				'places_subtitle'   => murailles_t( 'Les sites emblématiques qui font le charme unique de Marrakech.', false ),
				'seasons_eyebrow'   => murailles_t( 'Pratique', false ),
				'seasons_heading'   => murailles_t( 'Quand visiter Marrakech ?', false ),
				'seasons_subtitle'  => murailles_t( 'Le climat de la ville ocre suit le rythme des saisons marocaines.', false ),
				'food_eyebrow'      => murailles_t( 'Gastronomie', false ),
				'food_heading'      => murailles_t( 'Une cuisine de tradition', false ),
				'food_text'         => murailles_t( "La cuisine marocaine, classée par l'UNESCO, est un voyage à elle seule. Tajines mijotés, couscous du vendredi, pâtisseries au miel et thé à la menthe : chaque plat raconte l'art de vivre marocain.", false ),
			);
		default:
			return array();
	}
}

/**
 * Repeatable page-meta definitions for MCP/admin editable card collections.
 */
function murailles_page_editor_repeatable_meta_definitions() {
	return array(
		'_murailles_service_cards' => array(
			'fields' => array(
				array( 'key' => 'title', 'type' => 'string' ),
				array( 'key' => 'description', 'type' => 'string' ),
				array( 'key' => 'icon_class', 'type' => 'string' ),
				array( 'key' => 'link_url', 'type' => 'string', 'format' => 'uri' ),
				array( 'key' => 'button_label', 'type' => 'string' ),
				array( 'key' => 'image_id', 'type' => 'integer' ),
				array( 'key' => 'image_url', 'type' => 'string', 'format' => 'uri' ),
				array( 'key' => 'alt_text', 'type' => 'string' ),
			),
		),
		'_murailles_commitment_cards' => array(
			'fields' => array(
				array( 'key' => 'heading', 'type' => 'string' ),
				array( 'key' => 'title', 'type' => 'string' ),
				array( 'key' => 'subtitle', 'type' => 'string' ),
				array( 'key' => 'description', 'type' => 'string' ),
			),
		),
		'_murailles_city_tiles' => array(
			'fields' => array(
				array( 'key' => 'title', 'type' => 'string' ),
				array( 'key' => 'button_label', 'type' => 'string' ),
				array( 'key' => 'link_url', 'type' => 'string', 'format' => 'uri' ),
				array( 'key' => 'image_id', 'type' => 'integer' ),
				array( 'key' => 'image_url', 'type' => 'string', 'format' => 'uri' ),
				array( 'key' => 'alt_text', 'type' => 'string' ),
			),
		),
		'_murailles_home_testimonials' => array(
			'fields' => array(
				array( 'key' => 'person_name', 'type' => 'string' ),
				array( 'key' => 'person_role', 'type' => 'string' ),
				array( 'key' => 'rating', 'type' => 'number' ),
				array( 'key' => 'description', 'type' => 'string' ),
				array( 'key' => 'image_id', 'type' => 'integer' ),
				array( 'key' => 'image_url', 'type' => 'string', 'format' => 'uri' ),
				array( 'key' => 'alt_text', 'type' => 'string' ),
			),
		),
		'_murailles_about_testimonials' => array(
			'fields' => array(
				array( 'key' => 'person_name', 'type' => 'string' ),
				array( 'key' => 'person_role', 'type' => 'string' ),
				array( 'key' => 'rating', 'type' => 'number' ),
				array( 'key' => 'description', 'type' => 'string' ),
				array( 'key' => 'image_id', 'type' => 'integer' ),
				array( 'key' => 'image_url', 'type' => 'string', 'format' => 'uri' ),
				array( 'key' => 'alt_text', 'type' => 'string' ),
			),
		),
	);
}

/**
 * Default repeatable card content, used both in admin and frontend fallback.
 */
function murailles_page_editor_repeatable_defaults( $template_key ) {
	switch ( $template_key ) {
		case 'front-page':
			return array(
				'_murailles_service_cards' => array(
					array(
						'title'       => murailles_t( "Riads & maisons d'hôtes", false ),
						'description' => murailles_t( 'Un large choix dans la médina, la Kasbah ou dans les alentours de Marrakech.', false ),
						'icon_class'  => 'fa-solid fa-archway',
						'link_url'    => '',
						'button_label'=> '',
						'image_id'    => 0,
						'image_url'   => '',
						'alt_text'    => murailles_t( "Riads & maisons d'hôtes", false ),
					),
					array(
						'title'       => murailles_t( 'Appartements & villas', false ),
						'description' => murailles_t( 'À vendre ou à louer dans les quartiers de Guéliz et Hivernage.', false ),
						'icon_class'  => 'fa-solid fa-building',
						'link_url'    => '',
						'button_label'=> '',
						'image_id'    => 0,
						'image_url'   => '',
						'alt_text'    => murailles_t( 'Appartements & villas', false ),
					),
					array(
						'title'       => murailles_t( 'Commerces & restaurants', false ),
						'description' => murailles_t( 'À vendre ou à louer, courte ou longue durée.', false ),
						'icon_class'  => 'fa-solid fa-utensils',
						'link_url'    => '',
						'button_label'=> '',
						'image_id'    => 0,
						'image_url'   => '',
						'alt_text'    => murailles_t( 'Commerces & restaurants', false ),
					),
					array(
						'title'       => murailles_t( 'Terrains à bâtir', false ),
						'description' => murailles_t( "Route de l'Ourika, Amezmiz, Tahennaoute, Sidi Abdellah Ghiat, Fès, Ouarzazate, Bab Atlas, Palmeraie, Amelkis…", false ),
						'icon_class'  => 'fa-solid fa-map-location-dot',
						'link_url'    => '',
						'button_label'=> '',
						'image_id'    => 0,
						'image_url'   => '',
						'alt_text'    => murailles_t( 'Terrains à bâtir', false ),
					),
					array(
						'title'       => murailles_t( 'Gestion & promotion', false ),
						'description' => murailles_t( 'Ne laissez plus vos biens vacants — rentabilisez-les avec notre service de gestion locative.', false ),
						'icon_class'  => 'fa-solid fa-chart-line',
						'link_url'    => '',
						'button_label'=> '',
						'image_id'    => 0,
						'image_url'   => '',
						'alt_text'    => murailles_t( 'Gestion & promotion', false ),
					),
					array(
						'title'       => murailles_t( 'Accompagnement A à Z', false ),
						'description' => murailles_t( 'Négociation, ouverture de compte, compromis, crédit, acte de vente, clauses suspensives, bail…', false ),
						'icon_class'  => 'fa-solid fa-handshake',
						'link_url'    => '',
						'button_label'=> '',
						'image_id'    => 0,
						'image_url'   => '',
						'alt_text'    => murailles_t( 'Accompagnement A à Z', false ),
					),
				),
				'_murailles_commitment_cards' => array(
					array(
						'heading'     => murailles_t( "L'Agence Murailles Immobilier vous propose :", false ),
						'title'       => murailles_t( 'Notre engagement', false ),
						'subtitle'    => murailles_t( "Une approche globale et sécurisante pour votre projet de vie ou d'investissement.", false ),
						'description' => murailles_t( "Notre réseau de partenaires sérieux — banques, architectes, notaires, bureaux d'étude, experts-comptables, entrepreneurs et artisans — vous accompagne dans chaque étape. Chaque client est unique avec son projet personnel : nous vous conseillons depuis la recherche du bien jusqu'aux travaux de construction ou de rénovation.", false ),
					),
				),
				'_murailles_city_tiles' => array(
					array(
						'title'        => murailles_t( 'Casablanca, Maroc', false ),
						'button_label' => murailles_t( 'Voir les biens', false ),
						'link_url'     => add_query_arg( 'location', 'casablanca', murailles_bien_url() ),
						'image_id'     => 0,
						'image_url'    => murailles_img( 'city-3.png' ),
						'alt_text'     => murailles_t( 'Casablanca, Maroc', false ),
					),
					array(
						'title'        => murailles_t( 'Marrakech, Maroc', false ),
						'button_label' => murailles_t( 'Voir les biens', false ),
						'link_url'     => add_query_arg( 'location', 'marrakech', murailles_bien_url() ),
						'image_id'     => 0,
						'image_url'    => murailles_img( 'city-7.png' ),
						'alt_text'     => murailles_t( 'Marrakech, Maroc', false ),
					),
					array(
						'title'        => murailles_t( 'Rabat, Maroc', false ),
						'button_label' => murailles_t( 'Voir les biens', false ),
						'link_url'     => add_query_arg( 'location', 'rabat', murailles_bien_url() ),
						'image_id'     => 0,
						'image_url'    => murailles_img( 'city-3.png' ),
						'alt_text'     => murailles_t( 'Rabat, Maroc', false ),
					),
					array(
						'title'        => murailles_t( 'Tanger, Maroc', false ),
						'button_label' => murailles_t( 'Voir les biens', false ),
						'link_url'     => add_query_arg( 'location', 'tanger', murailles_bien_url() ),
						'image_id'     => 0,
						'image_url'    => murailles_img( 'city-4.png' ),
						'alt_text'     => murailles_t( 'Tanger, Maroc', false ),
					),
					array(
						'title'        => murailles_t( 'Fès, Maroc', false ),
						'button_label' => murailles_t( 'Voir les biens', false ),
						'link_url'     => add_query_arg( 'location', 'fes', murailles_bien_url() ),
						'image_id'     => 0,
						'image_url'    => murailles_img( 'city-5.png' ),
						'alt_text'     => murailles_t( 'Fès, Maroc', false ),
					),
				),
				'_murailles_home_testimonials' => murailles_page_editor_default_testimonials(),
			);
		case 'page-templates/about-us.php':
			return array(
				'_murailles_about_testimonials' => murailles_page_editor_default_testimonials(),
			);
		default:
			return array();
	}
}

/**
 * Shared default testimonial cards used on the homepage and about page.
 */
function murailles_page_editor_default_testimonials() {
	$copy = murailles_t( "L'équipe d'Agence Murailles m'a accompagnée du premier rendez-vous à la signature. Service réactif, conseils avisés et belle sélection de biens à Marrakech.", false );

	return array(
		array(
			'person_name' => 'Susan D. Murphy',
			'person_role' => murailles_t( 'Propriétaire', false ),
			'rating'      => 4.7,
			'description' => $copy,
			'image_id'    => 0,
			'image_url'   => 'https://i.pravatar.cc/96?img=47',
			'alt_text'    => 'Susan D. Murphy',
		),
		array(
			'person_name' => 'Maxine E. Gagliardi',
			'person_role' => murailles_t( 'Acheteuse, Marrakech', false ),
			'rating'      => 4.5,
			'description' => $copy,
			'image_id'    => 0,
			'image_url'   => 'https://i.pravatar.cc/96?img=32',
			'alt_text'    => 'Maxine E. Gagliardi',
		),
		array(
			'person_name' => 'Roy M. Cardona',
			'person_role' => murailles_t( 'Investisseur', false ),
			'rating'      => 4.9,
			'description' => $copy,
			'image_id'    => 0,
			'image_url'   => 'https://i.pravatar.cc/96?img=12',
			'alt_text'    => 'Roy M. Cardona',
		),
		array(
			'person_name' => 'Dorothy K. Shipton',
			'person_role' => murailles_t( 'Locataire, Casablanca', false ),
			'rating'      => 4.7,
			'description' => $copy,
			'image_id'    => 0,
			'image_url'   => 'https://i.pravatar.cc/96?img=45',
			'alt_text'    => 'Dorothy K. Shipton',
		),
		array(
			'person_name' => 'Robert P. McKissack',
			'person_role' => murailles_t( 'Propriétaire', false ),
			'rating'      => 4.7,
			'description' => $copy,
			'image_id'    => 0,
			'image_url'   => 'https://i.pravatar.cc/96?img=68',
			'alt_text'    => 'Robert P. McKissack',
		),
	);
}

/**
 * Resolve a stable section ID from one config section.
 */
function murailles_page_editor_section_id( $section ) {
	if ( ! empty( $section['id'] ) ) {
		return sanitize_key( $section['id'] );
	}

	if ( ! empty( $section['title'] ) ) {
		return sanitize_title( wp_strip_all_tags( (string) $section['title'] ) );
	}

	return '';
}

/**
 * Return valid section IDs for one supported template.
 */
function murailles_page_editor_section_ids_for_template( $template_key ) {
	$config = murailles_page_editor_config();
	if ( empty( $config[ $template_key ]['sections'] ) ) {
		return array();
	}

	$ids = array();
	foreach ( $config[ $template_key ]['sections'] as $section ) {
		$section_id = murailles_page_editor_section_id( $section );
		if ( '' !== $section_id ) {
			$ids[] = $section_id;
		}
	}

	return array_values( array_unique( $ids ) );
}

/**
 * Register repeatable page meta so Royal MCP can read/write it safely.
 */
function murailles_page_editor_register_repeatable_meta() {
	foreach ( murailles_page_editor_repeatable_meta_definitions() as $meta_key => $definition ) {
		$properties = array();

		foreach ( $definition['fields'] as $field ) {
			$properties[ $field['key'] ] = array_filter(
				array(
					'type'   => $field['type'],
					'format' => isset( $field['format'] ) ? $field['format'] : null,
				)
			);
		}

		register_post_meta(
			'page',
			$meta_key,
			array(
				'single'            => true,
				'type'              => 'array',
				'auth_callback'     => 'murailles_page_editor_meta_auth_callback',
				'sanitize_callback' => 'murailles_page_editor_sanitize_repeatable_meta_value',
				'show_in_rest'      => array(
					'schema' => array(
						'type'  => 'array',
						'items' => array(
							'type'                 => 'object',
							'properties'           => $properties,
							'additionalProperties' => false,
						),
					),
				),
			)
		);
	}
}
add_action( 'init', 'murailles_page_editor_register_repeatable_meta' );

/**
 * Register scalar template section meta for REST-driven editors.
 */
function murailles_page_editor_register_sections_meta() {
	register_post_meta(
		'page',
		'_murailles_page_sections',
		array(
			'single'            => true,
			'type'              => 'object',
			'auth_callback'     => 'murailles_page_editor_meta_auth_callback',
			'sanitize_callback' => 'murailles_page_editor_sanitize_sections_meta_value',
			'show_in_rest'      => array(
				'schema' => array(
					'type'                 => 'object',
					'additionalProperties' => true,
				),
			),
		)
	);
}
add_action( 'init', 'murailles_page_editor_register_sections_meta' );

/**
 * Register page section visibility meta so admin, REST and Royal MCP can
 * safely read and update per-page visibility toggles.
 */
function murailles_page_editor_register_visibility_meta() {
	register_post_meta(
		'page',
		'_murailles_hidden_sections',
		array(
			'single'            => true,
			'type'              => 'array',
			'auth_callback'     => 'murailles_page_editor_meta_auth_callback',
			'sanitize_callback' => 'murailles_page_editor_sanitize_hidden_sections_meta',
			'show_in_rest'      => array(
				'schema' => array(
					'type'  => 'array',
					'items' => array(
						'type' => 'string',
					),
				),
			),
		)
	);
}
add_action( 'init', 'murailles_page_editor_register_visibility_meta' );

/**
 * Capability guard for repeatable page meta.
 */
function murailles_page_editor_meta_auth_callback( $allowed, $meta_key, $post_id ) {
	unset( $allowed, $meta_key );
	return current_user_can( 'edit_post', (int) $post_id );
}

/**
 * Sanitize a repeatable page-meta payload.
 */
function murailles_page_editor_sanitize_repeatable_meta_value( $value, $meta_key = '' ) {
	$definitions = murailles_page_editor_repeatable_meta_definitions();
	if ( ! isset( $definitions[ $meta_key ] ) ) {
		return array();
	}

	return murailles_page_editor_sanitize_repeater_items( $value, $meta_key );
}

/**
 * Sanitize hidden section IDs.
 */
function murailles_page_editor_sanitize_hidden_sections_meta( $value ) {
	if ( ! is_array( $value ) ) {
		return array();
	}

	$clean = array();
	foreach ( $value as $section_id ) {
		$section_id = sanitize_key( $section_id );
		if ( '' !== $section_id ) {
			$clean[] = $section_id;
		}
	}

	return array_values( array_unique( $clean ) );
}

/**
 * Sanitize scalar template-section meta for REST writes.
 */
function murailles_page_editor_sanitize_sections_meta_value( $value ) {
	if ( ! is_array( $value ) ) {
		return array();
	}

	$clean = array();
	foreach ( $value as $key => $field_value ) {
		$key = sanitize_key( $key );
		if ( '' === $key ) {
			continue;
		}

		if ( is_array( $field_value ) || is_object( $field_value ) ) {
			continue;
		}

		if ( is_numeric( $field_value ) && ctype_digit( (string) $field_value ) ) {
			$clean[ $key ] = absint( $field_value );
			continue;
		}

		$clean[ $key ] = sanitize_textarea_field( (string) $field_value );
	}

	return $clean;
}

/**
 * Return a page meta value with a default fallback.
 */
function murailles_get_page_meta_with_default( $meta_key, $default, $post_id = 0 ) {
	$post_id = $post_id ? absint( $post_id ) : get_the_ID();
	if ( ! $post_id ) {
		return $default;
	}

	$value = get_post_meta( $post_id, $meta_key, true );
	return '' === $value || null === $value || array() === $value ? $default : $value;
}

/**
 * Normalize repeater items by merging saved data over defaults.
 */
function murailles_page_editor_normalize_repeater_items( $meta_key, $stored_items, $default_items = array() ) {
	$definitions = murailles_page_editor_repeatable_meta_definitions();
	if ( ! isset( $definitions[ $meta_key ] ) ) {
		return is_array( $stored_items ) ? $stored_items : array();
	}

	$stored_items  = is_array( $stored_items ) ? array_values( $stored_items ) : array();
	$default_items = is_array( $default_items ) ? array_values( $default_items ) : array();
	$item_count    = max( count( $stored_items ), count( $default_items ) );
	$normalized    = array();

	for ( $index = 0; $index < $item_count; $index++ ) {
		$item     = array();
		$stored   = isset( $stored_items[ $index ] ) && is_array( $stored_items[ $index ] ) ? $stored_items[ $index ] : array();
		$defaults = isset( $default_items[ $index ] ) && is_array( $default_items[ $index ] ) ? $default_items[ $index ] : array();

		foreach ( $definitions[ $meta_key ]['fields'] as $field ) {
			$field_key    = $field['key'];
			$item[ $field_key ] = array_key_exists( $field_key, $stored ) ? $stored[ $field_key ] : ( isset( $defaults[ $field_key ] ) ? $defaults[ $field_key ] : '' );
		}

		$normalized[] = $item;
	}

	return $normalized;
}

/**
 * Fetch repeatable page meta with defaults.
 */
function murailles_get_repeatable_meta( $meta_key, $default = array(), $post_id = 0 ) {
	$post_id = $post_id ? absint( $post_id ) : get_the_ID();
	if ( ! $post_id ) {
		return is_array( $default ) ? $default : array();
	}

	$stored = get_post_meta( $post_id, $meta_key, true );
	$items  = murailles_page_editor_normalize_repeater_items( $meta_key, $stored, $default );

	if ( empty( $items ) && is_array( $default ) ) {
		return $default;
	}

	return $items;
}

/**
 * Resolve the image URL for one repeatable item.
 */
function murailles_get_repeatable_image_url( $item, $fallback = '', $size = 'full' ) {
	$image_id = isset( $item['image_id'] ) ? absint( $item['image_id'] ) : 0;
	if ( $image_id ) {
		$url = wp_get_attachment_image_url( $image_id, $size );
		if ( $url ) {
			return $url;
		}
	}

	if ( ! empty( $item['image_url'] ) ) {
		return esc_url_raw( $item['image_url'] );
	}

	return $fallback;
}

/**
 * Resolve the image alt text for one repeatable item.
 */
function murailles_get_repeatable_image_alt( $item, $fallback = '' ) {
	$image_id = isset( $item['image_id'] ) ? absint( $item['image_id'] ) : 0;
	if ( ! empty( $item['alt_text'] ) ) {
		return (string) $item['alt_text'];
	}

	if ( $image_id ) {
		$attachment_alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
		if ( is_string( $attachment_alt ) && '' !== $attachment_alt ) {
			return $attachment_alt;
		}
	}

	if ( ! empty( $item['title'] ) ) {
		return (string) $item['title'];
	}
	if ( ! empty( $item['person_name'] ) ) {
		return (string) $item['person_name'];
	}

	return $fallback;
}

/**
 * Render an image tag from one repeatable item.
 */
function murailles_render_image_from_meta( $item, $attrs = array(), $fallback = '', $size = 'full' ) {
	$image_id = isset( $item['image_id'] ) ? absint( $item['image_id'] ) : 0;
	if ( ! isset( $attrs['alt'] ) || '' === $attrs['alt'] ) {
		$attrs['alt'] = murailles_get_repeatable_image_alt( $item );
	}

	if ( $image_id ) {
		return wp_get_attachment_image( $image_id, $size, false, $attrs );
	}

	$image_url = murailles_get_repeatable_image_url( $item, $fallback, $size );
	if ( ! $image_url ) {
		return '';
	}

	$html_attrs = '';
	foreach ( (array) $attrs as $name => $value ) {
		if ( null === $value || '' === $value ) {
			continue;
		}
		$html_attrs .= sprintf( ' %s="%s"', esc_attr( $name ), esc_attr( $value ) );
	}

	return sprintf( '<img src="%s"%s />', esc_url( $image_url ), $html_attrs );
}

/**
 * Determine which supported template config applies to a page.
 */
function murailles_page_editor_template_key( $post_id ) {
	$post_id = absint( $post_id );
	if ( ! $post_id || 'page' !== get_post_type( $post_id ) ) {
		return '';
	}

	$front_id = (int) get_option( 'page_on_front' );
	if ( $front_id === $post_id ) {
		return 'front-page';
	}

	if ( $front_id && function_exists( 'pll_get_post_translations' ) ) {
		$translations = pll_get_post_translations( $front_id );
		if ( in_array( $post_id, array_map( 'intval', (array) $translations ), true ) ) {
			return 'front-page';
		}
	}

	$template = get_page_template_slug( $post_id );
	return is_string( $template ) ? $template : '';
}

/**
 * Return the stored template sections array for a page.
 */
function murailles_page_sections_data( $post_id = 0 ) {
	static $cache = array();

	$post_id = $post_id ? absint( $post_id ) : get_the_ID();
	if ( ! $post_id ) {
		return array();
	}

	if ( isset( $cache[ $post_id ] ) ) {
		return $cache[ $post_id ];
	}

	$data = get_post_meta( $post_id, '_murailles_page_sections', true );
	$cache[ $post_id ] = is_array( $data ) ? $data : array();
	return $cache[ $post_id ];
}

/**
 * Return page-level hidden section IDs.
 */
function murailles_page_hidden_sections( $post_id = 0 ) {
	$post_id = $post_id ? absint( $post_id ) : get_the_ID();
	if ( ! $post_id ) {
		return array();
	}

	$hidden = get_post_meta( $post_id, '_murailles_hidden_sections', true );
	return is_array( $hidden ) ? array_values( array_unique( array_map( 'sanitize_key', $hidden ) ) ) : array();
}

/**
 * Check whether one template section should render on the frontend.
 */
function murailles_page_section_is_visible( $section_id, $post_id = 0 ) {
	$section_id = sanitize_key( $section_id );
	if ( '' === $section_id ) {
		return true;
	}

	return ! in_array( $section_id, murailles_page_hidden_sections( $post_id ), true );
}

/**
 * Read one template-controlled field with a safe fallback.
 */
function murailles_page_section_meta( $field, $default = '', $post_id = 0 ) {
	$data = murailles_page_sections_data( $post_id );
	return isset( $data[ $field ] ) && '' !== $data[ $field ] ? $data[ $field ] : $default;
}

/**
 * Resolve an attachment ID field for a page section, with optional fallback to
 * the page featured image.
 */
function murailles_page_section_image_id( $field, $post_id = 0, $allow_featured_image = false ) {
	$image_id = absint( murailles_page_section_meta( $field, 0, $post_id ) );
	if ( $image_id ) {
		return $image_id;
	}

	$post_id = $post_id ? absint( $post_id ) : get_the_ID();
	if ( $allow_featured_image && $post_id && has_post_thumbnail( $post_id ) ) {
		return (int) get_post_thumbnail_id( $post_id );
	}

	return 0;
}

/**
 * Resolve the URL for a template-controlled image field.
 */
function murailles_page_section_image_url( $field, $fallback_url, $post_id = 0, $allow_featured_image = false, $size = 'full' ) {
	$image_id = murailles_page_section_image_id( $field, $post_id, $allow_featured_image );
	if ( ! $image_id ) {
		return $fallback_url;
	}

	$url = wp_get_attachment_image_url( $image_id, $size );
	return $url ? $url : $fallback_url;
}

/**
 * Render an inline <img> for a template-controlled attachment with fallback.
 */
function murailles_page_section_image( $field, $fallback_url, $attrs = array(), $post_id = 0, $allow_featured_image = false, $size = 'full' ) {
	$image_id = murailles_page_section_image_id( $field, $post_id, $allow_featured_image );
	if ( $image_id ) {
		return wp_get_attachment_image( $image_id, $size, false, $attrs );
	}

	$html_attrs = '';
	foreach ( (array) $attrs as $name => $value ) {
		if ( null === $value || '' === $value ) {
			continue;
		}
		$html_attrs .= sprintf( ' %s="%s"', esc_attr( $name ), esc_attr( $value ) );
	}

	return sprintf( '<img src="%s"%s />', esc_url( $fallback_url ), $html_attrs );
}

/**
 * Add a contextual explanation above the editor for template-driven pages.
 */
function murailles_page_editor_notice( $post ) {
	if ( ! $post instanceof WP_Post || 'page' !== $post->post_type ) {
		return;
	}

	$template_key = murailles_page_editor_template_key( $post->ID );
	$config       = murailles_page_editor_config();

	if ( ! $template_key || empty( $config[ $template_key ] ) ) {
		return;
	}
	?>
	<div class="notice notice-info inline murailles-template-editor-note">
		<p><strong><?php esc_html_e( 'Template-driven page', 'murailles' ); ?></strong></p>
		<p><?php esc_html_e( 'This page keeps its frontend layout in the theme template. Use the “Template Sections” box below to edit the built-in texts and images. Use the main block editor for optional extra content rendered after the static layout.', 'murailles' ); ?></p>
	</div>
	<?php
}
add_action( 'edit_form_after_title', 'murailles_page_editor_notice' );

/**
 * Register the template sections meta box for supported page templates.
 */
function murailles_page_editor_add_meta_box() {
	add_meta_box(
		'murailles-page-sections',
		__( 'Template Sections', 'murailles' ),
		'murailles_page_editor_render_meta_box',
		'page',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes_page', 'murailles_page_editor_add_meta_box' );

/**
 * Enqueue the media bridge for the page editor.
 */
function murailles_page_editor_assets( $hook ) {
	if ( ! in_array( $hook, array( 'post.php', 'post-new.php' ), true ) ) {
		return;
	}

	$screen = get_current_screen();
	if ( ! $screen || 'page' !== $screen->post_type ) {
		return;
	}

	wp_enqueue_media();
	wp_enqueue_style(
		'murailles-editor-admin',
		get_template_directory_uri() . '/assets/css/editor-admin.css',
		array(),
		wp_get_theme()->get( 'Version' )
	);
	wp_enqueue_script(
		'murailles-editor-bridge',
		get_template_directory_uri() . '/assets/js/editor-bridge.js',
		array( 'jquery' ),
		wp_get_theme()->get( 'Version' ),
		true
	);
}
add_action( 'admin_enqueue_scripts', 'murailles_page_editor_assets' );

/**
 * Return the repeatable meta keys used by one supported template.
 */
function murailles_page_editor_repeatable_keys_for_template( $template_key ) {
	$config = murailles_page_editor_config();

	if ( empty( $config[ $template_key ] ) ) {
		return array();
	}

	$keys = array();
	foreach ( $config[ $template_key ]['sections'] as $section ) {
		foreach ( $section['fields'] as $field ) {
			if ( isset( $field['type'] ) && 'repeater' === $field['type'] ) {
				$keys[] = $field['key'];
			}
		}
	}

	return array_values( array_unique( $keys ) );
}

/**
 * Render one image-picker field.
 */
function murailles_page_editor_render_media_field( $input_name, $input_id, $stored_value, $default_value ) {
	$preview = '';
	if ( $stored_value ) {
		$preview = wp_get_attachment_image_url( absint( $stored_value ), 'medium' );
	} elseif ( is_string( $default_value ) && $default_value ) {
		$preview = esc_url_raw( $default_value );
	}
	?>
	<div class="murailles-media-field">
		<input type="hidden" name="<?php echo esc_attr( $input_name ); ?>" id="<?php echo esc_attr( $input_id ); ?>" value="<?php echo esc_attr( $stored_value ); ?>" />
		<div class="murailles-media-preview<?php echo $preview ? '' : ' is-empty'; ?>">
			<?php if ( $preview ) : ?>
				<img src="<?php echo esc_url( $preview ); ?>" alt="" />
			<?php else : ?>
				<span><?php esc_html_e( 'No image selected. The frontend fallback image will be used.', 'murailles' ); ?></span>
			<?php endif; ?>
		</div>
		<div class="murailles-media-actions">
			<button type="button" class="button murailles-media-select" data-target="<?php echo esc_attr( $input_id ); ?>"><?php esc_html_e( 'Choose image', 'murailles' ); ?></button>
			<button type="button" class="button-link-delete murailles-media-clear<?php echo $stored_value ? '' : ' is-hidden'; ?>" data-target="<?php echo esc_attr( $input_id ); ?>"><?php esc_html_e( 'Remove', 'murailles' ); ?></button>
		</div>
	</div>
	<?php
}

/**
 * Render one repeatable field collection using a fixed number of rows.
 */
function murailles_page_editor_render_repeater_field( $post_id, $template_key, $field ) {
	$meta_key       = $field['key'];
	$repeat_defaults = murailles_page_editor_repeatable_defaults( $template_key );
	$default_items  = isset( $repeat_defaults[ $meta_key ] ) && is_array( $repeat_defaults[ $meta_key ] ) ? $repeat_defaults[ $meta_key ] : array();
	$stored_items   = get_post_meta( $post_id, $meta_key, true );
	$items          = murailles_page_editor_normalize_repeater_items( $meta_key, $stored_items, $default_items );
	$item_label     = isset( $field['item_label'] ) ? $field['item_label'] : __( 'Item', 'murailles' );

	if ( empty( $items ) && ! empty( $default_items ) ) {
		$items = $default_items;
	}
	?>
	<div class="murailles-repeater" data-meta-key="<?php echo esc_attr( $meta_key ); ?>">
		<?php foreach ( $items as $index => $item ) : ?>
			<div class="murailles-repeater-item">
				<h4 class="murailles-repeater-item__title"><?php echo esc_html( sprintf( '%s %d', $item_label, $index + 1 ) ); ?></h4>
				<div class="murailles-repeater-grid">
					<?php foreach ( $field['fields'] as $subfield ) : ?>
						<?php
						$sub_key       = $subfield['key'];
						$sub_type      = $subfield['type'];
						$input_name    = sprintf( 'murailles_repeaters[%1$s][%2$d][%3$s]', $meta_key, $index, $sub_key );
						$input_id      = sprintf( 'murailles_%1$s_%2$d_%3$s', sanitize_key( $meta_key ), $index, $sub_key );
						$stored_value  = isset( $item[ $sub_key ] ) ? $item[ $sub_key ] : '';
						$default_value = isset( $default_items[ $index ][ $sub_key ] ) ? $default_items[ $index ][ $sub_key ] : '';
						?>
						<div class="murailles-repeater-field murailles-repeater-field--<?php echo esc_attr( $sub_type ); ?>">
							<label for="<?php echo esc_attr( $input_id ); ?>"><?php echo esc_html( $subfield['label'] ); ?></label>
							<?php if ( 'image' === $sub_type ) : ?>
								<?php murailles_page_editor_render_media_field( $input_name, $input_id, $stored_value, $default_value ); ?>
							<?php elseif ( 'textarea' === $sub_type ) : ?>
								<textarea class="large-text" rows="4" name="<?php echo esc_attr( $input_name ); ?>" id="<?php echo esc_attr( $input_id ); ?>"><?php echo esc_textarea( $stored_value ); ?></textarea>
							<?php else : ?>
								<input class="regular-text<?php echo 'url' === $sub_type ? ' code' : ''; ?>" type="<?php echo esc_attr( 'number' === $sub_type ? 'number' : $sub_type ); ?>" step="<?php echo esc_attr( 'number' === $sub_type ? '0.1' : '' ); ?>" name="<?php echo esc_attr( $input_name ); ?>" id="<?php echo esc_attr( $input_id ); ?>" value="<?php echo esc_attr( $stored_value ); ?>" />
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
	<?php
}

/**
 * Render the supported template fields.
 */
function murailles_page_editor_render_meta_box( $post ) {
	$template_key = murailles_page_editor_template_key( $post->ID );
	$config       = murailles_page_editor_config();

	if ( ! $template_key || empty( $config[ $template_key ] ) ) {
		echo '<p>' . esc_html__( 'This page currently uses the standard editor only. Template-specific section controls appear here when the page uses a supported custom template or is assigned as the site homepage.', 'murailles' ) . '</p>';
		return;
	}

	wp_nonce_field( 'murailles_page_sections_save', 'murailles_page_sections_nonce' );
	$data            = murailles_page_sections_data( $post->ID );
	$defaults        = murailles_page_editor_default_values( $template_key, $post->ID );
	$hidden_sections = murailles_page_hidden_sections( $post->ID );
	?>
	<div class="murailles-page-sections-wrap">
		<?php foreach ( $config[ $template_key ]['sections'] as $section ) : ?>
			<?php $section_id = murailles_page_editor_section_id( $section ); ?>
			<div class="murailles-page-sections-group">
				<h3><?php echo esc_html( $section['title'] ); ?></h3>
				<?php if ( '' !== $section_id ) : ?>
					<p>
						<label>
							<input type="checkbox" name="murailles_visible_sections[]" value="<?php echo esc_attr( $section_id ); ?>" <?php checked( ! in_array( $section_id, $hidden_sections, true ) ); ?> />
							<?php esc_html_e( 'Show this section on the frontend', 'murailles' ); ?>
						</label>
					</p>
				<?php endif; ?>
				<table class="form-table" role="presentation">
					<tbody>
					<?php foreach ( $section['fields'] as $field ) : ?>
						<?php
						$key           = $field['key'];
						$type          = $field['type'];
						if ( 'repeater' === $type ) {
							?>
							<tr>
								<th scope="row"><?php echo esc_html( $field['label'] ); ?></th>
								<td><?php murailles_page_editor_render_repeater_field( $post->ID, $template_key, $field ); ?></td>
							</tr>
							<?php
							continue;
						}
						$stored_value  = isset( $data[ $key ] ) ? $data[ $key ] : '';
						$default_value = isset( $defaults[ $key ] ) ? $defaults[ $key ] : '';
						$value         = '' !== $stored_value ? $stored_value : $default_value;
						?>
						<tr>
							<th scope="row"><label for="<?php echo esc_attr( 'murailles_' . $key ); ?>"><?php echo esc_html( $field['label'] ); ?></label></th>
							<td>
								<?php if ( 'image' === $type ) : ?>
									<?php murailles_page_editor_render_media_field( 'murailles_page_sections[' . $key . ']', 'murailles_' . $key, $stored_value, $default_value ); ?>
								<?php elseif ( 'textarea' === $type ) : ?>
									<textarea class="large-text" rows="4" name="murailles_page_sections[<?php echo esc_attr( $key ); ?>]" id="<?php echo esc_attr( 'murailles_' . $key ); ?>"><?php echo esc_textarea( $value ); ?></textarea>
								<?php else : ?>
									<input class="regular-text<?php echo 'url' === $type ? ' code' : ''; ?>" type="<?php echo esc_attr( $type ); ?>" name="murailles_page_sections[<?php echo esc_attr( $key ); ?>]" id="<?php echo esc_attr( 'murailles_' . $key ); ?>" value="<?php echo esc_attr( $value ); ?>" />
								<?php endif; ?>
							</td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		<?php endforeach; ?>
	</div>
	<?php
}

/**
 * Sanitize one repeatable meta collection.
 */
function murailles_page_editor_sanitize_repeater_items( $raw_items, $meta_key ) {
	$definitions = murailles_page_editor_repeatable_meta_definitions();
	if ( empty( $definitions[ $meta_key ]['fields'] ) || ! is_array( $raw_items ) ) {
		return array();
	}

	$clean = array();
	foreach ( $raw_items as $raw_item ) {
		if ( ! is_array( $raw_item ) ) {
			continue;
		}

		$item      = array();
		$has_value = false;

		foreach ( $definitions[ $meta_key ]['fields'] as $field ) {
			$field_key = $field['key'];
			$field_type = $field['type'];
			$value     = isset( $raw_item[ $field_key ] ) ? $raw_item[ $field_key ] : '';

			switch ( $field_type ) {
				case 'integer':
				case 'image':
					$value = absint( $value );
					break;
				case 'number':
					$value = '' === $value ? '' : (float) $value;
					break;
				case 'string':
				case 'url':
					$value = isset( $field['format'] ) && 'uri' === $field['format']
						? esc_url_raw( $value )
						: sanitize_text_field( $value );
					break;
				case 'textarea':
					$value = sanitize_textarea_field( $value );
					break;
				case 'text':
				default:
					$value = sanitize_text_field( $value );
					break;
			}

			if ( '' !== $value && 0 !== $value && 0.0 !== $value ) {
				$has_value = true;
			}

			$item[ $field_key ] = $value;
		}

		if ( $has_value ) {
			$clean[] = $item;
		}
	}

	return $clean;
}

/**
 * Sanitize the submitted template sections data for one page.
 */
function murailles_page_editor_sanitize_sections( $raw_sections, $template_key ) {
	$config = murailles_page_editor_config();
	if ( empty( $config[ $template_key ] ) || ! is_array( $raw_sections ) ) {
		return array();
	}

	$clean = array();
	foreach ( $config[ $template_key ]['sections'] as $section ) {
		foreach ( $section['fields'] as $field ) {
			if ( 'repeater' === $field['type'] ) {
				continue;
			}

			$key = $field['key'];
			if ( ! array_key_exists( $key, $raw_sections ) ) {
				continue;
			}

			$value = $raw_sections[ $key ];
			switch ( $field['type'] ) {
				case 'image':
					$clean[ $key ] = absint( $value );
					break;
				case 'url':
					$clean[ $key ] = esc_url_raw( $value );
					break;
				case 'textarea':
					$clean[ $key ] = sanitize_textarea_field( $value );
					break;
				case 'text':
				default:
					$clean[ $key ] = sanitize_text_field( $value );
					break;
			}
		}
	}

	return $clean;
}

/**
 * Save the page-template sections on page save.
 */
function murailles_page_editor_save( $post_id, $post ) {
	if ( ! $post instanceof WP_Post || 'page' !== $post->post_type ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( wp_is_post_revision( $post_id ) ) {
		return;
	}
	if ( ! isset( $_POST['murailles_page_sections_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['murailles_page_sections_nonce'] ) ), 'murailles_page_sections_save' ) ) {
		return;
	}
	if ( ! current_user_can( 'edit_page', $post_id ) ) {
		return;
	}

	$template_key = murailles_page_editor_template_key( $post_id );
	if ( ! $template_key ) {
		delete_post_meta( $post_id, '_murailles_page_sections' );
		delete_post_meta( $post_id, '_murailles_hidden_sections' );
		foreach ( array_keys( murailles_page_editor_repeatable_meta_definitions() ) as $meta_key ) {
			delete_post_meta( $post_id, $meta_key );
		}
		return;
	}

	$raw   = isset( $_POST['murailles_page_sections'] ) ? wp_unslash( $_POST['murailles_page_sections'] ) : array();
	$clean = murailles_page_editor_sanitize_sections( $raw, $template_key );

	if ( empty( $clean ) ) {
		delete_post_meta( $post_id, '_murailles_page_sections' );
	} else {
		update_post_meta( $post_id, '_murailles_page_sections', $clean );
	}

	$valid_section_ids   = murailles_page_editor_section_ids_for_template( $template_key );
	$visible_sections    = isset( $_POST['murailles_visible_sections'] ) ? wp_unslash( $_POST['murailles_visible_sections'] ) : array();
	$visible_sections    = is_array( $visible_sections ) ? array_map( 'sanitize_key', $visible_sections ) : array();
	$visible_sections    = array_values( array_intersect( $valid_section_ids, $visible_sections ) );
	$hidden_sections     = array_values( array_diff( $valid_section_ids, $visible_sections ) );

	if ( empty( $hidden_sections ) ) {
		delete_post_meta( $post_id, '_murailles_hidden_sections' );
	} else {
		update_post_meta( $post_id, '_murailles_hidden_sections', $hidden_sections );
	}

	$raw_repeaters   = isset( $_POST['murailles_repeaters'] ) ? wp_unslash( $_POST['murailles_repeaters'] ) : array();
	$template_repeaters = murailles_page_editor_repeatable_keys_for_template( $template_key );

	foreach ( array_keys( murailles_page_editor_repeatable_meta_definitions() ) as $meta_key ) {
		if ( ! in_array( $meta_key, $template_repeaters, true ) ) {
			delete_post_meta( $post_id, $meta_key );
			continue;
		}

		$clean_items = array();
		if ( isset( $raw_repeaters[ $meta_key ] ) ) {
			$clean_items = murailles_page_editor_sanitize_repeater_items( $raw_repeaters[ $meta_key ], $meta_key );
		}

		if ( empty( $clean_items ) ) {
			delete_post_meta( $post_id, $meta_key );
		} else {
			update_post_meta( $post_id, $meta_key, $clean_items );
		}
	}
}
add_action( 'save_post_page', 'murailles_page_editor_save', 10, 2 );

/**
 * Seed translation pages with the source page's section meta when Polylang
 * creates a translated draft from an existing page.
 */
function murailles_page_editor_copy_translation_meta( $new_id, $new_post, $update ) {
	if ( $update || ! is_admin() || 'page' !== $new_post->post_type ) {
		return;
	}
	if ( empty( $_GET['from_post'] ) || empty( $_GET['new_lang'] ) ) {
		return;
	}

	$source_id = absint( $_GET['from_post'] );
	if ( ! $source_id || $source_id === $new_id ) {
		return;
	}

	if ( get_post_meta( $new_id, '_murailles_page_sections', true ) ) {
		$has_sections = true;
	} else {
		$has_sections = false;
	}

	$source_meta = get_post_meta( $source_id, '_murailles_page_sections', true );
	if ( ! $has_sections && is_array( $source_meta ) && ! empty( $source_meta ) ) {
		update_post_meta( $new_id, '_murailles_page_sections', $source_meta );
	}

	$source_hidden_sections = get_post_meta( $source_id, '_murailles_hidden_sections', true );
	if ( ! get_post_meta( $new_id, '_murailles_hidden_sections', true ) && is_array( $source_hidden_sections ) && ! empty( $source_hidden_sections ) ) {
		update_post_meta( $new_id, '_murailles_hidden_sections', array_values( array_map( 'sanitize_key', $source_hidden_sections ) ) );
	}

	foreach ( array_keys( murailles_page_editor_repeatable_meta_definitions() ) as $meta_key ) {
		if ( get_post_meta( $new_id, $meta_key, true ) ) {
			continue;
		}

		$source_items = get_post_meta( $source_id, $meta_key, true );
		if ( is_array( $source_items ) && ! empty( $source_items ) ) {
			update_post_meta( $new_id, $meta_key, $source_items );
		}
	}
}
add_action( 'wp_insert_post', 'murailles_page_editor_copy_translation_meta', 25, 3 );
