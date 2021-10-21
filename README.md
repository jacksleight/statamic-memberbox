<!-- statamic:hide -->

![Statamic](https://flat.badgen.net/badge/Statamic/3.2+/FF269E)
![Packagist version](https://flat.badgen.net/packagist/v/jacksleight/members)
![License](https://flat.badgen.net/github/license/jacksleight/members)

# Members 

<!-- /statamic:hide -->

This Statamic addon builds upon Statamic’s existing user management and user form tags to simplify the process of creating a members area or member restricted content in your site.

> **Important:** This addon uses Statamic’s multi-user features, which are Pro only. Therefore this addon will only work with the Pro edition.

## Main Features

* A dedicated members section in the control panel that:
	* Only lists member users, and allows you to search them
	* Allows you to add member users through a simplified user wizard
	* Allows you to send member specific activation emails that link to a frontend form
* Fully functional implementations of all built-in user forms:
	* Register
	* Login
	* Forgot password
	* Reset password
* Plus these additional user forms:
	* Activate account
	* Edit account
* A `{{ members }}` tag that allows you to control what content is restricted to members, and direct users to login when necessary

### Who’s a Member?

This addon defines a member as any user who has the roles and groups listed in the `statamic.users.new_user_roles` and `statamic.users.new_user_groups` config variables, as these are the roles and groups Statamic assigns to users who register themselves.

## Installation

You can search for this addon in the `Tools > Addons` section of the Statamic control panel and click **install**, or run the following command from your project root:

```bash
composer require jacksleight/members
```

## Configuration


