# Changelog

## 0.4.0 ()

- [break] 💥 **Everything:** This addon has been significantly reworked and also renamed. I don't *think* this will affect anyone, but if it does sorry for any inconvienence it causes. Update instructions:
    1. Update `composer.json` to `"jacksleight/statamic-memberbox": "0.4.0",`
    2. Run `composer update`
    3. Check the new documentation for updated configuration and implemetation guides

- [new] Added a `mb_member` protection scheme

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
