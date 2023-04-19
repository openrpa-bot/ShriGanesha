@ECHO OFF
cls
set MySqlCommand="C:\xampp\mysql\bin\mysql.exe"

set workingFolder=C:\xampp\htdocs\ShriGanesha

set webFolderName=BaseImage

set DBName=%webFolderName%
set dbRootUsername="root"
set dbRootPassword=""
set DrupalVersion=%2

cd %workingFolder% 

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
ECHO  ********************************************************************************************************************
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
ECHO  ********************************************************************************************************************
call composer require drupal/layout_builder_modal:1.2  --with-all-dependencies
ECHO  ********************************************************************************************************************
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
ECHO  ********************************************************************************************************************
call composer require drupal/menu_per_role:1.5 --with-all-dependencies
ECHO  ********************************************************************************************************************
call composer require drupal/tb_megamenu:1.7 --with-dependencies
ECHO  ********************************************************************************************************************
call composer require drupal/extlink:1.7 --with-dependencies
ECHO  ********************************************************************************************************************
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
ECHO  ********************************************************************************************************************
call composer require drupal/google_analytics_reports:3.0 --with-all-dependencies
ECHO  ********************************************************************************************************************
call composer require drupal/google_tag:1.6  --with-all-dependencies



ECHO  ********************************************************************************************************************
ECHO  * 6      Site Debug                                                                                                *
ECHO  ********************************************************************************************************************
ECHO  *                                                                                                                  *
ECHO  * 6.1    https://www.drupal.org/project/devel                                                                      *
ECHO  * 6.2    https://www.drupal.org/project/dbug                                                                       *
ECHO  * 6.3    https://www.drupal.org/project/drush                                                                      *
ECHO  * 6.4    https://www.drupal.org/project/webprofiler                                                                *
ECHO  * 6.5    https://www.drupal.org/project/twig_debugger                                                              *
ECHO  *                                                                                                                  *
ECHO  ********************************************************************************************************************
call composer require drupal/devel:5.1.1  --with-all-dependencies
ECHO  ********************************************************************************************************************
call composer require drupal/dbug:2.0.0 --with-all-dependencies
ECHO  ********************************************************************************************************************
call composer require drush/drush:11.5.1  --with-all-dependencies
ECHO  ********************************************************************************************************************
call composer require drupal/webprofiler:9.0.2  --with-all-dependencies
ECHO  ********************************************************************************************************************
call composer require drupal/twig_debugger:1.1.3  --with-all-dependencies



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
ECHO  ********************************************************************************************************************
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
ECHO  ********************************************************************************************************************
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
ECHO  * 12.2   https://www.drupal.org/project/webform_content_creator                                                    *
ECHO  *                                                                                                                  *
ECHO  ********************************************************************************************************************
call composer require drupal/webform:6.2.0-beta5 --with-all-dependencies
ECHO  ********************************************************************************************************************
call composer require drupal/webform_content_creator:4.0.0 --with-all-dependencies



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
ECHO  ********************************************************************************************************************
call composer require drupal/youtube:2.0.0   --with-dependencies
ECHO  ********************************************************************************************************************
call composer require drupal/country:1.1 --with-dependencies
ECHO  ********************************************************************************************************************
call composer require drupal/extra_field:2.3 --with-dependencies
ECHO  ********************************************************************************************************************
call composer require drupal/editor_file:1.7  --with-dependencies
ECHO  ********************************************************************************************************************
call composer require drupal/google_map_field:2.0.0  --with-dependencies
ECHO  ********************************************************************************************************************
call composer require drupal/geofield:1.52   --with-dependencies
ECHO  ********************************************************************************************************************
call composer require drupal/geofield_map:3.0.8 --with-all-dependencies
ECHO  ********************************************************************************************************************
call composer require drupal/text_field_formatter:2.0.1  --with-all-dependencies


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
ECHO  * 14.7   https://www.drupal.org/project/field_group_table                                                          *
ECHO  * 14.8   https://www.drupal.org/project/boolean_single_state_formatter                                             *
ECHO  *                                                                                                                  *
ECHO  ********************************************************************************************************************
call composer require drupal/conditional_fields:4.0.0-alpha2  --with-dependencies
ECHO  ********************************************************************************************************************
call composer require drupal/twig_field_value:2.0.2  --with-dependencies
ECHO  ********************************************************************************************************************
call composer require drupal/exclude_node_title:1.4 --with-dependencies
ECHO  ********************************************************************************************************************
call composer require drupal/field_permissions:1.2 --with-dependencies
ECHO  ********************************************************************************************************************
call composer require drupal/field_formatter_class:1.6 --with-dependencies
ECHO  ********************************************************************************************************************
call composer require drupal/field_group:3.4 --with-dependencies
ECHO  ********************************************************************************************************************
call composer require drupal/field_group_table:1.0 --with-dependencies
ECHO  ********************************************************************************************************************
call composer require drupal/boolean_single_state_formatter:1.1 --with-dependencies



ECHO  ********************************************************************************************************************
ECHO  * 15     View Formatters                                                                                           *
ECHO  ********************************************************************************************************************
ECHO  *                                                                                                                  *
ECHO  * 15.1   https://www.drupal.org/project/pdf_api                                                                    *
ECHO  * 15.2   https://www.drupal.org/project/addtoany                                                                   *
ECHO  * 15.3   https://www.drupal.org/project/better_exposed_filters                                                     *
ECHO  * 15.4   https://www.drupal.org/project/image_resize_filter                                                        *
ECHO  * 15.5   https://www.drupal.org/project/views_conditional                                                          *
ECHO  * 15.6   https://www.drupal.org/project/autocomplete_deluxe                                                        *
ECHO  * 15.7   https://www.drupal.org/project/asset_injector                                                             *
ECHO  * 15.8   https://www.drupal.org/project/jquery_ui_tooltip                                                          *
ECHO  * 15.9   https://www.drupal.org/project/ctools                                                                     *
ECHO  * 15.10  https://www.drupal.org/project/entity_embed                                                               *
ECHO  * 15.11  https://www.drupal.org/project/field_description_tooltip                                                  *
ECHO  * 15.12  https://www.drupal.org/project/tooltip_ckeditor                                                           *
ECHO  *                                                                                                                  *
ECHO  ********************************************************************************************************************
call composer require drupal/pdf_api:2.3.0 --with-all-dependencies
ECHO  ********************************************************************************************************************
call composer require drupal/addtoany:2.0.1 --with-all-dependencies
ECHO  ********************************************************************************************************************
call composer require drupal/better_exposed_filters:6.0.3 --with-all-dependencies
ECHO  ********************************************************************************************************************
call composer require drupal/image_resize_filter:1.1 --with-all-dependencies
ECHO  ********************************************************************************************************************
call composer require drupal/views_conditional:1.5 --with-all-dependencies
ECHO  ********************************************************************************************************************
call composer require drupal/autocomplete_deluxe:2.0.3 --with-dependencies
ECHO  ********************************************************************************************************************
call composer require drupal/asset_injector:2.16 --with-dependencies
ECHO  ********************************************************************************************************************
rem call composer require drupal/jquery_ui_tooltip:2.0.0 --with-dependencies
call composer require drupal/jquery_ui_tooltip:1.1.0 --with-dependencies
ECHO  ********************************************************************************************************************
call composer require drupal/ctools:4.0.3 --with-dependencies
ECHO  ********************************************************************************************************************
call composer require drupal/entity_embed:1.3 --with-dependencies
ECHO  ********************************************************************************************************************
call composer require drupal/field_description_tooltip:1.0.2 --with-dependencies
ECHO  ********************************************************************************************************************
call composer require drupal/tooltip_ckeditor:4.0.1 --with-dependencies



ECHO  ********************************************************************************************************************
ECHO  * 16     Geo/Map Module                                                                                            *
ECHO  ********************************************************************************************************************
ECHO  *                                                                                                                  *
ECHO  * 16.1   https://www.drupal.org/project/geolocation                                                                *
ECHO  * 16.2   https://www.drupal.org/project/geocoder                                                                   *
ECHO  * 16.3   https://www.drupal.org/project/webform_ip_geo                                                             *
ECHO  * 16.4   https://www.drupal.org/project/search_api_location                                                        *
ECHO  *                                                                                                                  *
ECHO  ********************************************************************************************************************
call composer require drupal/geolocation:3.12 --with-all-dependencies
ECHO  ********************************************************************************************************************
call composer require drupal/geocoder:3.32 --with-all-dependencies
ECHO  ********************************************************************************************************************
call composer require drupal/webform_ip_geo:1.0.4 --with-all-dependencies
ECHO  ********************************************************************************************************************
call composer require drupal/search_api_location:1.0-alpha3 --with-all-dependencies
ECHO  ********************************************************************************************************************
call composer require geocodio/geocodio-library-php --with-all-dependencies
ECHO  ********************************************************************************************************************
call composer require sibyx/phpgpx:@RC --with-all-dependencies



ECHO  ********************************************************************************************************************
ECHO  * 17       Social Login                                                                                            *
ECHO  ********************************************************************************************************************
ECHO  *                                                                                                                  *
ECHO  * 17.1   https://www.drupal.org/project/social_auth                                                                *
ECHO  * 17.2   https://www.drupal.org/project/social_auth_google                                                         *
ECHO  * 17.3   https://www.drupal.org/project/social_auth_facebook/                                                      *
ECHO  *                                                                                                                  *
ECHO  ********************************************************************************************************************
call composer require drupal/social_auth:3.1.0 --with-all-dependencies
ECHO  ********************************************************************************************************************
call composer require drupal/social_auth_google:3.0.0 --with-all-dependencies
ECHO  ********************************************************************************************************************
call composer require drupal/social_auth_facebook:3.0.1 --with-all-dependencies



ECHO  ********************************************************************************************************************
ECHO  * 17.1     User Login                                                                                              *
ECHO  ********************************************************************************************************************
ECHO  *                                                                                                                  *
ECHO  * 17.4   https://www.drupal.org/project/tfa                                                                        *
ECHO  * 17.5   https://www.drupal.org/project/prlp                                                                       *
ECHO  * 17.6   https://www.drupal.org/project/sendgrid_integration                                                       *
ECHO  * 17.7   https://www.drupal.org/project/r4032login                                                                 *
ECHO  * 17.8   https://www.drupal.org/project/redirect_after_login                                                       *
ECHO  * 17.9   https://www.drupal.org/project/login_destination                                                          *
ECHO  * 17.13  https://www.drupal.org/project/user_email_verification - disabled                                         *
ECHO  *                                                                                                                  *
ECHO  ********************************************************************************************************************
call composer require drupal/social_auth:3.1.0 --with-all-dependencies
ECHO  ********************************************************************************************************************
call composer require drupal/social_auth_google:3.0.0 --with-all-dependencies
ECHO  ********************************************************************************************************************
call composer require drupal/tfa:1.0 --with-all-dependencies
ECHO  ********************************************************************************************************************
call composer require drupal/prlp:1.10 --with-all-dependencies
ECHO  ********************************************************************************************************************
call composer require drupal/sendgrid_integration:2.1  --with-all-dependencies
ECHO  ********************************************************************************************************************
call composer require drupal/r4032login:2.2.1 --with-all-dependencies
ECHO  ********************************************************************************************************************
call composer require drupal/redirect_after_login:2.7 --with-all-dependencies
ECHO ********************************************************************************************************************
call composer require drupal/login_destination:2.0-beta6 --with-all-dependencies
ECHO ********************************************************************************************************************
rem call composer require drupal/user_email_verification:1.1 --with-all-dependencies
ECHO ********************************************************************************************************************



ECHO ********************************************************************************************************************
ECHO * 18     Spam Protection                                                                                           *
ECHO ********************************************************************************************************************
ECHO *                                                                                                                  *
ECHO * 18.1   https://www.drupal.org/project/recaptcha                                                                  *
ECHO * 18.2   https://www.drupal.org/project/captcha                                                                    *
ECHO * 18.3   https://www.drupal.org/project/recaptcha_v3                                                               *
ECHO * 18.4   https://www.drupal.org/project/antibot                                                                    *
ECHO * 18.5   https://www.drupal.org/project/flood_control                                                              *
ECHO *                                                                                                                  *
ECHO ********************************************************************************************************************
call composer require drupal/recaptcha:3.1  --with-all-dependencies
ECHO ********************************************************************************************************************
call composer require drupal/captcha:1.10 --with-all-dependencies
ECHO ********************************************************************************************************************
call composer require drupal/recaptcha_v3:1.8 --with-all-dependencies
ECHO ********************************************************************************************************************
call composer require drupal/antibot:2.0.2 --with-all-dependencies
ECHO ********************************************************************************************************************
call composer require drupal/flood_control:2.3.2 --with-all-dependencies



ECHO ********************************************************************************************************************
ECHO * 19     SEO                                                                                                       *
ECHO ********************************************************************************************************************
ECHO *                                                                                                                  *
ECHO * 19.1   https://www.drupal.org/project/pathauto                                                                   *
ECHO * 19.2   https://www.drupal.org/project/linkchecker                                                                *
ECHO * 19.3   https://www.drupal.org/project/xmlsitemap                                                                 *
ECHO * 19.4   https://www.drupal.org/project/metatag                                                                    *
ECHO * 19.5   https://www.drupal.org/project/seo_checklist                                                              *
ECHO *                                                                                                                  *
ECHO ********************************************************************************************************************
call composer require drupal/pathauto:1.11 --with-all-dependencies
ECHO ********************************************************************************************************************
call composer require drupal/linkchecker:1.1 --with-all-dependencies
ECHO ********************************************************************************************************************
call composer require drupal/xmlsitemap:1.4 --with-all-dependencies
ECHO ********************************************************************************************************************
call composer require drupal/metatag:1.22 --with-all-dependencies
ECHO ********************************************************************************************************************
call composer require drupal/seo_checklist:5.1.0 --with-all-dependencies



ECHO ********************************************************************************************************************
ECHO * 20     Commerce                                                                                                  *
ECHO ********************************************************************************************************************
ECHO *                                                                                                                  *
ECHO * 20.1   https://www.drupal.org/project/inline_entity_form                                                         *
ECHO * 20.2   https://www.drupal.org/project/commerce                                                                   *
ECHO * 20.3   https://www.drupal.org/project/commerce_ticketing                                                         *
ECHO * 20.4   https://www.drupal.org/project/advancedqueue                                                              *
ECHO * 20.5   https://www.drupal.org/project/commerce_license                                                           *
ECHO * 20.6   https://www.drupal.org/project/commerce_webform_order - disabled                                          *
ECHO * 20.7   https://www.drupal.org/project/commerce_donate                                                            *
ECHO * 20.8   https://www.drupal.org/project/commerce_add_to_cart_link                                                  *
ECHO * 20.9   https://www.drupal.org/project/commerce_shipping                                                          *
ECHO * 20.10  https://www.drupal.org/project/commerce_stock                                                             *
ECHO * 20.11  https://www.drupal.org/project/direct_checkout_by_url                                                     *
ECHO * 20.12  https://www.drupal.org/project/commerce_choose_price                                                      *
ECHO * 20.13  https://www.drupal.org/project/webform_product                                                     *
ECHO *                                                                                                                  *
ECHO ********************************************************************************************************************
call composer require drupal/inline_entity_form:1.0-rc15 --with-all-dependencies
ECHO ********************************************************************************************************************
call composer require drupal/commerce:2.35 --with-all-dependencies
ECHO ********************************************************************************************************************
call composer require drupal/commerce_ticketing:2.0.0-alpha7 --with-all-dependencies
ECHO ********************************************************************************************************************
call composer require drupal/advancedqueue:1.0-RC7   --with-all-dependencies
ECHO ********************************************************************************************************************
call composer require drupal/commerce_license:2.0.0-beta2   --with-all-dependencies
ECHO ********************************************************************************************************************
rem call composer require drupal/commerce_webform_order:2.0.0-beta2   --with-all-dependencies
ECHO ********************************************************************************************************************
call composer require drupal/commerce_donate:1.1.0-alpha1  --with-all-dependencies
ECHO ********************************************************************************************************************
call composer require drupal/commerce_add_to_cart_link:2.0.5  --with-all-dependencies
ECHO ********************************************************************************************************************
call composer require drupal/commerce_shipping:2.6  --with-all-dependencies
ECHO ********************************************************************************************************************
call composer require drupal/commerce_stock:1.0  --with-all-dependencies
ECHO ********************************************************************************************************************
call composer require drupal/direct_checkout_by_url:1.1  --with-all-dependencies
ECHO ********************************************************************************************************************
call composer require drupal/commerce_choose_price:1.3  --with-all-dependencies
ECHO ********************************************************************************************************************
call composer require drupal/webform_product:3.0.4  --with-all-dependencies



ECHO ********************************************************************************************************************
ECHO * 21     BAT - Booking and Ticketing                                                                               *
ECHO ********************************************************************************************************************
ECHO *                                                                                                                  *
ECHO * 21.1   https://www.drupal.org/project/services                                                                   *
ECHO * 21.2   https://www.drupal.org/project/bat_api                                                                    *
ECHO * 21.3   https://www.drupal.org/project/bat                                                                        *
ECHO *                                                                                                                  *
ECHO ********************************************************************************************************************
call composer require drupal/services:dev-4.x --with-dependencies
ECHO ********************************************************************************************************************
call composer require drupal/bat_api:1.1.0 --with-all-dependencies
ECHO ********************************************************************************************************************
call composer require drupal/bat:1.3.0 --with-all-dependencies
rem call composer require drupal/bat:2.1-alpha1 --with-all-dependencies
ECHO ********************************************************************************************************************
call composer require drupal/bee:1.2 --with-all-dependencies
ECHO ********************************************************************************************************************
call composer require drupal/commerce_cart drupal/commerce_checkout drupal/commerce_number_pattern drupal/commerce_order drupal/commerce_payment drupal/commerce_price drupal/commerce_product drupal/commerce_store drupal/bat drupal/bat_calendar_reference drupal/bat_event drupal/bat_event_ui drupal/bat_fullcalendar drupal/bat_options drupal/bat_unit



ECHO ********************************************************************************************************************
ECHO * 22     Misc                                                                                                      *
ECHO ********************************************************************************************************************
ECHO *                                                                                                                  *
ECHO * 22.1   https://www.drupal.org/project/search_api_autocomplete                                                    *
ECHO * 22.2   https://www.drupal.org/project/search_api                                                                 *
ECHO * 22.3   https://www.drupal.org/project/facets                                                                     *
ECHO * 22.4   https://www.drupal.org/project/fullcalendar_library                                                       *
ECHO * 22.5   https://www.drupal.org/project/clientside_validation                                                      *
ECHO * 22.6   https://www.drupal.org/project/page_manager                                                               *
ECHO * 22.7   https://www.drupal.org/project/jquery_ui_checkboxradio                                                    *
ECHO *                                                                                                                  *
ECHO ********************************************************************************************************************
call composer require drupal/search_api_autocomplete:1.7 --with-all-dependencies
ECHO ********************************************************************************************************************
call composer require drupal/search_api:1.29  --with-all-dependencies
ECHO ********************************************************************************************************************
call composer require drupal/facets:^2.0 --with-all-dependencies
ECHO ********************************************************************************************************************
call composer require drupal/fullcalendar_library:1.1 --with-all-dependencies
ECHO ********************************************************************************************************************
call composer require drupal/clientside_validation:4.0.2 --with-all-dependencies
ECHO ********************************************************************************************************************
call composer require drupal/page_manager:4.0-rc2 --with-all-dependencies
ECHO ********************************************************************************************************************
call composer require drupal/jquery_ui_checkboxradio:2.0.0 --with-all-dependencies
ECHO ********************************************************************************************************************
rem composer require drupal/search_exclude:3.0.0-beta1 --with-all-dependencies


GOTO MyEOF

/sites/default/settings.php

git config --global github.accesstoken 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

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

drush ws

Using the rebuild script
Open settings.php (/sites/default/settings.php) in any plain text editor. Add this line to the end of the file and save it:

$settings['rebuild_access'] = TRUE;
Visit http://www.example.com/core/rebuild.php in your browser (where www.example.com is your site’s URL). After a short pause, you should be redirected to the home page of your site, and the cache should be rebuilt.
Open settings.php (/sites/default/settings.php) in a text editor. Find the line you added with $settings[rebuild_access], remove this line, and save the file.

:MyEOF

cd C:\xampp\htdocs\ShriGanesha\Setup
@ECHO ON