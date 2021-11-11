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
php please vendor:publish --tag=statamic-memberbox-views
```

And then open `resources/views/vendor/statamic-memberbox/web/*.antlers.html` to customise the templates.

---

## Profile form fields

Only fields listed in the `statamic.memberbox.profile_fields` config option can be submitted through the profile form. If you add additional fields to that form you'll need to add them to the list. To do that open `config/statamic/memberbox.php` and add your fields:

```php
'profile_fields' => [
    'name',
    'email',
    'nickname',
    // ...
],
```

---

## Form page URLs

You can change the URLs used for the form pages by updating the `statamic.memberbox.routes` config option. You can also disable form page entirely by setting their values to `null`:

```php
'routes' => [
    'login'    => '/login',
    'register' => null,
    // ...
],
```

---

## Invitation email text

You can customise the welcome email text by publishing the translation files:

```bash
php please vendor:publish --tag=statamic-memberbox-translations
```

And then opening `lang/vendor/statamic-memberbox/en/messages.php` to customise the text.

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

Additional strings can be customised in the `lang/vendor/statamic-memberbox/en/messages.php` file.