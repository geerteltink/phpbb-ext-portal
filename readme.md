# phpBB 3.1 Portal Extension

[![Latest Stable Version](https://poser.pugx.org/xtreamwayz/portal/v/stable.svg)](https://packagist.org/packages/xtreamwayz/portal)
[![Latest Unstable Version](https://poser.pugx.org/xtreamwayz/portal/v/unstable.svg)](https://packagist.org/packages/xtreamwayz/portal)
[![Total Downloads](https://poser.pugx.org/xtreamwayz/portal/downloads.svg)](https://packagist.org/packages/xtreamwayz/portal)
[![License](https://poser.pugx.org/xtreamwayz/portal/license.svg)](https://packagist.org/packages/xtreamwayz/portal)

Portal is an Extension for [phpBB 3.1](https://www.phpbb.com/)

## Description

Adds a custom portal page to the board.

## Installation

Clone into phpBB/ext/xtreamwayz/portal:

    git clone https://github.com/xtreamwayz/phpbb-ext-portal.git phpBB/ext/xtreamwayz/portal

Unfortunately you cannot overwrite an extension template file in your theme. That's why the example template has a `.dist` suffix. So you need to copy the `portal_body.html.dist` to your themes template path, rename it to `portal_body.html` and hack into it as you please.

    // Copy
    ext/xtreamwayz/portal/styles/prosilver/template/portal_body.html.dist
    // To
    styles/prosilver/template/portal_body.html

Set up the dependencies:

    php composer.phar install --no-dev

Go to "ACP" > "Customise" > "Extensions" and enable the "phpBB 3.1 Portal Extension" extension.

The portal will be available at the root `example.com/`. In case it doesn't work, you need to add these lines to .htaccess:

    RewriteEngine on
    RewriteBase /
    DirectoryIndex app.php

## Collaborate

* Create a issue in the [tracker](https://github.com/xtreamwayz/phpbb-ext-portal/issues)
* Note the restrictions for [branch names](https://wiki.phpbb.com/Git#Branch_Names) and [commit messages](https://wiki.phpbb.com/Git#Commit_Messages) are similar to phpBB3
* Submit a [pull-request](https://github.com/xtreamwayz/phpbb-ext-portal/pulls)

## License

[GPLv2](license.txt)
