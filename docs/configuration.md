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

## Getting started

### 1. Configure Statamic's new user settings

The first thing you'll need to do is set Statamic's new user settings to the roles/groups you want member users to have. You can specify any roles/groups you like, but for a simple setup I would recommend a single group called `members`.

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

### 2. Publish the members config

Next you should publish the members config:

```bash
php please vendor:publish --tag=statamic-members-config
```

Then open `config/statamic/members.php` to make any changes. Here you can modify the route URLs used for the form pages, enable/disable any form pages, and control which fields are allowed to be submitted through the edit form.

### 3. Add control panel permissions

To give control panel users access to the members section you will need to grant them the appropriate permissions (super admins always have access to everything). You can either do this through the control panel's permissions editor, or in the `resources/users/roles.yaml` file directly:

```yaml
admin:
  title: Admin
  permissions:
    - 'view members'
    - 'edit members'
    - 'create members'
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