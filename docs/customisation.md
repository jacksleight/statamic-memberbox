---
title: Customisation
order: 5
---

# Customisation

[TOC]

---

## Page URLs

You can change the URLs used for the pages by updating the `statamic.memberbox.routes` config option. You can also disable a specific pages by removing them:

```php
'routes' => [
    'login'    => '/login',
    // 'register' => '/register',
    // ...
],
```

If you want to use something other than the user's ID in the listing show URLs you can update the `mb:user:show_url` tag in the index template and the `mb:member` tag in the show template as follows:

```html
{{ mb:user:show_url :user='handle' }}
```
```html
{{ mb:member field="handle" :value="user" }}
    //...
{{ /mb:member }}
```

---

## Profile form fields

:::warning
If you don't need file upload support you should use Statamic's built-in `user:profile_form` tag instead. Available in Statamic 3.3.61+.
:::

Only fields listed in the `statamic.memberbox.profile_fields` config option can be submitted through the profile form. The fields listed must match the fields in your form. To do that open `config/statamic/memberbox.php` and add your fields:

```php
'profile_fields' => [
    'name',
    'email',
    'nickname',
    // ...
],
```

### Uploading files

You can upload files to user assets fields through the profile form. You'll need to add `files="true"` to the profile form tag, then a `file` input to your template:

```html
<!-- single file (max_files: 1) -->
<input type="file" name="avatar" />

<!-- multiple files -->
<input type="file" name="photos[]" multiple />
```

---

## Invitation email text

You can customise the welcome email text by publishing the translation files:

```bash
php please vendor:publish --tag=statamic-memberbox-translations
```

And then opening `lang/vendor/statamic-memberbox/en/messages.php` to customise the text.

---

## Invitation email from address and name

You can customise who the invitation email comes from by updating the `statamic.memberbox.invitation_from` config option:

```php
'invitation_from' => [
    'address' => 'members@example.com',
    'name' => 'Member Services',
],
```

---

## Control panel create form fields

You can add additional fields to the control panel create user form by adding them to the User blueprint and then updating the `statamic.memberbox.cp_create_fields` config option:

```php
'cp_create_fields' => [
    'name',
    'email',
    'nickname',
    // ...
],
```

Fields will appear in the order they're defined in the User blueprint. The `email` field will always be included. The `password`, `roles` and `groups` fields will always be excluded.

---

## Control panel labels

If you'd like to rename the control panel section and other references to "members" create a new JSON file at `resources/lang/*.json` and add the strings you'd like to change. For example:

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

Additional strings can be customised in the `lang/vendor/statamic-memberbox/en/messages.php` file.