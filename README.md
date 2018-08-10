# PHP 7 Data Structures and Algorithms
This is the code repository for [PHP 7 Data Structures and Algorithms](https://www.packtpub.com/application-development/php-7-data-structures-and-algorithms?utm_source=github&utm_medium=repository&utm_campaign=9781786463890), published by [Packt](https://www.packtpub.com/?utm_source=github). It contains all the supporting project files necessary to work through the book from start to finish.
## About the Book
PHP has always been the go-to language for web based application development, but there are materials and resources you can refer to to see how it works. Data structures and algorithms help you to code and execute them effectively, cutting down on processing time significantly.
## Instructions and Navigation
All of the code is organized into folders. Each folder starts with a number followed by the application name. For example, Chapter02.

All chapters contain code files.

The code will look like the following:
```
[default]
class TreeNode {
public $data = NULL;
public $children = [];
public function __construct(string $data = NULL) {
$this->data = $data;
}
public function addChildren(TreeNode $node) {
$this->children[] = $node;
}
}
```

All you need to have is the latest PHP version (minimum requirement is PHP 7.x) installed
on your machine. You can run the examples from a command line, which does not require a
web server. However, if you want, you can install Apache or Nginx, or the following:
PHP 7.x+,
Nginx/apache (optional),
PHP IDE or code editor.

## Related Products
* [Learning PHP 7](https://www.packtpub.com/application-development/learning-php-7?utm_source=github&utm_medium=repository&utm_campaign=9781785880544)

* [Learning PHP 7 High Performance](https://www.packtpub.com/application-development/learning-php-7-high-performance?utm_source=github&utm_medium=repository&utm_campaign=9781785882265)

* [Modular Programming with PHP 7](https://www.packtpub.com/application-development/modular-programming-php-7?utm_source=github&utm_medium=repository&utm_campaign=9781786462954)

