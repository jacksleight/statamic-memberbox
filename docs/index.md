---
title: Introduction
nav_order: 1
---

# Introduction

This Statamic addon provides an out of the box solution for adding a members area or member restricted content to your site, building on Statamic’s existing user management and user form tags. It also provides a dedicated members section in the control panel, allowing you to manage members independently of other users.

> **Important:** This addon uses Statamic’s multi-user features, which are Pro only. Therefore this addon will only work with the Pro edition.

## Features

* A dedicated members section in the control panel that:
	* Only lists member users and allows you to search them
	* Allows you to create members through a simplified user wizard
	* Allows you to send member specific welcome emails that link to a frontend activation form
	* Uses seperate view, create and edit member permissions
* These new member form tags:
	* Activate account
	* Edit account
	* Update password
* Fully-functional implementations of those forms, plus all the [built-in user form tags](https://statamic.dev/reference/tags) (register, login, forgot and reset password)
* Member tags that make it super simple to control what content is restricted to which members and how
* A members widget for the dashboard
* A set of form page URL tags

## Who’s a Member?

This addon defines a member as any user who has the roles and groups listed in the `statamic.users.new_user_roles` and `statamic.users.new_user_groups` config variables, as these are the roles and groups Statamic assigns to users who register themselves through the user registration form.
