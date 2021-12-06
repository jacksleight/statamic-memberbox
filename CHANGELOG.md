# Changelog

## 0.4.5 (2021-12-06)

- [new] Ability to specify the invitation email from address and name

## 0.4.4 (2021-11-22)

- [fix] Use full class names instead of aliases

## 0.4.3 (2021-11-19)

- [fix] Support file uploads through profile form

## 0.4.2 (2021-11-11)

- [break] A couple of planned changes that were overlooked in 0.4.0

## 0.4.1 (2021-11-10)

- Move members nav item into users section

## 0.4.0 (2021-11-10)

- [break] 💥 **Everything:** This addon has been significantly reworked and also renamed. Update instructions:
    1. Update `composer.json` to `"jacksleight/statamic-memberbox": "0.4.0",`
    2. Run `composer update`
    3. Republish the config, views and translations if you've published them
    4. Check the new documentation for updated configuration and implemetation guides

## 0.3.0 (2021-10-29)

- [new] A members widget for the dashboard
- [fix] Match all roles/groups when using Eloquent user driver

## 0.2.3 (2021-10-29)

- [fix] Add support for the Eloquent user driver

## 0.2.2 (2021-10-28)

- [break] The `fillable` config option has been renamed to `edit_fillable` 

## 0.2.1 (2021-10-27)

- [fix] Parse all member strings through translator
- Removed success parameter from default login form 
- Removed success parameter from default reset form 

## 0.2.0 (2021-10-27)

- [break] The `route` and `enable_*` config options have been replaced with a single `routes` array, allowing more control over URLs and which forms are enabled
- Role translations moved into a seperate file
- Removed success parameter from default activation form 

## 0.1.0 (2021-10-26)

- Initial release
