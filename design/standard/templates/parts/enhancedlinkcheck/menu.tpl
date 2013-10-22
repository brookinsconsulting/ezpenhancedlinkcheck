{*
  To be able to define menu entries in ini at the same time as letting i18n
  system translate the names, we use a lookup table for translatable strings.
  If the ini name is not defined here (key), then LinkNames ini value is used.
  For extensions that need to extend this, you either have to override this
  template or let translations use LinkNames as described in menu.ini.
*}

{include uri='design:parts/ini_menu.tpl' ini_section='Leftmenu_enhancedlinkcheck_urls' i18n_hash=hash(
             'urls',  'Urls'|i18n( 'design/admin/parts/ezpenhancedlinkcheck/menu' ),
             'Link management',  'Link management'|i18n( 'design/admin/parts/ezpenhancedlinkcheck/menu' ),
             'project', 'Extension project'|i18n( 'design/admin/parts/ezpenhancedlinkcheck/menu' ) )}