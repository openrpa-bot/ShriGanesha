@ECHO OFF
cls
set MySqlCommand="C:\xampp\mysql\bin\mysql.exe"

set workingFolder=C:\xampp\htdocs\ShriGanesha

set webFolderName=SR

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
ECHO  *******************************************************************************
rem call drush -y enwe_megamenu:1.13 --with-dependencies
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
call drush -y en s3fs
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
call drush -y en user_email_verification
call drush -y en r4032login
call drush -y en social_auth
call drush -y en tfa
call drush -y en prlp
call drush -y en sendgrid_integration
call drush -y en externalauth
call drush -y en social_auth_google
rem call drush -y en login_destination:8.x-2.0-beta6 --with-all-dependencies
call drush -y en redirect_after_login
call drush -y en openid_connect



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
call drush -y en commerce_webform_order
call drush -y en commerce_donate
call drush -y en commerce_add_to_cart_link
call drush -y en commerce_shipping
call drush -y en commerce_stock



ECHO  *******************************************************************************
ECHO  *                                                                             *
ECHO  *			 Drupal BAT Modules installation in Progress .....      			*
ECHO  *                                                                             *                                                                                   
ECHO  *******************************************************************************
call drush -y en services
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



GOTO MyEOF

git config --global github.accesstoken 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

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


:MyEOF

cd C:\xampp\htdocs\ShriGanesha\Setup
@ECHO ON