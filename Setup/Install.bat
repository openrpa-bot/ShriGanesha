cls
set MySqlCommand="C:\xampp\mysql\bin\mysql.exe"

set workingFolder=C:\xampp\htdocs\ShriGanesha

cd %workingFolder%

set webFolderName=SRN
set DBName=%webFolderName%
set dbRootUsername="root"
set dbRootPassword=""
set DrupalVersion=%2


F %webFolderName%.==. GOTO EOF
	%MySqlCommand% -u %dbRootUsername% -p  %dbRootPassword% -e "DROP DATABASE IF EXISTS %DBName%"
	%MySqlCommand% -u %dbRootUsername% -p  %dbRootPassword% -e "CREATE DATABASE %DBName%"
	
   if exist %webFolderName%\ (
  RMDIR "%webFolderName%\" /S /Q
)

ECHO  *******************************************************************************
ECHO  *                                                                             *
ECHO  *                Drupal Project Creation is in Progress .....                 *
ECHO  *                                                                             *                                                                                   
ECHO  *******************************************************************************
call composer create-project drupal/recommended-project:9.5.7 %webFolderName%
cd %webFolderName%
call composer update  drupal/core-* --with-all-dependencies
call composer update  drupal/core-* --with-dependencies



ECHO  *******************************************************************************
ECHO  *                                                                             *
ECHO  *			Drupal Theam and Admin Tools installation in Progress .....			*
ECHO  *                                                                             *                                                                                   
ECHO  *******************************************************************************
call composer require drupal/bootstrap_barrio:5.5.10 --with-dependencies
call composer require drupal/bootstrap5:3.0.5 --with-dependencies
ECHO  *******************************************************************************
call composer require drupal/layout_builder_restrictions:2.17  --with-all-dependencies
call composer require drupal/layout_builder_modal:1.2  --with-all-dependencies
call composer require drupal/bootstrap_layout_builder:2.1.1  --with-all-dependencies
ECHO  *******************************************************************************
rem call composer require drupal/we_megamenu:1.13 --with-dependencies
call composer require drupal/tb_megamenu:1.7 --with-dependencies
call composer require drupal/extlink:1.7 --with-dependencies
call composer require drupal/admin_toolbar:^3.3 --with-dependencies
call composer require drupal/menu_per_role:1.5 --with-all-dependencies
ECHO  *******************************************************************************
call composer require drupal/google_analytics:4.0.2 --with-all-dependencies
call composer require drupal/google_analytics_reports:3.0 --with-all-dependencies
call composer require drupal/google_tag:1.6  --with-all-dependencies
ECHO  *******************************************************************************
call composer require drupal/devel:5.1.1  --with-all-dependencies
call composer require drupal/dbug:2.0.0 --with-all-dependencies
ECHO  *******************************************************************************
call composer require drupal/s3fs:3.1 --with-all-dependencies
call composer require drupal/exclude_node_title:1.4  --with-all-dependencies
call composer require drupal/pdf_api:2.3.0 --with-all-dependencies



ECHO  *******************************************************************************
ECHO  *                                                                             *
ECHO  *			Drupal WebForm installation in Progress .....           			*
ECHO  *                                                                             *                                                                                   
ECHO  *******************************************************************************
call composer require drupal/webform:6.2.0-beta5 --with-all-dependencies



ECHO  *******************************************************************************
ECHO  *                                                                             *
ECHO  *			 Drupal User Experience installation in Progress .....  			*
ECHO  *                                                                             *                                                                                   
ECHO  *******************************************************************************
call composer require drupal/flexslider:2.0   --with-dependencies
call composer require drupal/views_slideshow:5.0.0  --with-dependencies
call composer require drupal/addtoany:2.0.1 --with-all-dependencies
call composer require drupal/better_exposed_filters:6.0.3 --with-all-dependencies
call composer require drupal/image_resize_filter:1.1 --with-all-dependencies
call composer require drupal/views_conditional:1.5 --with-all-dependencies
call composer require drupal/social_media_links:2.9 --with-all-dependencies
call composer require drupal/better_social_sharing_buttons:4.0.3 --with-all-dependencies
call composer require drupal/simple_popup_blocks:3.1 --with-all-dependencies
call composer require drupal/poll:1.6  --with-all-dependencies



ECHO  *******************************************************************************
ECHO  *                                                                             *
ECHO  *			 Drupal Field Modules installation in Progress .....    			*
ECHO  *                                                                             *                                                                                   
ECHO  *******************************************************************************
call composer require drupal/conditional_fields:4.0.0-alpha2  --with-dependencies
call composer require drupal/twig_field_value:2.0.0  --with-dependencies
call composer require drupal/youtube:2.0.0   --with-dependencies
call composer require drupal/editor_file:1.7  --with-dependencies
call composer require drupal/field_permissions:1.2 --with-dependencies
call composer require drupal/exclude_node_title:1.4 --with-dependencies
call composer require drupal/field_formatter_class:1.6 --with-dependencies
call composer require drupal/tablefield:2.4 --with-dependencies
call composer require drupal/country:1.1 --with-dependencies
call composer require drupal/extra_field:2.3 --with-dependencies
call composer require drupal/google_map_field:2.0.0  --with-dependencies
call composer require drupal/field_permissions:1.2  --with-dependencies
call composer require drupal/field_group:3.4 --with-dependencies
call composer require drupal/autocomplete_deluxe:2.0.3 --with-dependencies



ECHO  *******************************************************************************
ECHO  *                                                                             *
ECHO  *			 Drupal Map Modules installation in Progress .....       			*
ECHO  *                                                                             *                                                                                   
ECHO  *******************************************************************************
call composer require drupal/geofield:1.52   --with-dependencies
call composer require drupal/geolocation:3.12 --with-all-dependencies
call composer require drupal/geocoder:3.32 --with-all-dependencies
call composer require drupal/webform_ip_geo:1.0.4 --with-all-dependencies
call composer require drupal/geofield_map:3.0.8 --with-all-dependencies



ECHO  *******************************************************************************
ECHO  *                                                                             *
ECHO  *			 Drupal User Login Modules installation in Progress .....  			*
ECHO  *                                                                             *                                                                                   
ECHO  *******************************************************************************
call composer require drupal/user_email_verification:1.1 --with-all-dependencies
call composer require drupal/r4032login:2.2.1 --with-all-dependencies
call composer require drupal/social_auth:3.1.0 --with-all-dependencies
call composer require drupal/tfa:1.0 --with-all-dependencies
call composer require drupal/prlp:1.10 --with-all-dependencies
call composer require drupal/sendgrid_integration:2.1  --with-all-dependencies
call composer require drupal/externalauth:2.0.3  --with-all-dependencies
call composer require drupal/social_auth_google:3.0.0 --with-all-dependencies
rem call composer require drupal/login_destination:8.x-2.0-beta6 --with-all-dependencies
call composer require drupal/redirect_after_login:2.7 --with-all-dependencies
call composer require drupal/openid_connect:1.2 --with-all-dependencies



ECHO  *******************************************************************************
ECHO  *                                                                             *
ECHO  *			 Drupal SEO Modules installation in Progress .....  	    		*
ECHO  *                                                                             *                                                                                   
ECHO  *******************************************************************************
call composer require drupal/pathauto:1.11 --with-all-dependencies
call composer require drupal/linkchecker:1.1 --with-all-dependencies
call composer require drupal/flood_control:2.3.2 --with-all-dependencies
call composer require drupal/xmlsitemap:1.4 --with-all-dependencies
call composer require drupal/antibot:2.0.2 --with-all-dependencies
call composer require drupal/metatag:1.22 --with-all-dependencies
call composer require drupal/seo_checklist:5.1.0 --with-all-dependencies



ECHO  *******************************************************************************
ECHO  *                                                                             *
ECHO  *			 Drupal Security Modules installation in Progress .....  			*
ECHO  *                                                                             *                                                                                   
ECHO  *******************************************************************************
call composer require drupal/recaptcha:3.1  --with-all-dependencies
call composer require drupal/captcha:1.10 --with-all-dependencies
call composer require drupal/recaptcha_v3:1.8 --with-all-dependencies



ECHO  *******************************************************************************
ECHO  *                                                                             *
ECHO  *			 Drupal Commerce Modules installation in Progress .....  			*
ECHO  *                                                                             *                                                                                   
ECHO  *******************************************************************************
call composer require drupal/inline_entity_form:1.0-rc15 --with-all-dependencies
call composer require drupal/commerce:2.34 --with-all-dependencies
call composer require drupal/commerce_ticketing:2.0.0-alpha7 --with-all-dependencies
call composer require drupal/advancedqueue:1.0-RC7   --with-all-dependencies
call composer require drupal/commerce_license:2.0.0-beta2   --with-all-dependencies
call composer require drupal/commerce_webform_order:2.0.0-beta2   --with-all-dependencies
call composer require drupal/commerce_donate:1.1.0-alpha1  --with-all-dependencies
call composer require drupal/commerce_add_to_cart_link:2.0.5  --with-all-dependencies
call composer require drupal/commerce_shipping:2.6  --with-all-dependencies
call composer require drupal/commerce_stock:1.0  --with-all-dependencies



ECHO  *******************************************************************************
ECHO  *                                                                             *
ECHO  *			 Drupal BAT Modules installation in Progress .....      			*
ECHO  *                                                                             *                                                                                   
ECHO  *******************************************************************************
call composer require drupal/services:dev-4.x --with-dependencies
call composer require drupal/bat_api:1.1.0 --with-all-dependencies
call composer require drupal/bat:1.3.0 --with-all-dependencies



ECHO  *******************************************************************************
ECHO  *                                                                             *
ECHO  *			 Drupal Short Modules installation in Progress .....      			*
ECHO  *                                                                             *                                                                                   
ECHO  *******************************************************************************
call composer require drupal/search_api_autocomplete:1.7 --with-all-dependencies
rem composer require drupal/search_exclude:3.0.0-beta1 --with-all-dependencies
call composer require drupal/search_api:1.29  --with-all-dependencies
call composer require drupal/facets:^2.0 --with-all-dependencies
call composer require drupal/fullcalendar_library:1.1 --with-all-dependencies
call composer require drupal/clientside_validation:4.0.2 --with-all-dependencies



GOTO MyEOF

git config --global github.accesstoken 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

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


:MyEOF

cd C:\xampp\htdocs\ShriGanesha\Setup