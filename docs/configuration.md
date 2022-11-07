---
title: Configuration
order: 3
---

# Configuration

[TOC]

---

## Who’s a Member?

This addon defines a member as any user who has the roles and groups listed in the `statamic.users.new_user_roles` and `statamic.users.new_user_groups` config variables, as these are the roles and groups Statamic assigns to users who register themselves through the user registration form.

## Getting started

### 1. Configure Statamic's new user settings

The first thing you'll need to do is set Statamic's new user settings to the roles/groups you want members to have. You can specify any roles/groups you like, but for a simple setup I would recommend a single group called `members`.

To do this you'll need to create a `members` group. You can either do this through the control panel's groups editor, or in the `resources/users/groups.yaml` file directly:

```yaml
members:
  title: Members
```

Then open `config/statamic/users.php` and update the `new_user_groups` setting:

```php
'new_user_groups' => [
    'members',
],
```

### 2. Publish the Memberbox config

Next you should publish the Memberbox config:

```bash
php please vendor:publish --tag=statamic-memberbox-config
```

Then open `config/statamic/memberbox.php` to make any changes. Check the [customisation](customisation.html) page for further details.

### 3. Grant control panel permissions

To give control panel users access to the members section you will need to grant them the appropriate permissions (super admins always have access to everything). You can either do this through the control panel's permissions editor, or in the `resources/users/roles.yaml` file directly:

```yaml
admin:
  title: Admin
  permissions:
    - 'mb view members'
    - 'mb edit members'
    - 'mb create members'
```

Changing member passwords and deleting members is currently restricted to users with the `change passwords` and `delete users` permissions.

---

## Using the Eloquent user driver?

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