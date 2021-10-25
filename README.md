<!-- statamic:hide -->

![Statamic](https://flat.badgen.net/badge/Statamic/3.2+/FF269E)
![Packagist version](https://flat.badgen.net/packagist/v/jacksleight/statamic-members)
![License](https://flat.badgen.net/github/license/jacksleight/statamic-members)

# Members 

<!-- /statamic:hide -->

This Statamic addon builds upon Statamic’s existing user management and user form tags to simplify the process of creating a members area or member restricted content in your site.

> **Important:** This addon uses Statamic’s multi-user features, which are Pro only. Therefore this addon will only work with the Pro edition.

- [Features](#features)
  * [Who’s a Member?](#who-s-a-member-)
- [Installation](#installation)
- [Configuration](#configuration)
  * [Customising the view templates](#customising-the-view-templates)
  * [Customising the welcome email](#customising-the-welcome-email)
  * [Permissions](#permissions)
- [Restricting Content](#restricting-content)
  * [Restrict a section of a page to members only](#restrict-a-section-of-a-page-to-members-only)
  * [Restrict a section of a page to non-members only](#restrict-a-section-of-a-page-to-non-members-only)
  * [Restrict an entire page to members only and redirect non-members to the login page](#restrict-an-entire-page-to-members-only-and-redirect-non-members-to-the-login-page)
  * [Only restrict certain pages based on a condition](#only-restrict-certain-pages-based-on-a-condition)
  * [Specifying additional restrictions](#specifying-additional-restrictions)
- [Form Page URLs](#form-page-urls)
- [Licencing](#licencing)

## Features

* A dedicated members section in the control panel that:
	* Only lists member users and allows you to search them
	* Uses seperate view, create and edit member permissions
	* Allows you to create members through a simplified user wizard
	* Allows you to send member specific welcome emails that link to a frontend activation form
* Implementations of all built-in user forms:
	* Register
	* Login
	* Forgot password
	* Reset password
* Plus these additional user forms:
	* Activate account
	* Edit account
	* Update password
* A Members tag that makes it super simple to control what content is restricted to which members and how
* A handful of utility tags

### Who’s a Member?

This addon defines a member as any user who has the roles and groups listed in the `statamic.users.new_user_roles` and `statamic.users.new_user_groups` config variables, as these are the roles and groups Statamic assigns to users who register themselves.

## Installation

You can search for this addon in the `Tools > Addons` section of the Statamic control panel and click **install**, or run the following command from your project root:

```bash
composer require jacksleight/statamic-members
```

## Configuration

The first thing you'll need to do is set Statamic's new user settings to the roles/groups you want member users to have. To do this create the appropriate roles/groups and then open `config/statamic/users.php` and update the relevant settings:

```php
// These are just examples!
// You can call your roles/groups whatever you want, and you dont
// have to use both roles *and* groups. For simple setups I would
// recommend just a single group called "members".

'new_user_roles' => [
    'member',
],

'new_user_groups' => [
    'members',
],
```

You can also modify the route prefix used for the form pages, enable/disable the registration, edit and password forms, and control which fields can be edited through the edit form, by publishing the members config:

```bash
php please vendor:publish --tag=statamic-members-config
```

And then opening `config/statamic/members.php` to make any changes.

### Customising the view templates

The default view templates have been built to match the [Starters Creek](https://statamic.com/starter-kits/statamic/starters-creek) starter kit, which uses Tailwind CSS. You'll almost definitely want to customise these to match your site's design. To do that publish the view templates:

```bash
php please vendor:publish --tag=statamic-members-views
```

And then open `resources/views/vendor/statamic-members/web/*.antlers.html` to customise the templates.

### Customising the welcome email

You can customise the welcome email text by publishing the translation files:

```bash
php please vendor:publish --tag=statamic-members-translations
```

And then opening `lang/vendor/statamic-members/*/messages.php` to customise the text.

### Permissions

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

## Restricting Content

To control which content is restricted to members you can use the `{{ members }}` tags. Here are some examples:

### Restrict a section of a page to members only

```antlers
{{ members }}
    <p>This is only visible to members</p>
{{ /members }}
```

### Restrict a section of a page to non-members only

```antlers
{{ members:not }}
    <p>This is only visible to non-members</p>
{{ /members:not }}
```

### Restrict an entire page to members only and redirect non-members to the login page

```antlers
{{ members:page }}

<p>This is only visible to members, non-members will be redirected</p>
```

### Only restrict certain pages based on a condition

The `if` parameter accepts any value. If it is present and the value is falsy restrictions will not be enforced. 

```antlers
{{ members:page if="{ protected }" }}
```

In this example we would have added a `protected` toggle field to the page blueprint, allowing certain pages to be protected but not all.

### Specifying additional restrictions

The members tags also support a number of additional parameters that give you granualr control over exactly what is restricted to who. These are:

* **in (string):** Content is only visible to members that are in the specified group 
* **is (string):** Content is only visible to members that have the specified role 
* **can (string):** Content is only visible to members that have the specified permission 

You can also check for the presence of specific values within the user record using the `has:*` parameter. For example if you had a `plan` field and wanted to limit content to users on the `gold` plan you could do this:

```antlers
{{ members has:plan="gold" }}
    <p>This is only visible to gold members</p>
{{ /members }}
```

## Form Page URLs

Members provides a set of utility tags for linking to the form pages, these are:

* `{{ members_user:register_url }}`
* `{{ members_user:login_url }}`
* `{{ members_user:forgot_url }}`
* `{{ members_user:edit_url }}`
* `{{ members_user:password_url }}`

There's an [example header template](examples/_header.antlers.html) that shows how you might implement these in your site.

<!-- statamic:hide -->

## Licencing

Members is a paid Statamic addon. You will need to purchase a license via the [Statamic Marketplace](https://statamic.com/addons/jacksleight/members) to use it in production.

<!-- /statamic:hide -->