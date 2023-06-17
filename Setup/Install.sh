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
echo  * 2      Theam - (Compatible with 10)                                                                              *
echo  ********************************************************************************************************************
echo  *                                                                                                                  *
echo  * 2.1    https://www.drupal.org/project/bootstrap_barrio                                                           *
echo  * 2.2    https://www.drupal.org/project/bootstrap5                                                                 *
echo  * 2.3    https://www.drupal.org/project/dxpr_theme                                                                 *
echo  * 2.4    https://www.drupal.org/project/dxpr_builder                                                               *
echo  * 2.5    https://www.drupal.org/project/view_modes_display                                                         *
echo  *                                                                                                                  *
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/bootstrap_barrio:5.5.12 --with-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/bootstrap5:3.0.8 --with-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/dxpr_theme:5.1.0 --with-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/dxpr_builder:2.2.6 --with-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/view_modes_display:3.0.0 --with-dependencies


echo  ********************************************************************************************************************
echo  * 3      Layout Builder - (Compatible with 10)                                                                     *
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
echo  * 4      Menu - (Compatible 10 with disabled modules - tb_megamenu-3.0.0-alpha2 , we_megamenu)                     *
echo  ********************************************************************************************************************
echo  *                                                                                                                  *
echo  * 4.1    https://www.drupal.org/project/admin_toolbar                                                              *
echo  * 4.2    https://www.drupal.org/project/menu_per_role                                                              *
echo  * 4.3    https://www.drupal.org/project/tb_megamenu - Disabled                                                     * - NC - 10
echo  * 4.4    https://www.drupal.org/project/extlink                                                                    *
echo  * 4.5    https://www.drupal.org/project/we_megamenu - Disabled                                                     * - NC - 10
echo  *                                                                                                                  *
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/admin_toolbar:3.4.1 --with-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/menu_per_role:1.5 --with-all-dependencies
echo  ********************************************************************************************************************
rem sudo php ~/composer.phar require drupal/tb_megamenu:1.7 --with-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/extlink:1.7 --with-dependencies
echo  ********************************************************************************************************************
rem sudo php ~/composer.phar require drupal/we_megamenu:1.13 --with-dependencies



echo  ********************************************************************************************************************
echo  * 5      Google Analytics (Compatible 10 with disabled modules - google_analytics_reports:4.0.0-alpha4)            *
echo  ********************************************************************************************************************
echo  *                                                                                                                  *
echo  * 5.1    https://www.drupal.org/project/google_analytics                                                           *
echo  * 5.2    https://www.drupal.org/project/google_analytics_reports  - Disabled                                       *
echo  * 5.3    https://www.drupal.org/project/google_tag                                                                 *
echo  *                                                                                                                  *
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/google_analytics:4.0.2 --with-all-dependencies
echo  ********************************************************************************************************************
rem sudo php ~/composer.phar require drupal/google_analytics_reports:4.0.0-alpha4 --with-all-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/google_tag:2.0.2  --with-all-dependencies



echo  ********************************************************************************************************************
echo  * 6      Site Debug (Compatible 10 with disabled modules - dbug:2.0.0)                                             *
echo  ********************************************************************************************************************
echo  *                                                                                                                  *
echo  * 6.1    https://www.drupal.org/project/devel                                                                      *
echo  * 6.2    https://www.drupal.org/project/dbug - Disabled                                                            * - NC - 10
echo  * 6.3    https://www.drupal.org/project/drush                                                                      *
echo  * 6.4    https://www.drupal.org/project/webprofiler                                                                *
echo  * 6.5    https://www.drupal.org/project/twig_debugger                                                              *
echo  *                                                                                                                  *
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/devel:5.1.2  --with-all-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/dbug:2.0.0 --with-all-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drush/drush:12.1.0  --with-all-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/webprofiler:10.0.0  --with-all-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/twig_debugger:1.1.3  --with-all-dependencies



echo  ********************************************************************************************************************
echo  * 7      Amazon S3 Ref - (Compatible with 10)                                                                      *
echo  ********************************************************************************************************************
echo  *                                                                                                                  *
echo  * 7.1    https://www.drupal.org/project/s3fs                                                                       *
echo  *                                                                                                                  *
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/s3fs:3.3 --with-all-dependencies



echo  ********************************************************************************************************************
echo  * 8      Slider (Compatible 10 with disabled modules - flexslider:2.0)                                             *
echo  ********************************************************************************************************************
echo  *                                                                                                                  *
echo  * 8.1    https://www.drupal.org/project/flexslider - Disabled                                                      * - NC - 10
echo  * 8.2    https://www.drupal.org/project/views_slideshow                                                            *
echo  *                                                                                                                  *
echo  ********************************************************************************************************************
rem sudo php ~/composer.phar require drupal/flexslider:2.0   --with-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/views_slideshow:5.0.0  --with-dependencies


echo  ********************************************************************************************************************
echo  * 9      Social (Compatible with 10)                                                                               *
echo  ********************************************************************************************************************
echo  *                                                                                                                  *
echo  * 9.1    https://www.drupal.org/project/social_media_links                                                         *
echo  * 9.2    https://www.drupal.org/project/better_social_sharing_buttons                                              *
echo  *                                                                                                                  *
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/social_media_links:2.9 --with-all-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/better_social_sharing_buttons:4.0.4 --with-all-dependencies



echo  ********************************************************************************************************************
echo  * 10     Modal Dialogue (Compatible with 10)                                                                       *
echo  ********************************************************************************************************************
echo  *                                                                                                                  *
echo  * 10.1   https://www.drupal.org/project/simple_popup_blocks                                                        *
echo  * 10.2   https://www.drupal.org/project/modal_page                                                                 *
echo  *                                                                                                                  *
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/simple_popup_blocks:3.1 --with-all-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/modal_page:5.0.1 --with-dependencies



echo  ********************************************************************************************************************
echo  * 11     Poll (Compatible with 10)                                                                                 *
echo  ********************************************************************************************************************
echo  *                                                                                                                  *
echo  * 11.1   https://www.drupal.org/project/poll                                                                       *
echo  *                                                                                                                  *
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/poll:1.6  --with-all-dependencies



echo  ********************************************************************************************************************
echo  * 12     Webform (Not Compatible with 10)                                                                          *
echo  ********************************************************************************************************************
echo  *                                                                                                                  *
echo  * 12.1   https://www.drupal.org/project/webform                                                                    * - NC - 10 -beta5
echo  * 12.2   https://www.drupal.org/project/webform_content_creator                                                    *
echo  * 12.3   https://www.drupal.org/project/webform_gmap_field                                                         *
echo  * 12.4   https://www.drupal.org/project/webform_counter - Disabled                                                 * - NC - 10
echo  * 12.5   https://www.drupal.org/project/webform_hierarchy                                                          * - NC - 10
echo  * 12.6   https://www.drupal.org/project/webform_views                                                              *
echo  *                                                                                                                  *
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/webform:6.2.0-beta5 --with-all-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/webform_content_creator:4.0.4 --with-all-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/webform_gmap_field:1.1 --with-all-dependencies
echo  ********************************************************************************************************************
rem sudo php ~/composer.phar require drupal/webform_counter:1.0 --with-all-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/webform_hierarchy:1.1 --with-all-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/webform_views:5.1 --with-all-dependencies



echo  ********************************************************************************************************************
echo  * 13     Fields (Compatible 10 with disabled modules - edit_uuid:2.1)                                              *
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
echo  * 13.9   https://www.drupal.org/project/text_field_formatter                                                       *
echo  * 13.10  https://www.drupal.org/project/multiple_selects                                                           *
echo  * 13.11  https://www.drupal.org/project/uuid_extra                                                                 *
echo  * 13.12  https://www.drupal.org/project/edit_uuid - Disabled                                                       * - NC - 10
echo  * 13.13  https://www.drupal.org/project/field_token_value                                                          *
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
sudo php ~/composer.phar require drupal/geofield:1.53   --with-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/geofield_map:3.0.10 --with-all-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/text_field_formatter:2.0.1  --with-all-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/multiple_selects:1.1  --with-all-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/uuid_extra:2.0.1  --with-all-dependencies
echo  ********************************************************************************************************************
rem sudo php ~/composer.phar require drupal/edit_uuid:2.1 --with-all-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/field_token_value:3.0.1 --with-all-dependencies



echo  ********************************************************************************************************************
echo  * 14     Field Formatters(Compatible 10 disabled-field_group_table,boolean_single_state_formatter,endroid_qr_code) *
echo  ********************************************************************************************************************
echo  *                                                                                                                  *
echo  * 14.1   https://www.drupal.org/project/conditional_fields                                                         * alpha3
echo  * 14.2   https://www.drupal.org/project/twig_field_value                                                           *
echo  * 14.3   https://www.drupal.org/project/exclude_node_title                                                         *
echo  * 14.4   https://www.drupal.org/project/field_permissions                                                          *
echo  * 14.5   https://www.drupal.org/project/field_formatter_class                                                      *
echo  * 14.6   https://www.drupal.org/project/field_group                                                                *
echo  * 14.7   https://www.drupal.org/project/field_group_table   - Disabled                                             * - NC - 10
echo  * 14.8   https://www.drupal.org/project/boolean_single_state_formatter  - Disabled                                 * - NC - 10
echo  * 14.9   https://www.drupal.org/project/endroid_qr_code -disabled      - Disabled                                  * - NC - 10
echo  * 14.10  https://www.drupal.org/project/barcodes                                                                   *
echo  * 14.11  https://www.drupal.org/project/field_token_value                                                          *
echo  *                                                                                                                  *
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/conditional_fields:4.0.0-alpha3  --with-dependencies
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
sudo php ~/composer.phar require drupal/barcodes:2.0.5 --with-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/field_token_value:3.0.1 --with-dependencies





echo  ********************************************************************************************************************
echo  * 15     View Formatters (Compatible 10 with disabled modules)                                                     *
echo  ********************************************************************************************************************
echo  *                                                                                                                  *
echo  * 15.1   https://www.drupal.org/project/pdf_api                                                                    *
echo  * 15.2   https://www.drupal.org/project/addtoany                                                                   *
echo  * 15.3   https://www.drupal.org/project/better_exposed_filters                                                     *
echo  * 15.4   https://www.drupal.org/project/image_resize_filter   - Disabled                                           * - NC - 10
echo  * 15.5   https://www.drupal.org/project/views_conditional                                                          *
echo  * 15.6   https://www.drupal.org/project/autocomplete_deluxe                                                        *
echo  * 15.7   https://www.drupal.org/project/asset_injector                                                             *
echo  * 15.8   https://www.drupal.org/project/jquery_ui_tooltip                                                          *
echo  * 15.9   https://www.drupal.org/project/ctools                                                                     *
echo  * 15.10  https://www.drupal.org/project/entity_embed                                                               *
echo  * 15.11  https://www.drupal.org/project/field_description_tooltip                                                  *
echo  * 15.12  https://www.drupal.org/project/tooltip_ckeditor - disabled                                                *
echo  * 15.13  https://www.drupal.org/project/jquery_countdown_timer  - disabled                                         *  - NC - 10
echo  * 15.14  https://www.drupal.org/project/typed_data     - disabled                                                  * 8.x-1.0-beta2
echo  * 15.15  https://www.drupal.org/project/rules  - disabled                                                          * - NC - 10
echo  * 15.16  https://www.drupal.org/project/entity_class_formatter                                                     *
echo  * 15.17  https://www.drupal.org/project/background_image                                                           *
echo  * 15.18  https://www.drupal.org/project/workflow                                                                   *
echo  * 15.19  https://www.drupal.org/project/eca                                                                        *
echo  * 15.20  https://www.drupal.org/project/bpmn_io                                                                    *
echo  * 15.21  https://www.drupal.org/project/eca_cm                                                                     *
echo  * 15.22  https://www.drupal.org/project/eca_state_machine                                                          *
echo  * 15.23  https://www.drupal.org/project/entity_field_condition                                                     *
echo  *                                                                                                                  *
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/pdf_api:2.3.1 --with-all-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/addtoany:2.0.4 --with-all-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/better_exposed_filters:6.0.3 --with-all-dependencies
echo  ********************************************************************************************************************
rem sudo php ~/composer.phar require drupal/image_resize_filter:1.1 --with-all-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/views_conditional:1.5 --with-all-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/autocomplete_deluxe:2.0.3 --with-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/asset_injector:2.17 --with-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/jquery_ui_tooltip:2.0.0 --with-dependencies
rem sudo php ~/composer.phar require drupal/jquery_ui_tooltip:1.1.0 --with-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/ctools:4.0.4 --with-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/entity_embed:1.4 --with-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/field_description_tooltip:1.0.2 --with-dependencies
echo  ********************************************************************************************************************
rem sudo php ~/composer.phar require drupal/tooltip_ckeditor:4.0.1 --with-dependencies
echo  ********************************************************************************************************************
rem sudo php ~/composer.phar require drupal/jquery_countdown_timer:1.3 --with-dependencies
echo  ********************************************************************************************************************
rem sudo php ~/composer.phar require drupal/typed_data:1.0-beta2 --with-dependencies
echo  ********************************************************************************************************************
rem sudo php ~/composer.phar require drupal/rules:3.0-alpha7 --with-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/entity_class_formatter:2.0.0 --with-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/background_image:2.0.1 --with-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/workflow:1.7 --with-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/eca:1.1.3 --with-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/bpmn_io:1.1.1 --with-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/eca_cm:1.0.5 --with-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/eca_state_machine:1.0.1 --with-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/entity_field_condition:1.4 --with-dependencies



echo  ********************************************************************************************************************
echo  * 16     Geo/Map Module (Compatible 10 )                                                                           *
echo  ********************************************************************************************************************
echo  *                                                                                                                  *
echo  * 16.1   https://www.drupal.org/project/geolocation                                                                *
echo  * 16.2   https://www.drupal.org/project/geocoder                                                                   *
echo  * 16.3   https://www.drupal.org/project/webform_ip_geo                                                             *
echo  * 16.4   https://www.drupal.org/project/search_api_location  - disabled                                            * 8.x-1.0-alpha3 
echo  * 16.5   https://www.drupal.org/project/search_api_location  - disabled                                            * 
echo  * 16.6   https://www.drupal.org/project/search_api_location  - disabled                                            *  
echo  *                                                                                                                  *
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/geolocation:3.12 --with-all-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/geocoder:4.9 --with-all-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/webform_ip_geo:1.0.4 --with-all-dependencies
echo  ********************************************************************************************************************
rem sudo php ~/composer.phar require drupal/search_api_location:1.0-alpha3 --with-all-dependencies
echo  ********************************************************************************************************************
rem sudo php ~/composer.phar require geocodio/geocodio-library-php --with-all-dependencies
echo  ********************************************************************************************************************
rem sudo php ~/composer.phar require sibyx/phpgpx:@RC --with-all-dependencies



echo  ********************************************************************************************************************
echo  * 17       Social Login (Compatible 10)                                                                            *
echo  ********************************************************************************************************************
echo  *                                                                                                                  *
echo  * 17.1   https://www.drupal.org/project/social_auth                                                                *
echo  * 17.2   https://www.drupal.org/project/social_auth_google                                                         *
echo  * 17.3   https://www.drupal.org/project/social_auth_facebook/                                                      *
echo  *                                                                                                                  *
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/social_auth:4.0.1 --with-all-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/social_auth_google:4.0.0 --with-all-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/social_auth_facebook:4.0.1 --with-all-dependencies



echo  ********************************************************************************************************************
echo  * 17.1     User Login   (Compatible 10 with disabled modules)                                                      *
echo  ********************************************************************************************************************
echo  *                                                                                                                  * 
echo  * 17.4   https://www.drupal.org/project/tfa   - Disabled                                                           *  2.0.0-alpha2
echo  * 17.5   https://www.drupal.org/project/prlp                                                                       *
echo  * 17.6   https://www.drupal.org/project/sendgrid_integration  - Disabled                                           *
echo  * 17.7   https://www.drupal.org/project/r4032login                                                                 *
echo  * 17.8   https://www.drupal.org/project/redirect_after_login    - Disabled                                         *  - NC - 10
echo  * 17.9   https://www.drupal.org/project/login_destination       -disabled                                          * 8.x-2.0-beta6
echo  * 17.10  https://www.drupal.org/project/user_email_verification - disabled                                         *  - NC - 10
echo  * 17.11  https://www.drupal.org/project/multiple_registration                                                      *
echo  * 17.12  https://www.drupal.org/project/smtp                                                                       *
echo  *                                                                                                                  *
echo  ********************************************************************************************************************
rem sudo php ~/composer.phar require drupal/tfa:1.0 --with-all-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/prlp:1.10 --with-all-dependencies
echo  ********************************************************************************************************************
rem sudo php ~/composer.phar require drupal/sendgrid_integration:2.1  --with-all-dependencies
echo  ********************************************************************************************************************
sudo php ~/composer.phar require drupal/r4032login:2.2.1 --with-all-dependencies
echo  ********************************************************************************************************************
rem sudo php ~/composer.phar require drupal/redirect_after_login:2.7 --with-all-dependencies
echo ********************************************************************************************************************
rem sudo php ~/composer.phar require drupal/login_destination:2.0-beta6 --with-all-dependencies
echo ********************************************************************************************************************
rem sudo php ~/composer.phar require drupal/user_email_verification:1.1 --with-all-dependencies
echo ********************************************************************************************************************
sudo php ~/composer.phar require drupal/multiple_registration:3.2.4 --with-all-dependencies
echo ********************************************************************************************************************
sudo php ~/composer.phar require drupal/smtp:1.2 --with-dependencies



echo ********************************************************************************************************************
echo * 18     Spam Protection  (Compatible 10 )                                                                         *
echo ********************************************************************************************************************
echo *                                                                                                                  *
echo * 18.1   https://www.drupal.org/project/recaptcha                                                                  *
echo * 18.2   https://www.drupal.org/project/captcha                                                                    *
echo * 18.3   https://www.drupal.org/project/recaptcha_v3                                                               *
echo * 18.4   https://www.drupal.org/project/antibot                                                                    *
echo * 18.5   https://www.drupal.org/project/flood_control                                                              *
echo *                                                                                                                  *
echo ********************************************************************************************************************
sudo php ~/composer.phar require drupal/recaptcha:3.2  --with-all-dependencies
echo ********************************************************************************************************************
sudo php ~/composer.phar require drupal/captcha:2.0.0 --with-all-dependencies
echo ********************************************************************************************************************
sudo php ~/composer.phar require drupal/recaptcha_v3:1.8 --with-all-dependencies
echo ********************************************************************************************************************
sudo php ~/composer.phar require drupal/antibot:2.0.2 --with-all-dependencies
echo ********************************************************************************************************************
sudo php ~/composer.phar require drupal/flood_control:2.3.2 --with-all-dependencies



echo ********************************************************************************************************************
echo * 19     SEO  (Compatible 10 with disabled modules)                                                                *
echo ********************************************************************************************************************
echo *                                                                                                                  *
echo * 19.1   https://www.drupal.org/project/pathauto                                                                   *
echo * 19.2   https://www.drupal.org/project/linkchecker - Disabled                                                     * - NC - 10
echo * 19.3   https://www.drupal.org/project/xmlsitemap                                                                 *
echo * 19.4   https://www.drupal.org/project/metatag                                                                    *
echo * 19.5   https://www.drupal.org/project/seo_checklist - Disabled                                                   * - NC - 10
echo *                                                                                                                  *
echo ********************************************************************************************************************
sudo php ~/composer.phar require drupal/pathauto:1.11 --with-all-dependencies
echo ********************************************************************************************************************
rem sudo php ~/composer.phar require drupal/linkchecker:1.1 --with-all-dependencies
echo ********************************************************************************************************************
sudo php ~/composer.phar require drupal/xmlsitemap:1.4 --with-all-dependencies
echo ********************************************************************************************************************
sudo php ~/composer.phar require drupal/metatag:1.25 --with-all-dependencies
echo ********************************************************************************************************************
rem sudo php ~/composer.phar require drupal/seo_checklist:5.1.0 --with-all-dependencies



echo ********************************************************************************************************************
echo * 20     Commerce (Compatible 10 with disabled modules)                                                                                                 *
echo ********************************************************************************************************************
echo *                                                                                                                  *
echo * 20.1   https://www.drupal.org/project/inline_entity_form - Disabled                                              * 2.0.0-rc4 
echo * 20.2   https://www.drupal.org/project/commerce                                                                   *
echo * 20.3   https://www.drupal.org/project/commerce_ticketing  - Disabled                                             * - NC - 10 - 2.0.0-alpha7
echo * 20.4   https://www.drupal.org/project/advancedqueue  - Disabled                                                  * 8.x-1.0-rc7 
echo * 20.5   https://www.drupal.org/project/commerce_license                                                           * 3.0.0-rc6
echo * 20.6   https://www.drupal.org/project/commerce_webform_order - Disabled                                          * 2.0.0-beta2 
echo * 20.7   https://www.drupal.org/project/commerce_donate                                                            * - NC - 10 - 8.x-1.1-alpha1
echo * 20.8   https://www.drupal.org/project/commerce_add_to_cart_link                                                  *
echo * 20.9   https://www.drupal.org/project/commerce_shipping                                                          *
echo * 20.10  https://www.drupal.org/project/commerce_stock  - Disabled                                                 * - NC  - 10 
echo * 20.11  https://www.drupal.org/project/direct_checkout_by_url - Disabled                                          * - NC  - 10
echo * 20.12  https://www.drupal.org/project/commerce_choose_price - Disabled                                           * - NC  - 10
echo * 20.13  https://www.drupal.org/project/webform_product                                                            *
echo * 20.14  https://www.drupal.org/project/commerce_guest_registration - Disabled                                     * - NC  - 10
echo * 20.15  https://www.drupal.org/project/commerce_ccavenue - Disabled                                               * - NC  - 10
echo * 20.16  https://www.drupal.org/project/commerce_razorpay - Disabled                                               * - NC  - 10 need to enable
echo * 20.17  https://github.com/paytm/Paytm_Drupal_Commerce_Plugin/tree/master/PaytmCommerceV8.x - manual              *
echo *                                                                                                                  *
echo ********************************************************************************************************************
rem sudo php ~/composer.phar require drupal/inline_entity_form:1.0-rc15 --with-all-dependencies
echo ********************************************************************************************************************
sudo php ~/composer.phar require drupal/commerce:2.36 --with-all-dependencies
echo ********************************************************************************************************************
rem sudo php ~/composer.phar require drupal/commerce_ticketing:2.0.0-alpha7 --with-all-dependencies
echo ********************************************************************************************************************
sudo php ~/composer.phar require drupal/advancedqueue:1.0-RC7   --with-all-dependencies
echo ********************************************************************************************************************
sudo php ~/composer.phar require drupal/commerce_license:2.0.0-beta2   --with-all-dependencies
echo ********************************************************************************************************************
sudo php ~/composer.phar require drupal/commerce_webform_order:2.0.0-beta2   --with-all-dependencies
echo ********************************************************************************************************************
rem sudo php ~/composer.phar require drupal/commerce_donate:1.1.0-alpha1  --with-all-dependencies
echo ********************************************************************************************************************
sudo php ~/composer.phar require drupal/commerce_add_to_cart_link:2.0.5  --with-all-dependencies
echo ********************************************************************************************************************
sudo php ~/composer.phar require drupal/commerce_shipping:2.6  --with-all-dependencies
echo ********************************************************************************************************************
rem sudo php ~/composer.phar require drupal/commerce_stock:1.0  --with-all-dependencies
echo ********************************************************************************************************************
rem sudo php ~/composer.phar require drupal/direct_checkout_by_url:1.1  --with-all-dependencies
echo ********************************************************************************************************************
rem sudo php ~/composer.phar require drupal/commerce_choose_price:1.3  --with-all-dependencies
echo ********************************************************************************************************************
sudo php ~/composer.phar require drupal/webform_product:3.0.4  --with-all-dependencies
echo ********************************************************************************************************************
rem sudo php ~/composer.phar require drupal/commerce_guest_registration:2.0.1  --with-all-dependencies
echo ********************************************************************************************************************
rem sudo php ~/composer.phar require drupal/commerce_ccavenue:3.0.3  --with-all-dependencies
echo ********************************************************************************************************************
sudo php ~/composer.phar require drupal/commerce_razorpay:2.0  --with-all-dependencies




echo ********************************************************************************************************************
echo * 21     BAT - Booking and Ticketing                                                                               *
echo ********************************************************************************************************************
echo *                                                                                                                  *
echo * 21.1   https://www.drupal.org/project/services - Disabled                                                        * - 5.0.0-beta7
echo * 21.2   https://www.drupal.org/project/bat_api - Disabled                                                         * - NC - 10 - bat_api 8.x-1.1
echo * 21.3   https://www.drupal.org/project/bat  - Disabled                                                            * - NC - 10 - bat 8.x-2.1-alpha1
echo *                                                                                                                  *
echo ********************************************************************************************************************
rem sudo php ~/composer.phar require drupal/services:dev-4.x --with-dependencies
echo ********************************************************************************************************************
rem sudo php ~/composer.phar require drupal/bat_api:1.1.0 --with-all-dependencies
echo ********************************************************************************************************************
rem sudo php ~/composer.phar require drupal/bat:1.3.0 --with-all-dependencies
rem sudo php ~/composer.phar require drupal/bat:2.1-alpha1 --with-all-dependencies
echo ********************************************************************************************************************
rem sudo php ~/composer.phar require drupal/bee:1.2 --with-all-dependencies
echo ********************************************************************************************************************
rem sudo php ~/composer.phar require drupal/commerce_cart drupal/commerce_checkout drupal/commerce_number_pattern drupal/commerce_order drupal/commerce_payment drupal/commerce_price drupal/commerce_product drupal/commerce_store drupal/bat drupal/bat_calendar_reference drupal/bat_event drupal/bat_event_ui drupal/bat_fullcalendar drupal/bat_options drupal/bat_unit



echo ********************************************************************************************************************
echo * 22     Misc                                                                                                      *
echo ********************************************************************************************************************
echo *                                                                                                                  *
echo * 22.1   https://www.drupal.org/project/search_api_autocomplete                                                    *
echo * 22.2   https://www.drupal.org/project/search_api                                                                 *
echo * 22.3   https://www.drupal.org/project/facets                                                                     *
echo * 22.4   https://www.drupal.org/project/fullcalendar_library - Disabled                                            * - NC - 10
echo * 22.5   https://www.drupal.org/project/clientside_validation                                                      *
echo * 22.6   https://www.drupal.org/project/page_manager                                                               * 4.0-rc2
echo * 22.7   https://www.drupal.org/project/jquery_ui_checkboxradio                                                    *
echo * 22.8   https://www.drupal.org/project/search_exclude - Disabled                                                  * - NC - 10 - 3.0.0-beta1
echo *                                                                                                                  *
echo ********************************************************************************************************************
sudo php ~/composer.phar require drupal/search_api_autocomplete:1.7 --with-all-dependencies
echo ********************************************************************************************************************
sudo php ~/composer.phar require drupal/search_api:1.29  --with-all-dependencies
echo ********************************************************************************************************************
sudo php ~/composer.phar require drupal/facets:^2.0 --with-all-dependencies
echo ********************************************************************************************************************
rem sudo php ~/composer.phar require drupal/fullcalendar_library:1.1 --with-all-dependencies
echo ********************************************************************************************************************
sudo php ~/composer.phar require drupal/clientside_validation:4.0.2 --with-all-dependencies
echo ********************************************************************************************************************
sudo php ~/composer.phar require drupal/page_manager:4.0-rc2 --with-all-dependencies
echo ********************************************************************************************************************
sudo php ~/composer.phar require drupal/jquery_ui_checkboxradio:2.0.0 --with-all-dependencies
echo ********************************************************************************************************************
rem composer require drupal/search_exclude:3.0.0-beta1 --with-all-dependencies
