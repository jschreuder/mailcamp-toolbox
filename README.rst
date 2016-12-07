================
MailCamp Toolbox
================

A set of CLI tools for working with `MailCamp's API<http://www.mailcamp.nl/api.html>`_ written in PHP.

------------
Requirements
------------

* PHP 5.6 or 7.0
* `Composer<https://getcomposer.org/>`_

------------
Installation
------------

On the commandline execute:

* ``git clone git@github.com:jschreuder/mailcamp-toolbox.git``
* ``cd mailcamp-toolbox/``
* ``composer install``
* ``cp config/main.php.dist config/main.php``

After this you'll need to edit the new ``config/main.php`` to enter the correct endpoint URL, username & token.

-----
Usage
-----

On the commandline just call ``./app.php`` to get a list of available commands.

* ``./app.php list:list`` - will retrieve a list of all mailinglists and output their IDs and names
* ``./app.php subscriber:list 123`` - will retrieve all active subscribers in list with ID ``123``
* ``./app.php subscriber:find example@test.com`` - will retrieve all lists the e-mail address has active subscriptions for
* ``./app.php subscriber:unsubscribe example@test.com`` - will unsubscribe ``example@test.com`` from list with ID ``123``
