cls
set MySqlCommand="C:\xampp\mysql\bin\mysql.exe"

set workingFolder=C:\xampp\htdocs\ShriGanesha

cd %workingFolder%

set webFolderName=SRS
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

rem call composer create-project drupal/recommended-project:9.4.3 %webFolderName%
rem call composer create-project drupal/recommended-project:9.5.7 %webFolderName%
call composer create-project drupal/recommended-project:9.5.7 %webFolderName%

cd %webFolderName%
call composer update  drupal/core-* --with-all-dependencies
call composer update  drupal/core-* --with-dependencies

call composer require drupal/admin_toolbar:^3.3 --with-dependencies
call composer require drupal/bootstrap_barrio:5.5.10 --with-dependencies
call composer require drupal/bootstrap5:3.0.5 --with-dependencies

call composer require drupal/conditional_fields:4.0.0-alpha2  --with-dependencies
call composer require drupal/flexslider:2.0   --with-dependencies
call composer require drupal/views_slideshow:5.0.0  --with-dependencies
call composer require drupal/geofield:1.52   --with-dependencies
call composer require drupal/twig_field_value:2.0.0  --with-dependencies
call composer require drupal/youtube:2.0.0   --with-dependencies
call composer require drupal/geolocation:3.12 --with-all-dependencies
call composer require drupal/geocoder:3.32 --with-all-dependencies
call composer require drupal/addtoany:2.0.1 --with-all-dependencies
call composer require drupal/pathauto:1.11 --with-all-dependencies
call composer require drupal/recaptcha:3.1  --with-all-dependencies
call composer require drupal/editor_file:1.7  --with-dependencies

call composer require drupal/webform:6.2.0-beta5 --with-all-dependencies
call composer require drupal/webform_ip_geo:1.0.4 --with-all-dependencies

call composer require drupal/captcha:1.9 --with-all-dependencies
call composer require drupal/google_analytics:4.0.2 --with-all-dependencies

call composer require drupal/inline_entity_form:1.0-rc15 --with-all-dependencies
call composer require drupal/commerce:2.34 --with-all-dependencies

call composer require drupal/commerce_ticketing:2.0.0-alpha7 --with-all-dependencies

call composer require drupal/services:dev-4.x --with-dependencies
call composer require drupal/bat_api:1.1.0 --with-all-dependencies

call composer require drupal/bat:1.3.0 --with-all-dependencies

call composer require drupal/advancedqueue:1.0-RC7   --with-all-dependencies
call composer require drupal/commerce_license:2.0.0-beta2   --with-all-dependencies

call composer require drupal/commerce_webform_order:2.0.0-beta2   --with-all-dependencies

call composer require drupal/commerce_donate:1.1.0-alpha1  --with-all-dependencies


Rem Short from Module Extend\Install.

call composer require drupal/search_api:1.29  --with-all-dependencies
call composer require drupal/facets:^2.0 --with-all-dependencies
call composer require drupal/fullcalendar_library:1.1 --with-all-dependencies

call composer require drupal/clientside_validation:4.0.2 --with-all-dependencies
call composer require drupal/devel:5.1.1  --with-all-dependencies

GOTO MyEOF

git config --global github.accesstoken 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

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


:MyEOF

cd C:\xampp\htdocs\ShriGanesha\Setup