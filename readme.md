
# Markdown to HTML Converter

*It's me! I'm markdown right now!* 

This is a very simple applet that will convert (a bit) of markdown to html. 
Supported tags are: 

* h1 - h6 headers
* Links
* Paragraphs

## Usage

Just simply call the `MarkdownConverter` class and run the `convert()` method:

```
$markdown = <<EOD
# Header one

Hello there
How are you?

What's going on?
## Another Header
This is a paragraph [with an inline link](http://google.com). Neat, eh?
>>

$markdownConverter = new App\MarkdownConverter();
echo $markdownConverter->convert($markdown);
```

This will return the html that you need:

```
<h1>Header one</h1>

<p>Hello there</p>

<p>How are you?
What's going on?</p>

<h2>Another Header</h2>

<p>This is a paragraph <a href="http://google.com">with an inline link</a>. Neat, eh?</p>

```

## Forking and Testing

If you wish to fork and extend the funcionaliy, feel absolutely free! However, if you do, I only ask that
you continue the test driven metholodogy. I'm using PHPUnit, which you can easily run and install. Maky PHP IDEs
are compatable with PHPUnit, but the easiest way to get up and running (on OSX) is to use `homebrew`:

**Install homebrew:**

`$ /bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"`

This should install on your local machine, no muss no fuss. 

***Note:** The new Macbook Pros with the M1 chip and ARM256 chipset has some funky bugs at the moment. If you are on one of those laptops, you may have to do some Googling or check out [Brew's Github](https://github.com/Homebrew/brew).*

Before you install anything, make sure you run `brew doctor` and follow the shown instructions:

`$ brew doctor`

**Install PHPUnit**

First, you gotta install PHP

`$ brew install php`

Onne thing I often forget to do is add the correct PHP path to my zsh profile:

```
$ echo 'export PATH=$PATH:/usr/share/php/bin' >> ~/.zshrc
$ source ~/.zshrc
```

Or for bash:

```
$ echo 'export PATH=$PATH:/usr/share/php/bin' >> ~/.bashrc
$ source ~/.bashrc
```

Now PHP should work in your command line:

```
$ php -v
PHP 8.1.2 (cli) (built: Jan 21 2022 04:47:26) (NTS)
Copyright (c) The PHP Group
Zend Engine v4.1.2, Copyright (c) Zend Technologies
    with Zend OPcache v8.1.2, Copyright (c), by Zend Technologies
```

Time to install PHPUnit:

`$ brew install phpunit`

Once it's run, just simply run your tests!

`$ phpunit tests`

And if you're debugging:

`$ phpunit tests --debug`

And you should be good to go! Go forth and fix my code.