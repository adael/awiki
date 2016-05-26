# Install instructions

* PHP 5.3+ required, works fine in PHP 7
* Install CakePHP 2.x
* Install wiki plugin. The folder name must be "Wiki"
* Add the plugin in app/Config/bootstrap.php

    CakePlugin::load('Wiki', array('bootstrap' => true, 'routes' => true));

* Import sql file **plugins/Wiki/Config/Schema/db-schema.sql** into your database
* Create/edit app/Config/database.php
* Access with http://path/to/application/wiki
* DONE!

# Features

* Simple and fast
* Not perfect
* Markdown for content
* Fulltext search
* Top menu is configurable with sublevels
* Lock pages
* Print mode
* Preview
* Made with CakePHP 2

# Some tips

* You can manage the wiki top menu using the dropdown button at the right of the search box (which is at top-right corner)
* Also you can view all created pages inside this menu
* Use simple brackets to create links (Example: \[page one\])
* For external links use \[Page title\]\(http://externalsite.org)
* You can create also internal links with alternative title like this: \[My internal page\]\(my_page_alias\)
* In edit mode you can preview your changes (use the green tick in toolbar, at most right)
