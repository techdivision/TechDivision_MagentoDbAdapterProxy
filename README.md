Magento Db Proxy Adapter
========================

What is it?
-----------
It's an implementation of a proxy db adapter to separate the db adapter layer from the magento instance
using adapter services.

How to use it?
--------------
You have to enable the adapter in your local.xml.
See src/app/etc/local.xml.adapterProxy.sample how to configure it.

How to enhance it?
------------------
Implement your own adapter service class for e.g. do async database inserts to improve performance.
You can also implement a webservice client to send the database commands to another server.

What does the dummy adapter service?
------------------------------------
It's just an example how to implement a adapter server class. In this case it just wraps the original
magento class and logs every function called to php error log.