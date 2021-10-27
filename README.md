<!-- statamic:hide -->

![Statamic](https://flat.badgen.net/badge/Statamic/3.2+/FF269E)
![Packagist version](https://flat.badgen.net/packagist/v/jacksleight/statamic-members)

# Members 

<!-- /statamic:hide -->

This Statamic addon provides an out of the box solution for adding a members area or member restricted content to your site, building on Statamic’s existing user management and user form tags. It also provides a dedicated members section in the control panel, allowing you to manage members independently of other users.

> **Important:** This addon uses Statamic’s multi-user features, which are Pro only. Therefore this addon will only work with the Pro edition.

## Features

* A dedicated members section in the control panel that:
	* Only lists member users and allows you to search them
	* Allows you to create members through a simplified user wizard
	* Allows you to send member specific welcome emails that link to a frontend activation form
	* Uses seperate view, create and edit member permissions
* Implementations of all built-in user forms:
	* Register
	* Login
	* Forgot password
	* Reset password
* And these additional member forms:
	* Activate account
	* Edit account
	* Update password
* Member tags that make it super simple to control what content is restricted to which members and how
* A handful of form URL tags

## Who’s a Member?

This addon defines a member as any user who has the roles and groups listed in the `statamic.users.new_user_roles` and `statamic.users.new_user_groups` config variables, as these are the roles and groups Statamic assigns to users who register themselves through the user register form.

## Documentation

- [Installation](#installation)
- [Configuration](#configuration)
  * [Customising the view templates](#customising-the-view-templates)
  * [Customising the welcome email](#customising-the-welcome-email)
  * [Customising the control panel labels](#customising-the-control-panel-text)
  * [Control Panel Permissions](#control-panel-permissions)
- [Implementation](#implementation)
  * [Restrict an entire area of the site based on a URL prefix](#restrict-an-entire-area-of-the-site-based-on-a-url-prefix)
  * [Restrict individual pages based on an entry field](#restrict-individual-pages-based-on-an-entry-field)
  * [Restrict a sections of a page](#restrict-a-sections-of-a-page)
  * [Specify additional conditions](#specify-additional-conditions)
  * [Use member tags in `{{ if }}` statements](#use-member-tags-in-----if-----statements)
- [Navigation Links](#navigation-links)

## Installation

You can search for this addon in the `Tools > Addons` section of the Statamic control panel and click **install**, or run the following command from your project root:

```bash
composer require jacksleight/statamic-members
```

## Configuration

The first thing you'll need to do is set Statamic's new user settings to the roles/groups you want member users to have. You can specify any roles/groups you like, but for a simple setup I would recommend a single group called `members`. To do this you'll need to create a `members` group and then open `config/statamic/users.php` and update the `new_user_groups` setting:

```php
'new_user_groups' => [
    'members',
],
```

Next you should publish the members config:

```bash
php please vendor:publish --tag=statamic-members-config
```

Then open `config/statamic/members.php` to make any changes. Here you can modify the route URLs used for the form pages, enable/disable any form pages, and control which fields are allowed to be submitted through the edit form.

### Customising the view templates

The default view templates have been built with the [Starters Creek](https://statamic.com/starter-kits/statamic/starters-creek) starter kit, which uses Tailwind CSS. You'll almost definitely want to customise these to match your site's design. To do that publish the view templates:

```bash
php please vendor:publish --tag=statamic-members-views
```

And then open `resources/views/vendor/statamic-members/web/*.antlers.html` to customise the templates.

### Customising the welcome email

You can customise the welcome email text by publishing the translation files:

```bash
php please vendor:publish --tag=statamic-members-translations
```

And then opening `lang/vendor/statamic-members/en/messages.php` to customise the text.

### Customising the control panel labels

If you'd like to rename the control panel section and other references to "members" create a new JSON file at `resources/lang/en.json` and add the strings you'd like to change. For example:

```json
{
    "Member": "Client",
    "Members": "Clients",
    "Create Member": "Create Client",
    "Member Information": "Client Information"
}
```

### Control Panel Permissions

To give control panel users access to the members section you will need to grant them the appropriate permissions (super admins always have access to everything). You can either do this through the control panel's permissions editor, or in the `resources/users/roles.yaml` file directly:

```yaml
role:
  title: Role
  permissions:
    - 'view members'
    - 'edit members'
    - 'create members'
```

Changing member passwords and deleting members is currently restricted to users with the `change passwords` and `delete users` permissions.

## Implementation

Members allows you to restrict access to your content in any way you like and does not impose any particular rules or structure. You can use the `{{ member }}` and `{{ not_member }}` tags to control what content is restricted to members and how. Below are some common approaches:

### Restrict an entire area of the site based on a URL prefix

Adding the following line to the top of your `resources/views/layout.antlers.html` file will restrict access to everything under `/members-area` and redirect non-members to the login page:

```antlers
{{ not_member:redirect when="{ url | starts_with:/members-area }" }}
```

When the `when` parameter is present the tag will only operate if the value is truthy. If it’s falsy your template will behave as if the tag wasn’t there at all, permitting all access.

You can specify a different redirect location and response code with the `to` and `response` parameters.

### Restrict individual pages based on an entry field

Adding the following line to the top of your `resources/views/pages/show.antlers.html` file will restrict access to all pages that have a `protected` toggle field set to `true` and abort the request for non-members:

```antlers
{{ not_member:abort :when="protected" }}
```

You can specify a different abort response code with the `response` parameter.

### Restrict sections of a page

You can wrap blocks of content in member tags to restrict just those sections to members or non-members:

```antlers
{{ member }}
    <p>This is only visible to members</p>
{{ /member }}

{{ not_member }}
    <p>This is only visible to non-members</p>
{{ /not_member }}
```

### Specify additional conditions

The member tags also support these parameters that allow you to specify additional conditions for your content:

* **has:field (string):** Content is only visible to members that have the specified field value (see below)
* **in (string):** Content is only visible to members that are in the specified group 
* **is (string):** Content is only visible to members that have the specified role 
* **can (string):** Content is only visible to members that have the specified permission 

You can check for the presence of specific values within the user record using the `has:field` parameter. For example if you had a `plan` field and wanted to limit content to users on the **Plus** plan you could do this:

```antlers
{{ member has:plan="plus" }}
    <p>This is only visible to plus members</p>
{{ /member }}
```

### Use member tags in `if` statements

If you need to combine the member authorization with other checks you can use the member tags within an `if` statement:

```antlers
{{ if { member has:plan="plus" } && (now|format:m-d) == "01-01" }}
    <p>Happy New Year to Plus members!</p>
{{ /if }}
```

**Warning:** Don't use the `when` parameter inside an `if` statement, unexpected things will happen! Seperate that condition out into the `if` itself.

## Navigation Links

These tags are avaliable for linking to the form pages:

* `{{ member:register_url }}`
* `{{ member:login_url }}`
* `{{ member:forgot_url }}`
* `{{ member:edit_url }}`
* `{{ member:password_url }}`

There's an [example header template](examples/_header.antlers.html) that shows how you might implement these in your site.

<!-- statamic:hide -->

## Licencing

Members is a paid Statamic addon. You will need to purchase a license via the [Statamic Marketplace](https://statamic.com/addons/jacksleight/members) to use it in production.

<!-- /statamic:hide -->
