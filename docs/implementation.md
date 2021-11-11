---
title: Implementation
nav_order: 4
---

# Implementation
{:.no_toc}

<details open markdown="block">
  <summary>
      Table of contents
  </summary>
  {: .text-delta }
* TOC
{:toc}
</details>

It's up to you exactly how you want to implement the Memberbox features on your site. When it comes to restricting content Statamic provides almost everying you might need already.

---

## Linking to the form pages from your templates

A set of form page URL tags are avaliable for linking to the form pages, check the [tags reference](tags.html#form-page-url-tags) for a full list. Here's an example header template that shows how you might implement these in your site:

```html
{% raw %}<header>
    <div class="max-w-5xl mx-auto px-3 py-3 flex items-center h-16">
        <a href="/" class="font-bold text-xl hover:text-hot-pink mr-auto">{{ settings:site_name }}</a>
        {{ if logged_in }}
            <a href="{{ mb:user:profile_url }}" class="ml-5 text-l hover:text-hot-pink">{{ user }}{{ name }}{{ /user }}</a>
            <a href="{{ user:logout_url }}" class="ml-5 text-l hover:text-hot-pink">Log out</a>
        {{ else }}
            <a href="{{ mb:user:register_url }}" class="ml-5 text-l hover:text-hot-pink">Register</a>
            <a href="{{ mb:user:login_url }}" class="ml-5 text-l hover:text-hot-pink">Log in</a>
        {{ /if }}
    </div>
    <div class="w-full border-b-2 border-black squiggle"></div>
</header>{% endraw %}
```

---

## Restricting access to logged in users

Most of the time you'll probably just want to restrict access to any logged in user, not *just* members. That way your control panel users will also have access to that content. There are many ways to do that and below are some common approaches to get you started, but for full details [check](https://statamic.dev/protecting-content) [the](https://statamic.dev/reference/tags) [docs](https://statamic.dev/reference/variables).

### Restrict entries or collections using a protection scheme

The best way to protect individual entries or entire collections is to use a protection scheme. Statamic comes with a protection driver called `auth` which will restrict content to logged in users and optionally redirect logged out users to the login page. To implement this just add a `protect` key to your entry:

```yaml
protect: logged_in
```

Or inject it in your collecton configuration:

```yaml
inject:
  protect: logged_in
```

Check Statamic's [protection schemes documentation](https://statamic.dev/protecting-content#protecting-an-entry) for full details.

### Restrict an entire area of the site based on a URL prefix

Adding the following to the top of your `resources/views/layout.antlers.html` file will restrict access to everything under `/members-area` and redirect logged out users to the login page:

```html
{% raw %}{{ if ! logged_in && url | starts_with:/members-area }}
    {{ redirect to="{ mb:user:login_url append_redirect='true' }" }}
{{ /if }}{% endraw %}
```

Check Statamic's [tags](https://statamic.dev/reference/tags) and [variables](https://statamic.dev/reference/variables) for full details.

### Restrict individual pages based on an entry field

Adding the following to the top of your `resources/views/pages/show.antlers.html` file will restrict access to all page entries that have a `secret` toggle field set to `true` and redirect logged out users to the login page:

```html
{% raw %}{{ if ! logged_in && secret }}
    {{ redirect to="{ mb:user:login_url append_redirect='true' }" }}
{{ /if }}{% endraw %}
```

### Restrict sections of a page

You can wrap blocks of content to restrict just those sections to logged in or logged out users:

```html
{% raw %}{{ if logged_in }}
    <p>This is only visible to logged in users</p>
{{ /if }}
{{ if ! logged_in }}
    <p>This is only visible to logged out users</p>
{{ /if }}{% endraw %}
```

### Restrict based on a user field value

You can check for the presence of specific values within the user data using Memberbox's `{% raw %}{{ mb:user:has }}{% endraw %}` tag. For example if you had a `plan` field and wanted to limit content to users on the **plus** plan you could do this:

```html
{% raw %}{{ if logged_in && { mb:user:has plan="plus" } }}
    <p>This is only visible to plus users</p>
{{ /if }}{% endraw %}
```

---

## Restricting access to *just* members

If you really want to restrict content to *just* [members](configuration.html#whos-a-member) and no other logged in users you can use Memberbox's `{% raw %}{{ mb:user:member }}{% endraw %}` tag:

```html
{% raw %}{{ if logged_in && { mb:user:member } }}
    <p>This is only visible to members and no one else</p>
{{ /if }}{% endraw %}
```

But bear in mind that doing this might prevent control panel users viewing the content as well, depending on how your roles and groups are configured.