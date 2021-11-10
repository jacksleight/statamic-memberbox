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

### `{% raw %}{{ mb:member }}{% endraw %}`

Check if the current user is a member.

* **has:[field] (string):** Only matches members with the specified field value

---

## User form tags

### `{% raw %}{{ mb:user:activate_form }} ... {{ /mb:user:activate_form }}{% endraw %}`

Render the activate form tag.

* **redirect (string):** URL to redirect on success
* **error_redirect (string):** URL to redirect on error

### `{% raw %}{{ mb:user:profile_form }} ... {{ /mb:user:profile_form }}{% endraw %}`

Render the profile form tag.

* **redirect (string):** URL to redirect on success

### `{% raw %}{{ mb:user:change_password_form }} ... {{ /mb:user:change_password_form }}{% endraw %}`

Render the change password form tag.

* **redirect (string):** URL to redirect on success

---

## User form page URL tags

### `{% raw %}{{ mb:user:register_url }}{% endraw %}`

Returns the register page URL.

### `{% raw %}{{ mb:user:login_url }}{% endraw %}`

Returns the login page URL.

### `{% raw %}{{ mb:user:profile_url }}{% endraw %}`

Returns the profile page URL.

### `{% raw %}{{ mb:user:forgot_password_url }}{% endraw %}`

Returns the forgot password page URL.

### `{% raw %}{{ mb:user:reset_password_url }}{% endraw %}`

Returns the reset password page URL.

### `{% raw %}{{ mb:user:change_password_url }}{% endraw %}`

Returns the change password page URL.