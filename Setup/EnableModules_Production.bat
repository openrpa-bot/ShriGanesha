@ECHO OFF
cls
set MySqlCommand="C:\xampp\mysql\bin\mysql.exe"

set workingFolder=C:\xampp\htdocs\ShriGanesha

set webFolderName=Stage

cd %workingFolder%
cd %webFolderName%

ECHO  *******************************************************************************
ECHO  *                                                                             *
ECHO  *			Drupal Theam and Admin Tools installation in Progress .....			*
ECHO  *                                                                             *                                                                                   
ECHO  *******************************************************************************
call drush -y en layout_builder_restrictions
call drush -y en layout_builder_modal
call drush -y en bootstrap_layout_builder
call drush -y en dxpr_builder
ECHO  *******************************************************************************
call drush -y en tb_megamenu
call drush -y en extlink
call drush -y en admin_toolbar
call drush -y en menu_per_role
ECHO  *******************************************************************************
call drush -y en google_analytics
call drush -y en google_analytics_reports
call drush -y en google_tag
ECHO  *******************************************************************************
call drush -y en devel
call drush -y en dbug
ECHO  *******************************************************************************
rem call drush -y en s3fs
call drush -y en exclude_node_title
call drush -y en pdf_api



ECHO  *******************************************************************************
ECHO  *                                                                             *
ECHO  *			Drupal WebForm installation in Progress .....           			*
ECHO  *                                                                             *                                                                                   
ECHO  *******************************************************************************
call drush -y en webform



ECHO  *******************************************************************************
ECHO  *                                                                             *
ECHO  *			 Drupal User Experience installation in Progress .....  			*
ECHO  *                                                                             *                                                                                   
ECHO  *******************************************************************************
call drush -y en flexslider
call drush -y en views_slideshow
ECHO  *******************************************************************************
call drush -y en addtoany
ECHO  *******************************************************************************
call drush -y en better_exposed_filters
call drush -y en image_resize_filter
ECHO  *******************************************************************************
call drush -y en views_conditional
ECHO  *******************************************************************************
call drush -y en social_media_links
call drush -y en better_social_sharing_buttons
ECHO  *******************************************************************************
call drush -y en simple_popup_blocks
ECHO  *******************************************************************************
call drush -y en poll



ECHO  *******************************************************************************
ECHO  *                                                                             *
ECHO  *			 Drupal Field Modules installation in Progress .....    			*
ECHO  *                                                                             *                                                                                   
ECHO  *******************************************************************************
call drush -y en conditional_fields
ECHO  *******************************************************************************
call drush -y en twig_field_value
ECHO  *******************************************************************************
call drush -y en youtube
call drush -y en editor_file
call drush -y en field_permissions
call drush -y en exclude_node_title
call drush -y en field_formatter_class
call drush -y en tablefield
call drush -y en country
call drush -y en extra_field
call drush -y en google_map_field
call drush -y en field_permissions
call drush -y en field_group
call drush -y en autocomplete_deluxe
call drush -y en text_field_formatter
call drush -y en multiple_selects
call drush -y en uuid_extra
call drush -y en edit_uuid
call drush -y en barcodes
call drush -y en field_token_value
call drush -y en jquery_countdown_timer




ECHO  *******************************************************************************
ECHO  *                                                                             *
ECHO  *			 Drupal Map Modules installation in Progress .....       			*
ECHO  *                                                                             *                                                                                   
ECHO  *******************************************************************************
call drush -y en geofield
call drush -y en geofield_map
ECHO  *******************************************************************************
call drush -y en geolocation
call drush -y en geocoder
call drush -y en webform_ip_geo




ECHO  *******************************************************************************
ECHO  *                                                                             *
ECHO  *			 Drupal User Login Modules installation in Progress .....  			*
ECHO  *                                                                             *                                                                                   
ECHO  *******************************************************************************
rem call drush -y en user_email_verification
call drush -y en r4032login
call drush -y en social_auth
call drush -y en tfa
call drush -y en prlp
call drush -y en sendgrid_integration
rem call drush -y en externalauth
call drush -y en social_auth_google
rem call drush -y en login_destination:8.x-2.0-beta6 --with-all-dependencies
rem call drush -y en redirect_after_login
rem call drush -y en openid_connect



ECHO  *******************************************************************************
ECHO  *                                                                             *
ECHO  *			 Drupal SEO Modules installation in Progress .....  	    		*
ECHO  *                                                                             *                                                                                   
ECHO  *******************************************************************************
call drush -y en pathauto
call drush -y en linkchecker
call drush -y en flood_control
call drush -y en xmlsitemap
call drush -y en antibot
call drush -y en metatag
call drush -y en seo_checklist



ECHO  *******************************************************************************
ECHO  *                                                                             *
ECHO  *			 Drupal Security Modules installation in Progress .....  			*
ECHO  *                                                                             *                                                                                   
ECHO  *******************************************************************************
call drush -y en recaptcha
call drush -y en captcha
call drush -y en recaptcha_v3



ECHO  *******************************************************************************
ECHO  *                                                                             *
ECHO  *			 Drupal Commerce Modules installation in Progress .....  			*
ECHO  *                                                                             *                                                                                   
ECHO  *******************************************************************************
call drush -y en inline_entity_form
call drush -y en commerce
call drush -y en commerce_ticketing
call drush -y en advancedqueue
call drush -y en commerce_license
rem call drush -y en commerce_webform_order
call drush -y en commerce_donate
call drush -y en commerce_add_to_cart_link
call drush -y en commerce_shipping
call drush -y en commerce_stock
call drush -y en commerce_guest_registration
call drush -y en commerce_ccavenue
call drush -y en commerce_razorpay


ECHO  *******************************************************************************
ECHO  *                                                                             *
ECHO  *			 Drupal BAT Modules installation in Progress .....      			*
ECHO  *                                                                             *                                                                                   
ECHO  *******************************************************************************
rem call drush -y en services
call drush -y en bat_api
call drush -y en bat



ECHO  *******************************************************************************
ECHO  *                                                                             *
ECHO  *			 Drupal Short Modules installation in Progress .....      			*
ECHO  *                                                                             *                                                                                   
ECHO  *******************************************************************************
call drush -y en search_api_autocomplete
rem composer require drupal/search_exclude:3.0.0-beta1 --with-all-dependencies
call drush -y en search_api
call drush -y en facets
call drush -y en fullcalendar_library
call drush -y en clientside_validation



ECHO  *******************************************************************************
ECHO  *                                                                             *
ECHO  *			 Drush command is in Progress .....      		                 	*
ECHO  *                                                                             *                                                                                   
ECHO  *******************************************************************************
rem drush si --db-url=mysql://root:@localhost:3306/SRTest --site-name=Testing --site-mail=a@b.com --account-mail=b@c.com --account-name=a --account-pass=a --locale=en --existing-config -vvv
rem drush si --db-url=mysql://root:@localhost:3306/%webFolderName% --site-name=Testing --site-mail=a@b.com --account-mail=b@c.com --account-name=a --account-pass=a --locale=en --existing-config -vvv

call drush -y en action
rem call drush -y en tracker
rem call drush -y en ban
rem call drush -y en book
call drush -y en content_moderation
rem call drush -y en forum
call drush -y en inline_form_errors
rem call drush -y en pgsql
rem call drush -y en quickedit
rem call drush -y en rdf
call drush -y en responsive_image
call drush -y en settings_tray
rem call drush -y en sqlite
call drush -y en statistics
call drush -y en workflows
rem call drush -y en admin_toolbar_tools
call drush -y en admin_toolbar_links_access_filter
rem call drush -y en bat_booking_example
call drush -y en admin_toolbar_search
call drush -y en bat_calendar_reference
call drush -y en bat_event_series
call drush -y en bat_event_ui
call drush -y en bat_facets
call drush -y en bat_fullcalendar
call drush -y en bat_options
call drush -y en ctools_block
call drush -y en ctools_views
rem call drush -y en clientside_validation_demo
call drush -y en clientside_validation_jquery
call drush -y en commerce_log
call drush -y en commerce_payment
rem call drush -y en commerce_payment_example
call drush -y en commerce_promotion
call drush -y en commerce_tax
call drush -y en commerce_currency_resolver_shipping
call drush -y en commerce_stock_enforcement
call drush -y en commerce_stock_field
call drush -y en commerce_stock_local
call drush -y en commerce_stock_ui
call drush -y en field_layout
call drush -y en help_topics
rem call drush -y en workspaces
call drush -y en devel_generate
call drush -y en entity_print_views
rem call drush -y en checklistapiexample
call drush -y en tablefield_cellspan
call drush -y en tablefield_required
call drush -y en telephone
rem call drush -y en flexslider_example
call drush -y en flexslider_fields
call drush -y en flexslider_views
call drush -y en geocoder_address
call drush -y en geocoder_field
call drush -y en geocoder_geofield
call drush -y en geofield_map_extras
call drush -y en geolocation_address
call drush -y en geolocation_baidu
rem call drush -y en geolocation_demo
call drush -y en geolocation_geocodio
call drush -y en geolocation_geofield
call drush -y en geolocation_geometry
rem call drush -y en geolocation_geometry_demo
rem call drush -y en geolocation_geometry_data
rem call drush -y en geolocation_geometry_germany_zip_codes
rem call drush -y en geolocation_geometry_natural_earth_countries
rem call drush -y en geolocation_geometry_natural_earth_us_states
rem call drush -y en geolocation_geometry_open_canada_provinces
rem call drush -y en geolocation_geometry_world_heritage
rem call drush -y en geolocation_google_static_maps_demo
call drush -y en geolocation_google_maps
rem call drush -y en geolocation_google_maps_demo
call drush -y en geolocation_google_places_api
call drush -y en geolocation_google_static_maps
call drush -y en geolocation_gpx
call drush -y en geolocation_here
call drush -y en geolocation_leaflet
rem call drush -y en geolocation_leaflet_demo
call drush -y en geolocation_search_api
call drush -y en geolocation_yandex
call drush -y en layout_builder_restrictions_by_region
call drush -y en sendgrid_integration_reports
rem call drush -y en field_group_migrate
rem call drush -y en migrate
rem call drush -y en migrate_drupal
rem call drush -y en migrate_drupal_ui
rem call drush -y en config_translation
rem call drush -y en content_translation
rem call drush -y en locale
rem call drush -y en language
call drush -y en ctools_entity_mask
rem call drush -y en extra_field_example
call drush -y en puphpeteer
call drush -y en social_media_links_field
call drush -y en search_api_db
call drush -y en search_api_db_defaults
call drush -y en facets_map_widget
call drush -y en facets_range_widget
call drush -y en facets_summary
call drush -y en facets_rest
call drush -y en search_api_location
call drush -y en search_api_location_geocoder
call drush -y en search_api_location_views
call drush -y en metatag_routes
call drush -y en metatag_extended_perms
call drush -y en metatag_app_links
call drush -y en metatag_dc
call drush -y en metatag_dc_advanced
call drush -y en metatag_facebook
call drush -y en metatag_favicons
call drush -y en metatag_google_cse
call drush -y en metatag_google_plus
call drush -y en metatag_hreflang
call drush -y en metatag_mobile
call drush -y en metatag_open_graph
call drush -y en metatag_open_graph_products
call drush -y en metatag_page_manager
call drush -y en metatag_pinterest
call drush -y en metatag_twitter_cards
call drush -y en metatag_verification
call drush -y en metatag_views
rem call drush -y en services_tfa
call drush -y en image_captcha
call drush -y en views_slideshow_cycle
call drush -y en webform_access
call drush -y en webform_attachment
call drush -y en webform_bootstrap
call drush -y en webform_cards
call drush -y en webform_clientside_validation
call drush -y en webform_options_custom
call drush -y en webform_devel
call drush -y en webform_entity_print
call drush -y en webform_entity_print_attachment
call drush -y en webform_image_select
call drush -y en webform_ip_geo_ipapi_co
call drush -y en webform_node
call drush -y en webform_options_limit
call drush -y en webform_scheduled_email
call drush -y en webform_schema
call drush -y en webform_share
call drush -y en webform_shortcuts
call drush -y en webform_submission_export_import
call drush -y en webform_submission_log
call drush -y en webform_templates
call drush -y en webform_ui
rem call drush -y en webform_demo_application_evaluation
rem call drush -y en webform_demo_event_registration
rem call drush -y en webform_demo_region_contact
rem call drush -y en webform_example_custom_form
rem call drush -y en webform_example_element
rem call drush -y en webform_example_element_properties
rem call drush -y en webform_example_composite
rem call drush -y en webform_examples
rem call drush -y en webform_examples_accessibility
rem call drush -y en webform_example_handler
rem call drush -y en webform_example_remote_post
rem call drush -y en webform_example_variant
rem call drush -y en webform_location_places
rem call drush -y en webform_icheck
rem call drush -y en webform_jqueryui_buttons
rem call drush -y en webform_jqueryui_datepicker 
rem call drush -y en webform_location_geocomplete
rem call drush -y en webform_toggles
rem call drush -y en basic_auth
rem call drush -y en rest
rem call drush -y en serialization
rem call drush -y en jsonapi
call drush -y en xmlsitemap_custom
call drush -y en xmlsitemap_engines
call drush -y en page_manager_ui

call drush -y en boolean_single_state_formatter
call drush -y en direct_checkout_by_url
call drush -y en jquery_ui_tooltip
rem call drush -y en tooltip
call drush -y en ctools
call drush -y en entity_embed
call drush -y en asset_injector
call drush -y en bee_webform
call drush -y en bat_booking
call drush -y en text_field_formatter
call drush -y en field_group_table
call drush -y en commerce_choose_price
call drush -y en webform_content_creator
call drush -y en webform_product
call drush -y en field_description_tooltip
call drush -y en social_auth_facebook
call drush -y en webform_gmap_field
call drush -y en webform_counter
call drush -y en webform_hierarchy
call drush -y en webform_views
call drush -y en multiple_registration



GOTO MyEOF


git config --global github.accesstoken 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

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

drush ws
call drush -y un entity_embed

Using the rebuild script
Open settings.php (/sites/default/settings.php) in any plain text editor. Add this line to the end of the file and save it:

$settings['rebuild_access'] = TRUE;
Visit http://www.example.com/core/rebuild.php in your browser (where www.example.com is your site’s URL). After a short pause, you should be redirected to the home page of your site, and the cache should be rebuilt.
Open settings.php (/sites/default/settings.php) in a text editor. Find the line you added with $settings[rebuild_access], remove this line, and save the file.

:MyEOF

cd C:\xampp\htdocs\ShriGanesha\Setup
@ECHO ON