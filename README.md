# users-table-plugin

This List Users plugin list users and provide Filter by Role, pagination, sorting Options.

== Description ==

This plugin will list out WordPress site's users in table, it also provides facility of sorting asceding or desceding by display name or user name of users, pagination etc.

== Installation ==

This section describes how to install the plugin and get it working.

e.g.

1. Upload `users-table-plugin-master.zip` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Add shortcode or GutenBerg Blog in your page.

# For more info, please visit WP-admin-panel > settings > Codeable user table page to know more about usage.

Codeable Users Table
This Page will guide you about how to show user's table With shortcode OR Gutenberg Block

# 1: With Gutenberg Block

Add or edit your page and add new gutenberg block.
Add gutenberg users table in your page.

Select your newly added block and select settings as per your need.
You can set Order By option to order users by username or display name
You can set Order option to order users in ascending or descending order.
You can set Record per page option to show specific number of records on each page.

In Which specific Role you want to show You can set All Roles or the specific roles that you want to display
Please Note that Filter bar will be not available if you choose specific roles instead of all, since you only wanted
To show specific roles.

You can enable or disable Filter bar in Show Role Filter option

# 2: With Shortcode

Add or edit your page and add new shortcode widget block.

Add codeableusers shortcode which is:
[codeablelistusers]

You can use parameters in above shortcode, please check description of each shortcode option listed below:
Parameter	Description	Example
orderby	option to order users by username or display name	To order by display name:
[codeablelistusers orderby="display_name"]

OR To order by user name:
[codeablelistusers orderby="user_login"]

order	option to order users in ascending or descending order.	To order ascending:
[codeablelistusers order="ASC"]

OR To order descendingshow:
[codeablelistusers order="DESC"]

role	You can set All Roles or the specific roles that you want to display
Please Note that Filter bar will be not available 
if you choose specific roles instead of all	To show All Roles:
[codeablelistusers role="all"]

To show specific roles:
[codeablelistusers role="author"]

showfilter	You can enable or disable Filter bar with this option	
[codeablelistusers showfilter="show"]

OR
[codeablelistusers showfilter="hide"]

per_page	option to show specific number of records on each page	
[codeablelistusers per_page="12"]

You can use multiple parameter together, example:
[codeablelistusers per_page="12" showfilter="show" role="all"]

