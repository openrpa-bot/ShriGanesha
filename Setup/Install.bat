@ECHO OFF
cls
set MySqlCommand="C:\xampp\mysql\bin\mysql.exe"

set workingFolder=C:\xampp\htdocs\ShriGanesha

cd %workingFolder%

set webFolderName=SR
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

ECHO  *********************************************************************************************************************
ECHO  * 1      Drupal Project Creation                                                                                    *
ECHO  *********************************************************************************************************************
ECHO  *                                                                                                                   *
ECHO  * 1.1    https://www.drupal.org/docs/develop/using-composer/starting-a-site-using-drupal-composer-project-templates *
ECHO  *                                                                                                                   *
ECHO  *********************************************************************************************************************
call composer create-project drupal/recommended-project:9.5.7 %webFolderName%
cd %webFolderName%
call composer update  drupal/core-* --with-all-dependencies
call composer update  drupal/core-* --with-dependencies



ECHO  ********************************************************************************************************************
ECHO  * 2      Theam                                                                                                     *
ECHO  ********************************************************************************************************************
ECHO  *                                                                                                                  *
ECHO  * 2.1    https://www.drupal.org/project/bootstrap_barrio                                                           *
ECHO  * 2.2    https://www.drupal.org/project/bootstrap5                                                                 *
ECHO  *                                                                                                                  *
ECHO  ********************************************************************************************************************
call composer require drupal/bootstrap_barrio:5.5.10 --with-dependencies
call composer require drupal/bootstrap5:3.0.5 --with-dependencies



ECHO  ********************************************************************************************************************
ECHO  * 3      Layout Builder                                                                                            *
ECHO  ********************************************************************************************************************
ECHO  *                                                                                                                  *
ECHO  * 3.1    https://www.drupal.org/project/layout_builder_restrictions                                                *
ECHO  * 3.2    https://www.drupal.org/project/layout_builder_modal                                                       *
ECHO  * 3.3    https://www.drupal.org/project/bootstrap_layout_builder                                                   *
ECHO  *                                                                                                                  *
ECHO  ********************************************************************************************************************
call composer require drupal/layout_builder_restrictions:2.17  --with-all-dependencies
call composer require drupal/layout_builder_modal:1.2  --with-all-dependencies
call composer require drupal/bootstrap_layout_builder:2.1.1  --with-all-dependencies



ECHO  ********************************************************************************************************************
ECHO  * 4      Menu                                                                                                      *
ECHO  ********************************************************************************************************************
ECHO  *                                                                                                                  *
ECHO  * 4.1    https://www.drupal.org/project/admin_toolbar                                                              *
ECHO  * 4.2    https://www.drupal.org/project/menu_per_role                                                              *
ECHO  * 4.3    https://www.drupal.org/project/tb_megamenu                                                                *
ECHO  * 4.4    https://www.drupal.org/project/extlink                                                                    *
ECHO  * 4.4    https://www.drupal.org/project/we_megamenu - Disabled                                                     *
ECHO  *                                                                                                                  *
ECHO  ********************************************************************************************************************
call composer require drupal/admin_toolbar:^3.3 --with-dependencies
call composer require drupal/menu_per_role:1.5 --with-all-dependencies
call composer require drupal/tb_megamenu:1.7 --with-dependencies
call composer require drupal/extlink:1.7 --with-dependencies
rem call composer require drupal/we_megamenu:1.13 --with-dependencies



ECHO  ********************************************************************************************************************
ECHO  * 5      Google Analytics                                                                                          *
ECHO  ********************************************************************************************************************
ECHO  *                                                                                                                  *
ECHO  * 5.1    https://www.drupal.org/project/google_analytics                                                           *
ECHO  * 5.2    https://www.drupal.org/project/google_analytics_reports                                                   *
ECHO  * 5.3    https://www.drupal.org/project/google_tag                                                                 *
ECHO  *                                                                                                                  *
ECHO  ********************************************************************************************************************
call composer require drupal/google_analytics:4.0.2 --with-all-dependencies
call composer require drupal/google_analytics_reports:3.0 --with-all-dependencies
call composer require drupal/google_tag:1.6  --with-all-dependencies



ECHO  ********************************************************************************************************************
ECHO  * 6      Site Debug                                                                                                *
ECHO  ********************************************************************************************************************
ECHO  *                                                                                                                  *
ECHO  * 6.1    https://www.drupal.org/project/devel                                                                      *
ECHO  * 6.2    https://www.drupal.org/project/dbug                                                                       *
ECHO  * 6.3    https://www.drupal.org/project/drush                                                                      *
ECHO  *                                                                                                                  *
ECHO  ********************************************************************************************************************
call composer require drupal/devel:5.1.1  --with-all-dependencies
call composer require drupal/dbug:2.0.0 --with-all-dependencies
call composer require drush/drush:11.5.1  --with-all-dependencies


ECHO  ********************************************************************************************************************
ECHO  * 7      Amazon S3 Ref                                                                                             *
ECHO  ********************************************************************************************************************
ECHO  *                                                                                                                  *
ECHO  * 7.1    https://www.drupal.org/project/s3fs                                                                       *
ECHO  *                                                                                                                  *
ECHO  ********************************************************************************************************************
call composer require drupal/s3fs:3.1 --with-all-dependencies



ECHO  ********************************************************************************************************************
ECHO  * 8      Slider                                                                                                    *
ECHO  ********************************************************************************************************************
ECHO  *                                                                                                                  *
ECHO  * 8.1    https://www.drupal.org/project/flexslider                                                                 *
ECHO  * 8.2    https://www.drupal.org/project/views_slideshow                                                            *
ECHO  *                                                                                                                  *
ECHO  ********************************************************************************************************************
call composer require drupal/flexslider:2.0   --with-dependencies
call composer require drupal/views_slideshow:5.0.0  --with-dependencies


ECHO  ********************************************************************************************************************
ECHO  * 9      Social                                                                                                    *
ECHO  ********************************************************************************************************************
ECHO  *                                                                                                                  *
ECHO  * 9.1    https://www.drupal.org/project/social_media_links                                                         *
ECHO  * 9.2    https://www.drupal.org/project/better_social_sharing_buttons                                              *
ECHO  *                                                                                                                  *
ECHO  ********************************************************************************************************************
call composer require drupal/social_media_links:2.9 --with-all-dependencies
call composer require drupal/better_social_sharing_buttons:4.0.3 --with-all-dependencies



ECHO  ********************************************************************************************************************
ECHO  * 10     Modal Dialogue                                                                                            *
ECHO  ********************************************************************************************************************
ECHO  *                                                                                                                  *
ECHO  * 10.1   https://www.drupal.org/project/simple_popup_blocks                                                        *
ECHO  *                                                                                                                  *
ECHO  ********************************************************************************************************************
call composer require drupal/simple_popup_blocks:3.1 --with-all-dependencies



ECHO  ********************************************************************************************************************
ECHO  * 11     Poll                                                                                                      *
ECHO  ********************************************************************************************************************
ECHO  *                                                                                                                  *
ECHO  * 11.1   https://www.drupal.org/project/poll                                                                       *
ECHO  *                                                                                                                  *
ECHO  ********************************************************************************************************************
call composer require drupal/poll:1.6  --with-all-dependencies


ECHO  ********************************************************************************************************************
ECHO  * 12     Webform                                                                                                   *
ECHO  ********************************************************************************************************************
ECHO  *                                                                                                                  *
ECHO  * 12.1   https://www.drupal.org/project/webform                                                                    *
ECHO  *                                                                                                                  *
ECHO  ********************************************************************************************************************
call composer require drupal/webform:6.2.0-beta5 --with-all-dependencies



ECHO  ********************************************************************************************************************
ECHO  * 13     Fields                                                                                                    *
ECHO  ********************************************************************************************************************
ECHO  *                                                                                                                  *
ECHO  * 13.1   https://www.drupal.org/project/tablefield                                                                 *
ECHO  * 13.2   https://www.drupal.org/project/youtube                                                                    *
ECHO  * 13.3   https://www.drupal.org/project/country                                                                    *
ECHO  * 13.4   https://www.drupal.org/project/extra_field                                                                *
ECHO  * 13.5   https://www.drupal.org/project/editor_file                                                                *
ECHO  * 13.6   https://www.drupal.org/project/google_map_field                                                           *
ECHO  * 13.7   https://www.drupal.org/project/geofield                                                                   *
ECHO  * 13.8   https://www.drupal.org/project/geofield_map                                                               *
ECHO  *                                                                                                                  *
ECHO  ********************************************************************************************************************
call composer require drupal/tablefield:2.4 --with-dependencies
call composer require drupal/youtube:2.0.0   --with-dependencies
call composer require drupal/country:1.1 --with-dependencies
call composer require drupal/extra_field:2.3 --with-dependencies
call composer require drupal/editor_file:1.7  --with-dependencies
call composer require drupal/google_map_field:2.0.0  --with-dependencies
call composer require drupal/geofield:1.52   --with-dependencies
call composer require drupal/geofield_map:3.0.8 --with-all-dependencies



ECHO  ********************************************************************************************************************
ECHO  * 14     Field Formatters                                                                                          *
ECHO  ********************************************************************************************************************
ECHO  *                                                                                                                  *
ECHO  * 14.1   https://www.drupal.org/project/conditional_fields                                                         *
ECHO  * 14.2   https://www.drupal.org/project/twig_field_value                                                           *
ECHO  * 14.3   https://www.drupal.org/project/exclude_node_title                                                         *
ECHO  * 14.4   https://www.drupal.org/project/field_permissions                                                          *
ECHO  * 14.5   https://www.drupal.org/project/field_formatter_class                                                      *
ECHO  * 14.6   https://www.drupal.org/project/field_group                                                                *
ECHO  *                                                                                                                  *
ECHO  ********************************************************************************************************************
call composer require drupal/conditional_fields:4.0.0-alpha2  --with-dependencies
call composer require drupal/twig_field_value:2.0.0  --with-dependencies
call composer require drupal/exclude_node_title:1.4 --with-dependencies
call composer require drupal/field_permissions:1.2 --with-dependencies
call composer require drupal/field_formatter_class:1.6 --with-dependencies
call composer require drupal/field_group:3.4 --with-dependencies



ECHO  ********************************************************************************************************************
ECHO  * 15     Geo/Map Module                                                                                            *
ECHO  ********************************************************************************************************************
ECHO  *                                                                                                                  *
ECHO  * 15.1   https://www.drupal.org/project/geolocation                                                                *
ECHO  * 15.2   https://www.drupal.org/project/geocoder                                                                   *
ECHO  * 15.3   https://www.drupal.org/project/webform_ip_geo                                                             *
ECHO  * 15.4   https://www.drupal.org/project/search_api_location                                                        *
ECHO  *                                                                                                                  *
ECHO  ********************************************************************************************************************
call composer require drupal/geolocation:3.12 --with-all-dependencies
call composer require drupal/geocoder:3.32 --with-all-dependencies
call composer require drupal/webform_ip_geo:1.0.4 --with-all-dependencies
call composer require drupal/search_api_location:1.0-alpha3 --with-all-dependencies




ECHO  ********************************************************************************************************************
ECHO  * 16     User Login                                                                                                *
ECHO  ********************************************************************************************************************
ECHO  *                                                                                                                  *
ECHO  * 16.1   https://www.drupal.org/project/social_auth                                                         *
ECHO  * 16.2   https://www.drupal.org/project/tfa                                                           *
ECHO  * 16.3   https://www.drupal.org/project/exclude_node_title                                                         *
ECHO  * 16.4   https://www.drupal.org/project/field_permissions                                                          *
ECHO  * 16.5   https://www.drupal.org/project/field_formatter_class                                                      *
ECHO  * 16.6   https://www.drupal.org/project/field_group                                                                *
ECHO  * 16.7   https://www.drupal.org/project/                                                          *
ECHO  * 16.8   https://www.drupal.org/project/                                                          *
ECHO  *                                                                                                                  *
ECHO  ********************************************************************************************************************
call composer require drupal/social_auth:3.1.0 --with-all-dependencies
call composer require drupal/tfa:1.0 --with-all-dependencies
call composer require drupal/prlp:1.10 --with-all-dependencies
call composer require drupal/sendgrid_integration:2.1  --with-all-dependencies
call composer require drupal/externalauth:2.0.3  --with-all-dependencies
call composer require drupal/social_auth_google:3.0.0 --with-all-dependencies
call composer require drupal/r4032login:2.2.1 --with-all-dependencies
call composer require drupal/redirect_after_login:2.7 --with-all-dependencies
call composer require drupal/openid_connect:1.2 --with-all-dependencies
rem call composer require drupal/login_destination:8.x-2.0-beta6 --with-all-dependencies
rem call composer require drupal/user_email_verification:1.1 --with-all-dependencies



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





call composer require drupal/pdf_api:2.3.0 --with-all-dependencies
call composer require drupal/addtoany:2.0.1 --with-all-dependencies
call composer require drupal/better_exposed_filters:6.0.3 --with-all-dependencies
call composer require drupal/image_resize_filter:1.1 --with-all-dependencies
call composer require drupal/views_conditional:1.5 --with-all-dependencies
call composer require drupal/autocomplete_deluxe:2.0.3 --with-dependencies




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
call composer require drupal/page_manager:4.0-rc2 --with-all-dependencies
call composer require drupal/jquery_ui_checkboxradio:2.0.0 --with-all-dependencies



GOTO MyEOF

git config --global github.accesstoken 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

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


:MyEOF

cd C:\xampp\htdocs\ShriGanesha\Setup
@ECHO ON