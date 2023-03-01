---
title: Implementation
order: 4
---

# Implementation

It's up to you exactly how you implement the Memberbox features on your site. If you want to get up and running quickly you can use the routes and templates Memberbox provides, or you can implement those yourself and just use the tags. When it comes to protecting front-end content Statamic provides everything you need already.

Check the [customisation](customisation.html) documentation for details on customising the profile form fields, invitation emails and control panel.

[TOC]

---

## Using the automatic account and directory pages

Memberbox can automatically create account and directory routes/pages for you, and comes with starter templates you can customise to match your site design. To enable the automatic account pages set the `statamic.memberbox.enable_account` config option to true (enabled by default):

```
'enable_account' => true,
```

To enable the automatic directory pages set the `statamic.memberbox.enable_directory` config option to true and uncomment the routes:

```
'enable_directory' => true,

'routes' => [
    // ...
    'index' => '/directory',
    'show'  => '/directory/{user}',
],
```

:::warning
Enabling the user directory will expose user data publicly. Make sure your templates only output the data you want to be public!
:::

### Editing the page templates

The starter templates have been built with the [Starters Creek](https://statamic.com/starter-kits/statamic/starters-creek) kit, which uses Tailwind CSS. To customise these to match your site's design publish the view templates:

```bash
php please vendor:publish --tag=statamic-memberbox-views
```

And then open `resources/views/vendor/statamic-memberbox/web/*.antlers.html` to customise the templates.

### Setting the page titles

The starter templates use Antlers front matter to set a title variable which you can access from your layout templates. You don't have to use this method, but if you do you can output the variable in your layout using the `view:title` variable:

```html
<title>{{ title or view:title }}</title>
```

---

## Using Statamic entries for your account and directory pages

If you would prefer to use pages managed through Statamic as your account and directory pages you should switch the `enable_account` and `enable_directory` options off, and then populate the `routes` array with the URLs of your Statamic entries. Setting these will ensure that the URL tags and activation email links work as expected.

---

## Linking to the pages from your templates

Memberbox provides a set of page URL tags for linking to the pages, check the [tags reference](tags.html#user-form-page-url-tags) for a full list. Here's an example header template that shows how you might implement these in your site:

```html
<header>
    <div>
        <a href="/">{{ settings:site_name }}</a>
        {{ if logged_in }}
            <a href="{{ mb:user:profile_url }}">{{ current_user:name }}</a>
            <a href="{{ user:logout_url }}">Log out</a>
        {{ else }}
            <a href="{{ mb:user:register_url }}">Register</a>
            <a href="{{ mb:user:login_url }}">Log in</a>
        {{ /if }}
    </div>
</header>
```

---

## Restricting access to logged in users

Most of the time you'll probably just want to restrict access to any logged in user, not *just* members. That way your control panel users will also have access to that content as well. There are many ways to do that and below are some common approaches to get you started. For further details [check](https://statamic.dev/protecting-content) [the](https://statamic.dev/reference/tags) [docs](https://statamic.dev/reference/variables).

### Protect entries or collections using a protection scheme

The best way to protect individual entries or entire collections is to use a protection scheme. Statamic comes with a protection scheme called `logged_in` which will restrict content to logged in users and optionally redirect logged out users to the login page. To implement this just add a `protect` key to your entry:

```yaml
protect: logged_in
```

Or inject it in your collecton configuration:

```yaml
inject:
  protect: logged_in
```

Check Statamic's [protection](https://statamic.dev/protecting-content#protecting-an-entry) documentation for full details.

### Protect an entire area of the site based on a URL prefix

Adding the following to the top of your `resources/views/layout.antlers.html` file will restrict access to everything under `/members-area` and redirect logged out users to the login page:

```html
{{ if ! logged_in && url | starts_with('/members-area') }}
    {{ redirect to="{ mb:user:login_url append_redirect='true' }" }}
{{ /if }}
```

Check Statamic's [tags](https://statamic.dev/reference/tags) and [variables](https://statamic.dev/reference/variables) documentation for full details.

### Protect individual pages based on an entry field

Adding the following to the top of your `resources/views/pages/show.antlers.html` file will restrict access to all page entries that have a `secret` toggle field set to `true` and redirect logged out users to the login page:

```html
{{ if ! logged_in && secret }}
    {{ redirect to="{ mb:user:login_url append_redirect='true' }" }}
{{ /if }}
```

### Protect sections of a page

You can wrap blocks of content to restrict just those sections to logged in or logged out users:

```html
{{ if logged_in }}
    <p>This is only visible to logged in users</p>
{{ /if }}
{{ if ! logged_in }}
    <p>This is only visible to logged out users</p>
{{ /if }}
```

### Protect based on a user field value

You can check values within the user data. For example if you had a `plan` field and wanted to limit content to users on the **plus** plan you could do this:

```html
{{ if logged_in && (current_user:plan == "plus") }}
    <p>This is only visible to plus users</p>
{{ /if }}
```
