---
title: Tags Reference
nav_order: 6
---

# Tags Reference
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

## Content restriction tags

### `{% raw %}{{ member }} ... {{ /member }}{% endraw %}` <br /> `{% raw %}{{ not_member }} ... {{ /not_member }}{% endraw %}`

Display the content if the curent user is or is not a member.

### `{% raw %}{{ member:redirect }}{% endraw %}` <br /> `{% raw %}{{ not_member:redirect }}{% endraw %}`

Redirect if the curent user is or is not a member.

* **to: (string):** The URL to redriect to (default is the login page URL)
* **response: (string):** The response code (default is 302)

### `{% raw %}{{ member:abort }}{% endraw %}` <br /> `{% raw %}{{ not_member:abort }}{% endraw %}`

Abort if the curent user is or is not a member.

* **response: (string):** The response code (default is 403)

### Shared parameters

All content restriction tags support these shared parameters:

* **has:[field] (string):** Only applies to members with/without the specified field value
* **in (string):** Only applies to members with/without the specified group
* **is (string):** Only applies to members with/without the specified role
* **can (string):** Only applies to members with/without the specified permission
* **when (any):** Only operates if the value is truthy, if falsy your template will behave as if the tag wasn’t there at all

---

## Form page URL tags

### `{% raw %}{{ member:register_url }}{% endraw %}`

Returns the register page URL.

### `{% raw %}{{ member:login_url }}{% endraw %}`

Returns the login page URL.

### `{% raw %}{{ member:forgot_url }}{% endraw %}`

Returns the forgot page URL.

### `{% raw %}{{ member:edit_url }}{% endraw %}`

Returns the edit page URL.

### `{% raw %}{{ member:password_url }}{% endraw %}`

Returns the password page URL.