<!-- statamic:hide -->

![Statamic](https://flat.badgen.net/badge/Statamic/3.2+/FF269E)
![Packagist version](https://flat.badgen.net/packagist/v/jacksleight/statamic-members)
![License](https://flat.badgen.net/github/license/jacksleight/statamic-members)

# Members 

<!-- /statamic:hide -->

This Statamic addon builds upon Statamic’s existing user management and user form tags to simplify the process of creating a members area or member restricted content in your site.

> **Important:** This addon uses Statamic’s multi-user features, which are Pro only. Therefore this addon will only work with the Pro edition.

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
* A `{{ members }}` tag that makes it super simple to control what content is restricted to which members and how
* A handful of utility helpers and tags

### Who’s a Member?

This addon defines a member as any user who has the roles and groups listed in the `statamic.users.new_user_roles` and `statamic.users.new_user_groups` config variables, as these are the roles and groups Statamic assigns to users who register themselves.

## Installation

You can search for this addon in the `Tools > Addons` section of the Statamic control panel and click **install**, or run the following command from your project root:

```bash
composer require jacksleight/statamic-members
```

## Configuration

The first thing you need to do is set Statamic's new user settings to the roles/groups you want member users to have. To do this, create the appropriate roles/groups, and then open `config/statamic/users.php` and update the relevant settings:

```php
// These are just examples!
// You can call your roles/groups whatever you want, and you dont have to use both roles *and* groups. For most setups I would recommend just a single group called "members".

'new_user_roles' => [
	'member',
],

'new_user_groups' => [
	'members',
],
```

You can also modify the route prefix used for the form pages, as well as toggle the registration and edit forms on and off, by publishing the Members config.

```bash
php please vendor:publish --tag=statamic-members-config
```

And then opening `config/statamic/members.php` to make any changes.

### Customising the View Templates

The default view templates have been built to match the [Starters Creek](https://statamic.com/starter-kits/statamic/starters-creek) starter kit, which uses Tailwind CSS. You'll probably want to customise these to match your site's design. To do that publish the view templates:

```bash
php please vendor:publish --tag=statamic-members-views
```

And then open `resources/views/vendor/statamic-members/web/*.antlers.html` to customise the templates.

### Customising the Welcome Email

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

<!-- statamic:hide -->

## Licencing

Members is a paid Statamic addon. You will need to purchase a license via the [Statamic Marketplace](https://statamic.com/addons/jacksleight/members) to use it in production.

<!-- /statamic:hide -->