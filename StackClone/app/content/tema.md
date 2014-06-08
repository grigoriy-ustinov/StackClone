A `style.php` to autocompile LESS using lessphp
===============================================

The script, `style.php`, is a wrapper to the lessphp compiler, enabling autocompiling of LESS-files to a CSS-file and utilizing gzip and browser caching together with easy access to configuration options through a config-file.

`style.php` makes it easier for advanced use of server-side compiling of `style.less` to `style.css`.

<!--more-->

The project includes essentials from lessphp to make it a working example. Just clone it and point your browser to the installation directory. You need to make the directory writable for the webserver since lessphp creates a cache-file `style.less.cache` and writes the resulting `stylesheet.css`.



License 
--------------------------------------

The `style.php` is free software and open source software, licensed according MIT.

Read about the [lessphp compiler](http://leafo.net/lessphp/), written in PHP and subject to its own license.

Read about the [LESS language](http://lesscss.org/). The creators of LESS also built a JavaScript compiler, suitable for client or serverside compilation of LESS-files.



Requirements 
--------------------------------------

`style.php` requires PHP 5.3 and uses lessphp. 



