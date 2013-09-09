# Ecommerce Sandbox

Question? Bug? Feature request? Feedback? [Please don’t hesitate to open an issue in the  ecommerce/EcommerceCoreBundle repository - I will get back to you asap!](https://github.com/ecommerce/EcommerceCoreBundle/issues)

This sandbox demonstrates the main features of the [EcommerceCoreBundle](https://github.com/ecommerce/EcommerceCoreBundle). It will be updated shortly to reflect the newest features like translatable fields.

## Installation

Requires Git, PHP 5.3.3+ with php5-intl and [globally installed composer](http://getcomposer.org/doc/00-intro.md#globally)

    git clone git@github.com:ecommerce/ecommerce-sandbox.git
    cd ecommerce-sandbox
    composer install

    php app/console doctrine:database:create
    php app/console doctrine:phpcr:init:dbal
    php app/console doctrine:phpcr:workspace:create default
    php app/console doctrine:phpcr:repository:init
    php app/console doctrine:schema:update --force
    