================
MailCamp Toolbox
================

Both a library and a set of CLI tools for working with `MailCamp's API<http://www.mailcamp.nl/api.html>`_ written in
PHP. The library can be used to implement more complex usages, the CLI commands provide examples for how to work with
them.

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

---------
CLI Usage
---------

On the commandline just call ``./app.php`` to get a list of available commands.

* ``./app.php list:list`` - will retrieve a list of all mailinglists and output their IDs and names
* ``./app.php subscriber:list 123`` - will retrieve all active subscribers in list with ID ``123``
* ``./app.php subscriber:find example@test.com`` - will retrieve all lists the e-mail address has active subscriptions for
* ``./app.php subscriber:unsubscribe example@test.com`` - will unsubscribe ``example@test.com`` from list with ID ``123``

-------------
Library usage
-------------

The library is used by creating a ``MailCampClient`` instance which needs a Guzzle HTTP Client with the endpoint
pre-configured and a username and token. You can check the included ``ServiceProvider`` for an example of this, or use
the service provider on your local Pimple instance.

Once you've got the library setup you can create Call instances to execute operations. You can check the classes to see
what data is necessary for instantiation and what type of response-data you can expect.

Currently the following calls are available:

* FindActiveListSubscribers - find all active subscribers for a list
* FindActiveSubscriptions - find all active subscriptions to list for an e-mail address
* GetLists - retrieve all mailinglists
* UnsubscribeSubscriber - unsubscribe e-mail address from specific list
