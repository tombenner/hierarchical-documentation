=== Hierarchical Documentation ===
Contributors: tombenner
Tags: documentation, hierarchical, reference, code, codex, tree, markdown, wiki, wpmvc, plugin
Requires at least: 3.0
Tested up to: 3.2.1
Stable tag: 1.1

Lets admins create searchable, hierarchically-organized documentation. Supports Markdown and syntax highlighting for code. Requires WP MVC.

== Description ==

Hierarchical Documentation allows admins to create public pages of documentation and organize them hierarchically using a tree listing the pages where each page can be dragged to its desired position. It supports syntax highlighting for blocks of code and [Markdown](http://daringfireball.net/projects/markdown/). 

For an example of Hierarchical Documentation in action, see [wpmvc.org](http://wpmvc.org/).

Please note that the default behavior is to display the documentation page that has an ID of 1 as the site's homepage. This can be changed by editing the first line of `hierarchical-documentation/app/config/routes.php`. (See the [WP MVC documentation page on routing](http://wpmvc.org/documentation/62/routing/) for details.)

This plugin depends on [WP MVC](http://wordpress.org/extend/plugins/wp-mvc/), so that plugin needs to be installed and activated before this one is activated.

If you'd like to grab development releases, see what new features are being added, or browse the source code please visit the [GitHub repo](http://github.com/tombenner/hierarchical-documentation).

== Installation ==

1. Upload `hierarchical-documentation` to the `wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= Is feature X available? =

This plugin was written quickly to make the [documentation site for WP MVC](http://wpmvc.org/) and thus isn't terribly feature-rich or pretty. If you have any suggestions of features that could be added or changes that could be made, please feel free to either add a topic in the WordPress forum or contact me through GitHub:

* [WordPress Forum](http://wordpress.org/tags/hierarchical-documentation?forum_id=10)
* [GitHub](http://github.com/tombenner/)

== Screenshots ==

1. The tree of draggable documentation pages that admins can organize.
2. The editing interface for documentation pages.  Markdown and syntax highlighting is supported, and a "Preview" button allows admins to preview what the content will look like before saving it.
3. The public display of a documentation page.