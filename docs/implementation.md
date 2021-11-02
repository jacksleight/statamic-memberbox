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

These tags are avaliable for linking to the form pages:

* `{% raw %}{{ member:register_url }}{% endraw %}`
* `{% raw %}{{ member:login_url }}{% endraw %}`
* `{% raw %}{{ member:forgot_url }}{% endraw %}`
* `{% raw %}{{ member:edit_url }}{% endraw %}`
* `{% raw %}{{ member:password_url }}{% endraw %}`

Here's an example header template that shows how you might implement these in your site:

```html
{% raw %}<header>
    <div class="max-w-5xl mx-auto px-3 py-3 flex items-center h-16">
        <a href="/" class="font-bold text-xl hover:text-hot-pink mr-auto">{{ settings:site_name }}</a>
        {{ if logged_in }}
            {{ member }}
                <a href="{{ member:edit_url }}" class="ml-5 text-l hover:text-hot-pink">{{ user }}{{ name }}{{ /user }}</a>
            {{ /member }}
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

## Customising the form page templates

The default view templates have been built with the [Starters Creek](https://statamic.com/starter-kits/statamic/starters-creek) starter kit, which uses Tailwind CSS. To customise these to match your site's design publish the view templates:

```bash
php please vendor:publish --tag=statamic-members-views
```

And then open `resources/views/vendor/statamic-members/web/*.antlers.html` to customise the templates.

---

## Restricting access to content

Members allows you to restrict access to your content in any way you like and does not impose any particular rules or structure. You can use the `{% raw %}{{ member }}{% endraw %}` and `{% raw %}{{ not_member }}{% endraw %}` tags to control what content is restricted to members and how. Below are some common approaches.

> **Note:** The member tags are just syntactic sugar, to make it super simple to restrict your content to members. You can acheive the same results with the [built-in user tags](https://statamic.dev/reference/tags) if you prefer.

### Restrict an entire area of the site based on a URL prefix

Adding the following line to the top of your `resources/views/layout.antlers.html` file will restrict access to everything under `/members-area` and redirect non-members to the login page:

```html
{% raw %}{{ not_member:redirect when="{ url | starts_with:/members-area }" }}{% endraw %}
```

When the `when` parameter is present the tag will only operate if the value is truthy. If it’s falsy your template will behave as if the tag wasn’t there at all, permitting all access.

You can specify a different redirect location and response code with the `to` and `response` parameters.

### Restrict individual pages based on an entry field

Adding the following line to the top of your `resources/views/pages/show.antlers.html` file will restrict access to all page entries that have a `protected` toggle field set to `true` and abort the request for non-members:

```html
{% raw %}{{ not_member:abort :when="protected" }}{% endraw %}
```

You can specify a different abort response code with the `response` parameter.

### Restrict sections of a page

You can wrap blocks of content in member tags to restrict just those sections to members or non-members:

```html
{% raw %}{{ member }}
    <p>This is only visible to members</p>
{{ /member }}

{{ not_member }}
    <p>This is only visible to non-members</p>
{{ /not_member }}{% endraw %}
```

### Specify additional conditions

The member tags also support these parameters that allow you to specify additional conditions for your content:

* **has:field (string):** Content is only visible to members that have the specified field value (see below)
* **in (string):** Content is only visible to members that are in the specified group 
* **is (string):** Content is only visible to members that have the specified role 
* **can (string):** Content is only visible to members that have the specified permission 

You can check for the presence of specific values within the user record using the `has:field` parameter. For example if you had a `plan` field and wanted to limit content to users on the **Plus** plan you could do this:

```html
{% raw %}{{ member has:plan="plus" }}
    <p>This is only visible to plus members</p>
{{ /member }}{% endraw %}
```

### Use member tags in `if` statements

If you need to combine the member authorization with other checks you can use the member tags within an `if` statement:

```html
{% raw %}{{ if { member has:plan="plus" } && (now|format:m-d) == "01-01" }}
    <p>Happy New Year to Plus members!</p>
{{ /if }}{% endraw %}
```

> **Warning:** Don't use the `when` parameter inside an `if` statement, unexpected things will happen! Seperate that condition out into the `if` itself.
