---
title: Advanced
nav_order: 5
---

# Advanced
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