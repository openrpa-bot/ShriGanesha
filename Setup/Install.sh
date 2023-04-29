cd  /var/www/html
sudo chmod -R 755 web
cd /var/www/html/web/sites
sudo chmod -R a+w default
cd default
sudo cp default.settings.php settings.php
sudo chmod 777 settings.php

sudo chmod 755 settings.php

cd /etc/httpd/conf
sudo vi httpd.conf
sudo systemctl restart httpd

$sites['13.233.145.195'] = 'osellings';
$sites['ec2-13-233-145-195.ap-south-1.compute.amazonaws.com'] = 'ramadevotee';
$sites['13.233.145.195'] = 'ramjanmbhoomi';




  # Further relax access to the default document root:
<Directory "/var/www/html">
    #
    # Possible values for the Options directive are "None", "All",
    # or any combination of:
    #   Indexes Includes FollowSymLinks SymLinksifOwnerMatch ExecCGI MultiViews
    #
    # Note that "MultiViews" must be named *explicitly* --- "Options All"
    # doesn't give it to you.
    #
    # The Options directive is both complicated and important.  Please see
    # http://httpd.apache.org/docs/2.4/mod/core.html#options
    # for more information.
    #
    Options Indexes FollowSymLinks

    #
    # AllowOverride controls what directives may be placed in .htaccess files.
    # It can be "All", "None", or any combination of the keywords:
    #   Options FileInfo AuthConfig Limit
    #
    AllowOverride All

    #
    # Controls who can get stuff from this server.
    #
    Require all granted
</Directory>

</Directory>
# handles root (/var/www/html/web/sites) and sub dirs (/var/html/www/sub/sites)
  <Directory ~ "^/var/www/html/web/(.+/)*sites/.+/(files|tmp)/">
    SetHandler Drupal_Security_Do_Not_Remove_See_SA_2006_006
    Options None
    Options +FollowSymLinks
  </Directory>



echo  *********************************************************************************************************************
echo  * 1      Drupal Project Creation                                                                                    *
echo  *********************************************************************************************************************
echo  *                                                                                                                   *
echo  * 1.1    https://www.drupal.org/docs/develop/using-composer/starting-a-site-using-drupal-composer-project-templates *
echo  *                                                                                                                   *
echo  *********************************************************************************************************************
rem sudo php ~/composer.phar create-project drupal/recommended-project:9.5.7 %webFolderName%
rem cd %webFolderName%
rem sudo php ~/composer.phar update  drupal/core-* --with-all-dependencies
rem sudo php ~/composer.phar update  drupal/core-* --with-dependencies



echo  ********************************************************************************************************************
echo  * 2      Theam                                                                                                     *
echo  ********************************************************************************************************************
echo  *                                                                                                                  *
echo  * 2.1    https://www.drupal.org/project/bootstrap_barrio                                                           *
echo  * 2.2    https://www.drupal.org/project/bootstrap5                                                                 *
echo  * 2.3    https://www.drupal.org/project/dxpr_theme                                                                 *
echo  * 2.4    https://www.drupal.org/project/dxpr_builder                                                               *
echo  *                                                                                                                  *
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/bootstrap_barrio:5.5.10 --with-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/bootstrap5:3.0.5 --with-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/dxpr_theme:5.1.0 --with-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/dxpr_builder:2.2.3 --with-dependencies



echo  ********************************************************************************************************************
echo  * 3      Layout Builder                                                                                            *
echo  ********************************************************************************************************************
echo  *                                                                                                                  *
echo  * 3.1    https://www.drupal.org/project/layout_builder_restrictions                                                *
echo  * 3.2    https://www.drupal.org/project/layout_builder_modal                                                       *
echo  * 3.3    https://www.drupal.org/project/bootstrap_layout_builder                                                   *
echo  *                                                                                                                  *
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/layout_builder_restrictions:2.17  --with-all-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/layout_builder_modal:1.2  --with-all-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/bootstrap_layout_builder:2.1.1  --with-all-dependencies



echo  ********************************************************************************************************************
echo  * 4      Menu                                                                                                      *
echo  ********************************************************************************************************************
echo  *                                                                                                                  *
echo  * 4.1    https://www.drupal.org/project/admin_toolbar                                                              *
echo  * 4.2    https://www.drupal.org/project/menu_per_role                                                              *
echo  * 4.3    https://www.drupal.org/project/tb_megamenu                                                                *
echo  * 4.4    https://www.drupal.org/project/extlink                                                                    *
echo  * 4.4    https://www.drupal.org/project/we_megamenu - Disabled                                                     *
echo  *                                                                                                                  *
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/admin_toolbar:^3.3 --with-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/menu_per_role:1.5 --with-all-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/tb_megamenu:1.7 --with-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/extlink:1.7 --with-dependencies
echo  ********************************************************************************************************************
rem sudo php ~/composer.phar require drupal/we_megamenu:1.13 --with-dependencies



echo  ********************************************************************************************************************
echo  * 5      Google Analytics                                                                                          *
echo  ********************************************************************************************************************
echo  *                                                                                                                  *
echo  * 5.1    https://www.drupal.org/project/google_analytics                                                           *
echo  * 5.2    https://www.drupal.org/project/google_analytics_reports                                                   *
echo  * 5.3    https://www.drupal.org/project/google_tag                                                                 *
echo  *                                                                                                                  *
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/google_analytics:4.0.2 --with-all-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/google_analytics_reports:3.0 --with-all-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/google_tag:1.6  --with-all-dependencies



echo  ********************************************************************************************************************
echo  * 6      Site Debug                                                                                                *
echo  ********************************************************************************************************************
echo  *                                                                                                                  *
echo  * 6.1    https://www.drupal.org/project/devel                                                                      *
echo  * 6.2    https://www.drupal.org/project/dbug                                                                       *
echo  * 6.3    https://www.drupal.org/project/drush                                                                      *
echo  * 6.4    https://www.drupal.org/project/webprofiler                                                                *
echo  * 6.5    https://www.drupal.org/project/twig_debugger                                                              *
echo  *                                                                                                                  *
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/devel:5.1.1  --with-all-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/dbug:2.0.0 --with-all-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drush/drush:11.5.1  --with-all-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/webprofiler:9.0.2  --with-all-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/twig_debugger:1.1.3  --with-all-dependencies



echo  ********************************************************************************************************************
echo  * 7      Amazon S3 Ref                                                                                             *
echo  ********************************************************************************************************************
echo  *                                                                                                                  *
echo  * 7.1    https://www.drupal.org/project/s3fs                                                                       *
echo  *                                                                                                                  *
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/s3fs:3.1 --with-all-dependencies



echo  ********************************************************************************************************************
echo  * 8      Slider                                                                                                    *
echo  ********************************************************************************************************************
echo  *                                                                                                                  *
echo  * 8.1    https://www.drupal.org/project/flexslider                                                                 *
echo  * 8.2    https://www.drupal.org/project/views_slideshow                                                            *
echo  *                                                                                                                  *
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/flexslider:2.0   --with-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/views_slideshow:5.0.0  --with-dependencies


echo  ********************************************************************************************************************
echo  * 9      Social                                                                                                    *
echo  ********************************************************************************************************************
echo  *                                                                                                                  *
echo  * 9.1    https://www.drupal.org/project/social_media_links                                                         *
echo  * 9.2    https://www.drupal.org/project/better_social_sharing_buttons                                              *
echo  *                                                                                                                  *
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/social_media_links:2.9 --with-all-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/better_social_sharing_buttons:4.0.3 --with-all-dependencies



echo  ********************************************************************************************************************
echo  * 10     Modal Dialogue                                                                                            *
echo  ********************************************************************************************************************
echo  *                                                                                                                  *
echo  * 10.1   https://www.drupal.org/project/simple_popup_blocks                                                        *
echo  *                                                                                                                  *
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/simple_popup_blocks:3.1 --with-all-dependencies



echo  ********************************************************************************************************************
echo  * 11     Poll                                                                                                      *
echo  ********************************************************************************************************************
echo  *                                                                                                                  *
echo  * 11.1   https://www.drupal.org/project/poll                                                                       *
echo  *                                                                                                                  *
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/poll:1.6  --with-all-dependencies



echo  ********************************************************************************************************************
echo  * 12     Webform                                                                                                   *
echo  ********************************************************************************************************************
echo  *                                                                                                                  *
echo  * 12.1   https://www.drupal.org/project/webform                                                                    *
echo  * 12.2   https://www.drupal.org/project/webform_content_creator                                                    *
echo  * 12.3   https://www.drupal.org/project/webform_gmap_field                                                         *
echo  * 12.4   https://www.drupal.org/project/webform_counter                                                            *
echo  * 12.5   https://www.drupal.org/project/webform_hierarchy                                                          *
echo  * 12.6   https://www.drupal.org/project/webform_views                                                              *
echo  *                                                                                                                  *
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/webform:6.2.0-beta5 --with-all-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/webform_content_creator:4.0.0 --with-all-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/webform_gmap_field:1.1 --with-all-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/webform_counter:1.0 --with-all-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/webform_hierarchy:1.1 --with-all-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/webform_views:5.1 --with-all-dependencies



echo  ********************************************************************************************************************
echo  * 13     Fields                                                                                                    *
echo  ********************************************************************************************************************
echo  *                                                                                                                  *
echo  * 13.1   https://www.drupal.org/project/tablefield                                                                 *
echo  * 13.2   https://www.drupal.org/project/youtube                                                                    *
echo  * 13.3   https://www.drupal.org/project/country                                                                    *
echo  * 13.4   https://www.drupal.org/project/extra_field                                                                *
echo  * 13.5   https://www.drupal.org/project/editor_file                                                                *
echo  * 13.6   https://www.drupal.org/project/google_map_field                                                           *
echo  * 13.7   https://www.drupal.org/project/geofield                                                                   *
echo  * 13.8   https://www.drupal.org/project/geofield_map                                                               *
echo  * 13.9   https://www.drupal.org/project/multiple_selects                                                           *
echo  * 13.10  https://www.drupal.org/project/uuid_extra                                                                 *
echo  * 13.11  https://www.drupal.org/project/edit_uuid                                                                  *
echo  *                                                                                                                  *
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/tablefield:2.4 --with-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/youtube:2.0.0   --with-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/country:1.1 --with-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/extra_field:2.3 --with-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/editor_file:1.7  --with-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/google_map_field:2.0.0  --with-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/geofield:1.52   --with-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/geofield_map:3.0.8 --with-all-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/text_field_formatter:2.0.1  --with-all-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/multiple_selects:1.1  --with-all-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/uuid_extra:2.0.1  --with-all-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/edit_uuid:2.1 --with-all-dependencies


echo  ********************************************************************************************************************
echo  * 14     Field Formatters                                                                                          *
echo  ********************************************************************************************************************
echo  *                                                                                                                  *
echo  * 14.1   https://www.drupal.org/project/conditional_fields                                                         *
echo  * 14.2   https://www.drupal.org/project/twig_field_value                                                           *
echo  * 14.3   https://www.drupal.org/project/exclude_node_title                                                         *
echo  * 14.4   https://www.drupal.org/project/field_permissions                                                          *
echo  * 14.5   https://www.drupal.org/project/field_formatter_class                                                      *
echo  * 14.6   https://www.drupal.org/project/field_group                                                                *
echo  * 14.7   https://www.drupal.org/project/field_group_table                                                          *
echo  * 14.8   https://www.drupal.org/project/boolean_single_state_formatter                                             *
echo  * 14.9   https://www.drupal.org/project/endroid_qr_code    -disabled                                               *
echo  * 14.10  https://www.drupal.org/project/barcodes                                                                   *
echo  * 14.11  https://www.drupal.org/project/field_token_value                                                          *
echo  *                                                                                                                  *
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/conditional_fields:4.0.0-alpha2  --with-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/twig_field_value:2.0.2  --with-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/exclude_node_title:1.4 --with-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/field_permissions:1.2 --with-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/field_formatter_class:1.6 --with-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/field_group:3.4 --with-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/field_group_table:1.0 --with-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/boolean_single_state_formatter:1.1 --with-dependencies
echo  ********************************************************************************************************************
rem sudo php ~/composer.phar require drupal/endroid_qr_code:3.0.0 --with-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/field_token_value:3.0.1 --with-dependencies





echo  ********************************************************************************************************************
echo  * 15     View Formatters                                                                                           *
echo  ********************************************************************************************************************
echo  *                                                                                                                  *
echo  * 15.1   https://www.drupal.org/project/pdf_api                                                                    *
echo  * 15.2   https://www.drupal.org/project/addtoany                                                                   *
echo  * 15.3   https://www.drupal.org/project/better_exposed_filters                                                     *
echo  * 15.4   https://www.drupal.org/project/image_resize_filter                                                        *
echo  * 15.5   https://www.drupal.org/project/views_conditional                                                          *
echo  * 15.6   https://www.drupal.org/project/autocomplete_deluxe                                                        *
echo  * 15.7   https://www.drupal.org/project/asset_injector                                                             *
echo  * 15.8   https://www.drupal.org/project/jquery_ui_tooltip                                                          *
echo  * 15.9   https://www.drupal.org/project/ctools                                                                     *
echo  * 15.10  https://www.drupal.org/project/entity_embed                                                               *
echo  * 15.11  https://www.drupal.org/project/field_description_tooltip                                                  *
echo  * 15.12  https://www.drupal.org/project/tooltip_ckeditor                                                           *
echo  * 15.13  https://www.drupal.org/project/jquery_countdown_timer                                                     *
echo  *                                                                                                                  *
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/pdf_api:2.3.0 --with-all-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/addtoany:2.0.1 --with-all-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/better_exposed_filters:6.0.3 --with-all-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/image_resize_filter:1.1 --with-all-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/views_conditional:1.5 --with-all-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/autocomplete_deluxe:2.0.3 --with-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/asset_injector:2.16 --with-dependencies
echo  ********************************************************************************************************************
rem sudo php ~/composer.phar require drupal/jquery_ui_tooltip:2.0.0 --with-dependencies
sudo php ~/composer.phar require drupal/jquery_ui_tooltip:1.1.0 --with-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/ctools:4.0.3 --with-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/entity_embed:1.3 --with-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/field_description_tooltip:1.0.2 --with-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/tooltip_ckeditor:4.0.1 --with-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/jquery_countdown_timer:1.3 --with-dependencies



echo  ********************************************************************************************************************
echo  * 16     Geo/Map Module                                                                                            *
echo  ********************************************************************************************************************
echo  *                                                                                                                  *
echo  * 16.1   https://www.drupal.org/project/geolocation                                                                *
echo  * 16.2   https://www.drupal.org/project/geocoder                                                                   *
echo  * 16.3   https://www.drupal.org/project/webform_ip_geo                                                             *
echo  * 16.4   https://www.drupal.org/project/search_api_location                                                        *
echo  *                                                                                                                  *
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/geolocation:3.12 --with-all-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/geocoder:3.32 --with-all-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/webform_ip_geo:1.0.4 --with-all-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/search_api_location:1.0-alpha3 --with-all-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require geocodio/geocodio-library-php --with-all-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require sibyx/phpgpx:@RC --with-all-dependencies



echo  ********************************************************************************************************************
echo  * 17       Social Login                                                                                            *
echo  ********************************************************************************************************************
echo  *                                                                                                                  *
echo  * 17.1   https://www.drupal.org/project/social_auth                                                                *
echo  * 17.2   https://www.drupal.org/project/social_auth_google                                                         *
echo  * 17.3   https://www.drupal.org/project/social_auth_facebook/                                                      *
echo  *                                                                                                                  *
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/social_auth:3.1.0 --with-all-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/social_auth_google:3.0.0 --with-all-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/social_auth_facebook:3.0.1 --with-all-dependencies



echo  ********************************************************************************************************************
echo  * 17.1     User Login                                                                                              *
echo  ********************************************************************************************************************
echo  *                                                                                                                  *
echo  * 17.4   https://www.drupal.org/project/tfa                                                                        *
echo  * 17.5   https://www.drupal.org/project/prlp                                                                       *
echo  * 17.6   https://www.drupal.org/project/sendgrid_integration                                                       *
echo  * 17.7   https://www.drupal.org/project/r4032login                                                                 *
echo  * 17.8   https://www.drupal.org/project/redirect_after_login    - Disabled                                         *
echo  * 17.9   https://www.drupal.org/project/login_destination                                                          *
echo  * 17.10  https://www.drupal.org/project/user_email_verification - disabled                                         *
echo  * 17.11  https://www.drupal.org/project/multiple_registration                                                      *
echo  *                                                                                                                  *
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/social_auth:3.1.0 --with-all-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/social_auth_google:3.0.0 --with-all-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/tfa:1.0 --with-all-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/prlp:1.10 --with-all-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/sendgrid_integration:2.1  --with-all-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/r4032login:2.2.1 --with-all-dependencies
echo  ********************************************************************************************************************
rem sudo php ~/composer.phar require drupal/redirect_after_login:2.7 --with-all-dependencies
echo ********************************************************************************************************************
sudo php ~/composer.phar require drupal/login_destination:2.0-beta6 --with-all-dependencies
echo ********************************************************************************************************************
rem sudo php ~/composer.phar require drupal/user_email_verification:1.1 --with-all-dependencies
echo ********************************************************************************************************************
sudo php ~/composer.phar require drupal/multiple_registration:3.2.0 --with-all-dependencies


echo ********************************************************************************************************************
echo * 18     Spam Protection                                                                                           *
echo ********************************************************************************************************************
echo *                                                                                                                  *
echo * 18.1   https://www.drupal.org/project/recaptcha                                                                  *
echo * 18.2   https://www.drupal.org/project/captcha                                                                    *
echo * 18.3   https://www.drupal.org/project/recaptcha_v3                                                               *
echo * 18.4   https://www.drupal.org/project/antibot                                                                    *
echo * 18.5   https://www.drupal.org/project/flood_control                                                              *
echo *                                                                                                                  *
echo ********************************************************************************************************************
sudo php ~/composer.phar require drupal/recaptcha:3.1  --with-all-dependencies
echo ********************************************************************************************************************
sudo php ~/composer.phar require drupal/captcha:1.10 --with-all-dependencies
echo ********************************************************************************************************************
sudo php ~/composer.phar require drupal/recaptcha_v3:1.8 --with-all-dependencies
echo ********************************************************************************************************************
sudo php ~/composer.phar require drupal/antibot:2.0.2 --with-all-dependencies
echo ********************************************************************************************************************
sudo php ~/composer.phar require drupal/flood_control:2.3.2 --with-all-dependencies



echo ********************************************************************************************************************
echo * 19     SEO                                                                                                       *
echo ********************************************************************************************************************
echo *                                                                                                                  *
echo * 19.1   https://www.drupal.org/project/pathauto                                                                   *
echo * 19.2   https://www.drupal.org/project/linkchecker                                                                *
echo * 19.3   https://www.drupal.org/project/xmlsitemap                                                                 *
echo * 19.4   https://www.drupal.org/project/metatag                                                                    *
echo * 19.5   https://www.drupal.org/project/seo_checklist                                                              *
echo *                                                                                                                  *
echo ********************************************************************************************************************
sudo php ~/composer.phar require drupal/pathauto:1.11 --with-all-dependencies
echo ********************************************************************************************************************
sudo php ~/composer.phar require drupal/linkchecker:1.1 --with-all-dependencies
echo ********************************************************************************************************************
sudo php ~/composer.phar require drupal/xmlsitemap:1.4 --with-all-dependencies
echo ********************************************************************************************************************
sudo php ~/composer.phar require drupal/metatag:1.22 --with-all-dependencies
echo ********************************************************************************************************************
sudo php ~/composer.phar require drupal/seo_checklist:5.1.0 --with-all-dependencies



echo ********************************************************************************************************************
echo * 20     Commerce                                                                                                  *
echo ********************************************************************************************************************
echo *                                                                                                                  *
echo * 20.1   https://www.drupal.org/project/inline_entity_form                                                         *
echo * 20.2   https://www.drupal.org/project/commerce                                                                   *
echo * 20.3   https://www.drupal.org/project/commerce_ticketing                                                         *
echo * 20.4   https://www.drupal.org/project/advancedqueue                                                              *
echo * 20.5   https://www.drupal.org/project/commerce_license                                                           *
echo * 20.6   https://www.drupal.org/project/commerce_webform_order                                                     *
echo * 20.7   https://www.drupal.org/project/commerce_donate                                                            *
echo * 20.8   https://www.drupal.org/project/commerce_add_to_cart_link                                                  *
echo * 20.9   https://www.drupal.org/project/commerce_shipping                                                          *
echo * 20.10  https://www.drupal.org/project/commerce_stock                                                             *
echo * 20.11  https://www.drupal.org/project/direct_checkout_by_url                                                     *
echo * 20.12  https://www.drupal.org/project/commerce_choose_price                                                      *
echo * 20.13  https://www.drupal.org/project/webform_product                                                            *
echo * 20.14  https://www.drupal.org/project/commerce_guest_registration                                                *
echo * 20.15  https://www.drupal.org/project/commerce_ccavenue                                                          *
echo * 20.16  https://www.drupal.org/project/commerce_razorpay                                                          *
echo * 20.17  https://github.com/paytm/Paytm_Drupal_Commerce_Plugin/tree/master/PaytmCommerceV8.x - manual              *
echo *                                                                                                                  *
echo ********************************************************************************************************************
sudo php ~/composer.phar require drupal/inline_entity_form:1.0-rc15 --with-all-dependencies
echo ********************************************************************************************************************
sudo php ~/composer.phar require drupal/commerce:2.35 --with-all-dependencies
echo ********************************************************************************************************************
sudo php ~/composer.phar require drupal/commerce_ticketing:2.0.0-alpha7 --with-all-dependencies
echo ********************************************************************************************************************
sudo php ~/composer.phar require drupal/advancedqueue:1.0-RC7   --with-all-dependencies
echo ********************************************************************************************************************
sudo php ~/composer.phar require drupal/commerce_license:2.0.0-beta2   --with-all-dependencies
echo ********************************************************************************************************************
sudo php ~/composer.phar require drupal/commerce_webform_order:2.0.0-beta2   --with-all-dependencies
echo ********************************************************************************************************************
sudo php ~/composer.phar require drupal/commerce_donate:1.1.0-alpha1  --with-all-dependencies
echo ********************************************************************************************************************
sudo php ~/composer.phar require drupal/commerce_add_to_cart_link:2.0.5  --with-all-dependencies
echo ********************************************************************************************************************
sudo php ~/composer.phar require drupal/commerce_shipping:2.6  --with-all-dependencies
echo ********************************************************************************************************************
sudo php ~/composer.phar require drupal/commerce_stock:1.0  --with-all-dependencies
echo ********************************************************************************************************************
sudo php ~/composer.phar require drupal/direct_checkout_by_url:1.1  --with-all-dependencies
echo ********************************************************************************************************************
sudo php ~/composer.phar require drupal/commerce_choose_price:1.3  --with-all-dependencies
echo ********************************************************************************************************************
sudo php ~/composer.phar require drupal/webform_product:3.0.4  --with-all-dependencies
echo ********************************************************************************************************************
sudo php ~/composer.phar require drupal/commerce_guest_registration:2.0.1  --with-all-dependencies
echo ********************************************************************************************************************
sudo php ~/composer.phar require drupal/commerce_ccavenue:3.0.3  --with-all-dependencies
echo ********************************************************************************************************************
sudo php ~/composer.phar require drupal/commerce_razorpay:2.0  --with-all-dependencies




echo ********************************************************************************************************************
echo * 21     BAT - Booking and Ticketing                                                                               *
echo ********************************************************************************************************************
echo *                                                                                                                  *
echo * 21.1   https://www.drupal.org/project/services                                                                   *
echo * 21.2   https://www.drupal.org/project/bat_api                                                                    *
echo * 21.3   https://www.drupal.org/project/bat                                                                        *
echo *                                                                                                                  *
echo ********************************************************************************************************************
sudo php ~/composer.phar require drupal/services:dev-4.x --with-dependencies
echo ********************************************************************************************************************
sudo php ~/composer.phar require drupal/bat_api:1.1.0 --with-all-dependencies
echo ********************************************************************************************************************
sudo php ~/composer.phar require drupal/bat:1.3.0 --with-all-dependencies
rem sudo php ~/composer.phar require drupal/bat:2.1-alpha1 --with-all-dependencies
echo ********************************************************************************************************************
sudo php ~/composer.phar require drupal/bee:1.2 --with-all-dependencies
echo ********************************************************************************************************************
sudo php ~/composer.phar require drupal/commerce_cart drupal/commerce_checkout drupal/commerce_number_pattern drupal/commerce_order drupal/commerce_payment drupal/commerce_price drupal/commerce_product drupal/commerce_store drupal/bat drupal/bat_calendar_reference drupal/bat_event drupal/bat_event_ui drupal/bat_fullcalendar drupal/bat_options drupal/bat_unit



echo ********************************************************************************************************************
echo * 22     Misc                                                                                                      *
echo ********************************************************************************************************************
echo *                                                                                                                  *
echo * 22.1   https://www.drupal.org/project/search_api_autocomplete                                                    *
echo * 22.2   https://www.drupal.org/project/search_api                                                                 *
echo * 22.3   https://www.drupal.org/project/facets                                                                     *
echo * 22.4   https://www.drupal.org/project/fullcalendar_library                                                       *
echo * 22.5   https://www.drupal.org/project/clientside_validation                                                      *
echo * 22.6   https://www.drupal.org/project/page_manager                                                               *
echo * 22.7   https://www.drupal.org/project/jquery_ui_checkboxradio                                                    *
echo *                                                                                                                  *
echo ********************************************************************************************************************
sudo php ~/composer.phar require drupal/search_api_autocomplete:1.7 --with-all-dependencies
echo ********************************************************************************************************************
sudo php ~/composer.phar require drupal/search_api:1.29  --with-all-dependencies
echo ********************************************************************************************************************
sudo php ~/composer.phar require drupal/facets:^2.0 --with-all-dependencies
echo ********************************************************************************************************************
sudo php ~/composer.phar require drupal/fullcalendar_library:1.1 --with-all-dependencies
echo ********************************************************************************************************************
sudo php ~/composer.phar require drupal/clientside_validation:4.0.2 --with-all-dependencies
echo ********************************************************************************************************************
sudo php ~/composer.phar require drupal/page_manager:4.0-rc2 --with-all-dependencies
echo ********************************************************************************************************************
sudo php ~/composer.phar require drupal/jquery_ui_checkboxradio:2.0.0 --with-all-dependencies
echo ********************************************************************************************************************
rem composer require drupal/search_exclude:3.0.0-beta1 --with-all-dependencies
