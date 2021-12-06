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