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

It's up to you exactly how you want to implement the Members features on your site, below is an overview of what's avaliable and examples of how they can be implemented.

---

## Linking to the form pages from your templates

A number of tags are avaliable for linking to the form pages, check the [tags reference](tags.html#form-page-url-tags) for a full list. Here's an example header template that shows how you might implement these in your site:

```html
{% raw %}<header>
    <div class="max-w-5xl mx-auto px-3 py-3 flex items-center h-16">
        <a href="/" class="font-bold text-xl hover:text-hot-pink mr-auto">{{ settings:site_name }}</a>
        {{ if logged_in }}
            <a href="{{ member:edit_url }}" class="ml-5 text-l hover:text-hot-pink">{{ user }}{{ name }}{{ /user }}</a>
            <a href="{{ user:logout_url }}" class="ml-5 text-l hover:text-hot-pink">Log out</a>
        {{ /if }}
        {{ if ! logged_in }}
            <a href="{{ member:register_url }}" class="ml-5 text-l hover:text-hot-pink">Register</a>
            <a href="{{ member:login_url }}" class="ml-5 text-l hover:text-hot-pink">Log in</a>
        {{ /if }}
    </div>
    <div class="w-full border-b-2 border-black squiggle"></div>
</header>{% endraw %}
```

---

## Restricting access to content

Members allows you to restrict access to your content in any way you like and does not impose any particular rules or structure. 

Below are some common approaches, check the [tags reference](tags.html#content-restriction-tags) for further details.

### Restrict an entire area of the site based on a URL prefix

Adding the following to the top of your `resources/views/layout.antlers.html` file will restrict access to everything under `/members-area` and redirect non-members to the login page:

```html
{% raw %}{{ if { url | starts_with:/members-area } && ! { member } }}
    {{ redirect to="{ member:login_url }?redirect={ url }" }}
{{ /if }}{% endraw %}
```

### Restrict individual pages based on an entry field

Adding the following line to the top of your `resources/views/pages/show.antlers.html` file will restrict access to all page entries that have a `protected` toggle field set to `true` and redirect non-members to the login page:

```html
{% raw %}{{ if secret && ! { member } }}
    {{ redirect to="{ member:login_url }?redirect={ url }" }}
{{ /if }}{% endraw %}
```

### Restrict sections of a page

You can wrap blocks of content in member tags to restrict just those sections to members or non-members:

```html
{% raw %}{{ if { member } }}
    <p>This is only visible to members</p>
{{ /if }}

{{ if ! { member } }}
    <p>This is only visible to non-members</p>
{{ /if }}{% endraw %}
```

### Restrict based on a user field value

You can check for the presence of specific values within the user data using the `has:[field]` parameter. For example if you had a `plan` field and wanted to limit content to users on the **plus** plan you could do this:

```html
{% raw %}{{ if { member has:plan="plus" } }}
    <p>This is only visible to plus members</p>
{{ /if }}{% endraw %}
```