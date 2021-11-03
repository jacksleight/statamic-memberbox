---
title: Customisation
nav_order: 5
---

# Customisation
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

## Form page templates

The default view templates have been built with the [Starters Creek](https://statamic.com/starter-kits/statamic/starters-creek) starter kit, which uses Tailwind CSS. To customise these to match your site's design publish the view templates:

```bash
php please vendor:publish --tag=statamic-members-views
```

And then open `resources/views/vendor/statamic-members/web/*.antlers.html` to customise the templates.

---

## Edit form fields

Only fields listed in the `statamic.members.edit_fillable` config option can be submitted through the edit form. If you add additional fields to that form you'll need to add them to the list. To do that open `config/statamic/members.php` and add your fields:

```php
'edit_fillable' => [
    'name',
    'email',
    'nickname',
    // ...
],
```

---

## Form page URLs

You can change the URLs used for the form pages by updating the `statamic.members.routes` config option. You can also disable form page entirely by setting their values to `false`:

```php
'routes' => [
    'login'    => '/login',
    'register' => false,
    // ...
],
```

---

## Invitation email text

You can customise the welcome email text by publishing the translation files:

```bash
php please vendor:publish --tag=statamic-members-translations
```

And then opening `lang/vendor/statamic-members/en/messages.php` to customise the text.

---

## Control panel labels

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

Additional strings can be customised in the `lang/vendor/statamic-members/en/messages.php` file.