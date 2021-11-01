---
title: Configuration
nav_order: 3
---

# Configuration
{:.no_toc}

<details open markdown="block">
  <summary>
      Table of contents
  </summary>
  {: .text-delta }
* TOC
{:toc}
</details>

---

## First steps

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

---

## Customising the view templates

The default view templates have been built with the [Starters Creek](https://statamic.com/starter-kits/statamic/starters-creek) starter kit, which uses Tailwind CSS. You'll almost definitely want to customise these to match your site's design. To do that publish the view templates:

```bash
php please vendor:publish --tag=statamic-members-views
```

And then open `resources/views/vendor/statamic-members/web/*.antlers.html` to customise the templates.

---

## Customising the welcome email

You can customise the welcome email text by publishing the translation files:

```bash
php please vendor:publish --tag=statamic-members-translations
```

And then opening `lang/vendor/statamic-members/en/messages.php` to customise the text.

---

## Customising the control panel labels

If you'd like to rename the control panel section and other references to "members" create a new JSON file at `resources/lang/en.json` and add the strings you'd like to change. For example:

```json
{
    "Back to Members": "Back to Clients",
    "Create Member": "Create Client",
    "Member Created": "Client Created",
    "Member Information": "Client Information",
    "Member": "Client",
    "Members": "Clients"
}
```

---

## Adding control panel permissions

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

---

## Using with the Eloquent user driver

If you're using the Eloquent user driver you need to ensure the **roles** and **groups** relationships are defined on your user model. For example:

```php
// /app/Models/User.php
class User extends Authenticatable
{
    // ...
    
    public function roles()
    {
        return $this->hasMany(RoleUser::class);
    }

    public function groups()
    {
        return $this->hasMany(GroupUser::class);
    }
}

// /app/Models/GroupUser.php
class GroupUser extends Model
{
    protected $table = 'group_user';
}

// /app/Models/RoleUser.php
class RoleUser extends Model
{
    protected $table = 'role_user';
}
```