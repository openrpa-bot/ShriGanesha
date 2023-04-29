CONTENTS OF THIS FILE
---------------------

 * Introduction
 * Requirements
 * Installation
 * Configuration
 * Notes
 * Maintainers


INTRODUCTION
------------

Edit UUID is a simple module that allows us to update, change or add custom UUID
for an entity. Bundles and entity types are configurable to enable UUID field in
entity form so that user can change or provide own UUID for configured entity
types and bundles only, this feature can be restricted to admin users by
enabling role-specific permission (show edit uuid).

 * Some Roles can only see the UUID in entity form and Some Roles can update the
   UUID in entity form. (using edit UUID & show edit UUID permissions)

 * Some bundles can be configured to have option only to see the UUID in entity
   form, Some bundles can have the option to update the UUID in the entity form.

 * For a full description of the module, visit the project page:
   https://www.drupal.org/project/edit_uuid

 * To submit bug reports and feature suggestions, or to track changes:
   https://www.drupal.org/project/issues/edit_uuid


REQUIREMENTS
------------

No special requirements.


INSTALLATION
------------

 * Install as you would normally install a contributed Drupal module.
   See: https://www.drupal.org/node/895232 for further information.


CONFIGURATION
-------------

Configure the content types or any bundles that need to have UUID edit option by
navigating to extend listing page and search edit UUID, the searched result will
show Edit uuid module, click on configure.

Fields in the configuration form

 * Settings Name is simple name. it can be your own for your understanding.
 * Select the entity type which you want to change uuid or custom uuid.
   Example(node)
 * Select the content types loaded in bundles field.
   Example (Article) (multi-select field)
 * Save now and if you add a new article or edit exiting article,you will see
   UUID field in the form


NOTES
----

You need to create separate settings for each different configuration.
Updating an existing config will override the old configuration.


MAINTAINERS
-----------

Current maintainers:
 * Karthikeyan Manivasagam (karthikeyan-manivasagam) -
   https://www.drupal.org/u/karthikeyan-manivasagam
