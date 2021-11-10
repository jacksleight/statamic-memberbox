---
title: Introduction
nav_order: 1
---

# Introduction

This Statamic addon provides an out of the box solution for adding a members area or member restricted content to your site, building on Statamic’s existing user management and user form tags. It also provides a dedicated members section in the control panel, allowing you to manage members independently of other users.

> **Important:** This addon uses Statamic’s multi-user features, which are Pro only. Therefore this addon will only work with the Pro edition.

## Features

* A self-contained members section in the control panel that:
	* Only lists members and allows you to search them
	* Allows you to create members through a simplified user wizard
	* Allows you to send member specific welcome emails that link to a frontend activation form
	* Uses seperate view, create and edit member permissions
* A members widget for the dashboard
* These additional user form tags:
	* Activate account
	* Update profile
	* Change password
* Fully-functional implementations of those forms, plus all the [built-in user form tags](https://statamic.dev/reference/tags) (register, login, forgot password and reset password)
* A tag for checking if the current user is a member
* A set of form page URL tags