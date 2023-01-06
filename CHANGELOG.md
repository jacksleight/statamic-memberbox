# Changelog

## 1.1.1 (2023-01-06)

* [new] Added Danish translations

## 1.1.0 (2023-01-06)

* [new] Added column selector to members listing
* The `mb:user:change_password_form` tag has been deprecated
* Updated templates and documentation to use new Statamic tags
* Updated templates to use runtime parser syntax
* Include file field example in the profile template

## 1.0.4 (2022-11-28)

* [fix] Profile form values not being processed before save

## 1.0.3 (2022-11-28)

* [fix] Email field now optional in profile form

## 1.0.2 (2022-07-20)

* [new] Add pagination totals to CP listing page
* [fix] CP search returning non-members

## 1.0.1 (2022-07-15)

* [fix] CP listing page error with Statamic 3.3.18+

## 1.0.0 (2022-06-21)

* [new] Ability to export members as either a CSV or JSON file
* [new] Fresh install configuration check and introduction
* [fix] Better message when there's an error during member creation

## 0.5.1 (2022-03-16)

- [new] Statamic 3.3 compatibility

## 0.5.0 (2021-12-14)

- [new] Ability to configure the CP create form fields
- [new] Frontend user directory routes and starter templates
- [new] Added `mb:members` and `mb:member` tags that list and fetch members
- [new] Added `mb_member` query scope
- [new] Added `enable_account` config option to toggle all account routes on/off
- [break] Page titles are now set from the templates instead of the translation files
- Deprecated `mb:user:has` tag
- Deprecated `mb:user:member` tag

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
