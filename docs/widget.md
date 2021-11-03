---
title: Widget
nav_order: 7
---

# Widget

Members provides a widget that you can add to the control panel dashboard. By default this behaves a lot like the collection widget, displaying a paginated members list with a create member button:

```php
[
    'type'     => 'members',
    'width'    => 50,
],
```

The widget has a number of options that can be used to customise it, for example you could create a list of the ten newest members like this:

```php
[
    'type'     => 'members',
    'title'    => 'New Members',
    'sort'     => 'created_at:desc', // see note below!
    'paginate' => false,
    'create'   => false,
    'limit'    => 10,
    'width'    => 50,
],
```

> **Note:** The `created_at` and `updated_at` dates are only stored by the Eloquent user driver, that data is not avaliable with the file user driver.