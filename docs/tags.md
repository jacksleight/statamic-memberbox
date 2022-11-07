---
title: Tags Reference
order: 6
---

# Tags Reference

[TOC]

---

## Member tags

### `mb:member`

Get the current member or a specific member.

Accepts the same parameters as the [user tag](https://statamic.dev/tags/user-profile), but is restricted to members.

### `mb:members`

Get a list of members.

Accepts the same parameters as the [users tag](https://statamic.dev/tags/users), but is restricted to members.

---

## User form tags

### `mb:user:activate_form`

Render the activate form tag.

* **redirect (string):** URL to redirect on success
* **error_redirect (string):** URL to redirect on error

### `mb:user:profile_form`

Render the profile form tag.

* **redirect (string):** URL to redirect on success
* **files (boolean):** Enable file uploads (`enctype="multipart/form-data"`)

### `mb:user:change_password_form`

Render the change password form tag.

* **redirect (string):** URL to redirect on success

---

## User page URL tags

### `mb:user:register_url`

Returns the register page URL.

### `mb:user:login_url`

Returns the login page URL.

* **append_redirect (bool\|string):** Whether to append a redirect to the URL

### `mb:user:profile_url`

Returns the profile page URL.

### `mb:user:forgot_password_url`

Returns the forgot password page URL.

### `mb:user:reset_password_url`

Returns the reset password page URL.

### `mb:user:change_password_url`

Returns the change password page URL.

### `mb:user:index_url`

Returns the user listing page URL.

### `mb:user:show_url`

Returns the user detail page URL.

* **anything:** All parameters will be parsed to the route