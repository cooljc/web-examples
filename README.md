web-examples
============

Simple examples used for learning basics of web technologies.

install
=======

First you will need to have a working MySQL database server running on
the same machine as the web server. Once you have a working MySQL server
create a database called "examples". Then import the SQL scripts from
web-examples/docs/databases/. These will create a table for the address
book example and grant permitions for an "examples" user on this 
database.

Second install the html and php scripts to your web root. To keep it 
clean just copy the entire web-examples directoy to web root. Then 
access from your browser with something like this:

http://localhost/web-examples/AddressBook/

If you are using a remote server then replace "localhost" with your
server address.
