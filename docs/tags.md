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

## Member tag

### `{% raw %}{{ member }}{% endraw %}`

Check if the current user is a member.

* **has:[field] (string):** Only matches members with the specified field value

---

## Form tags

### `{% raw %}{{ member:activate_form }} ... {{ /member:activate_form }}{% endraw %}`

Render the activate form tag.

* **redirect (string):** URL to redirect on success
* **error_redirect (string):** URL to redirect on error

### `{% raw %}{{ member:edit_form }} ... {{ /member:edit_form }}{% endraw %}`

Render the edit form tag.

* **redirect (string):** URL to redirect on success

### `{% raw %}{{ member:password_form }} ... {{ /member:password_form }}{% endraw %}`

Render the password form tag.

* **redirect (string):** URL to redirect on success

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