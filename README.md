jnjxp/html : HTML Helpers
=========================

[![Software License][ico-license]][link-license]
[![Latest version][ico-version]][link-packagist]
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]

**jnjxp\html** is an extension of
[Aura.Html](https://github.com/auraphp/Aura.Html).

## Installation
```console
$ composer require jnjxp/html
```
## Usage

Instantiate helper locator.
```php
use Jnjxp\Html\Factory as HtmlFactory;

$helper = (new HtmlFactory())->newInstance();

// example calling the icon helper
$helper->icon('foo');
$helper->icon->__invoke('foo');
$helper('icon','foo');

```
## Helpers
See the [Aura.Html](https://github.com/auraphp/Aura.Html) documentation
([tag](https://github.com/auraphp/Aura.Html/blob/2.x/README-HELPERS.md) and
[input](https://github.com/auraphp/Aura.Html/blob/2.x/README-FORMS.md)) for base functionality.
- [Breadcrumb](#breadcrumb)
- [CacheBust](#cachebust)
- [Icon](#icon)
- [Links](#links)
- [Metas](#metas)
- [Modal](#modal)
- [Scripts](#scripts)
- [Styles](#styles)
- [Title](#title)

### Helpers Usage

#### Breadcrumb
Create an HTML navigational breadcrumb
```php
$helper->breadcrumb(['id' => 'test']);  // (array) optional attributes

// add a single item to be escaped
$helper->breadcrumb()
    ->item('Home', '/', ['class' => 'foo']); // (title, uri, attributes)

// add several items to be escaped
$helper->breadcrumb()->items(
    [ // key as uri value as title or array of attributes with title as first key
        '/' => 'Home',
        '/foo' => [ 'Foo', 'class' => 'foo']
        'Bar' // numeric index, URI defaults to "#"
    ]
);

// add a single raw item not to be escaped
$helper->breadcrumb()->rawItem('<span>Home</span>', '/', ['class' => 'foo']);

// add several raw items not to be escaped
$helper->breadcrumb()->items(
    [
        '/' => '<span>Home</span>',
        '/foo' => ['Foo', 'class' => 'foo']
        'Bar'
    ]
);

```
Output Example:
```html

<nav aria-label="breadcrumb" role="navigation">
    <ol id="test" itemscope class="breadcrumb" itemtype="http://schema.org/BreadcrumbList">
        <li itemscope itemprop="itemListElement" itemtype="http://schema.org/ListItem">
            <a href="/" itemprop="item"><span itemprop="name">Home</span></a>
            <meta itemprop="position" content="1" />
        </li>
        <li class="foo" itemscope itemprop="itemListElement" itemtype="http://schema.org/ListItem">
            <a href="/foo" itemprop="item"><span itemprop="name">Foo</span></a>
            <meta itemprop="position" content="2" />
        </li>
        <li class="active" itemscope itemprop="itemListElement" itemtype="http://schema.org/ListItem">
            <a href="#" itemprop="item"><span itemprop="name">Bar</span></a>
            <meta itemprop="position" content="3" />
        </li>
    </ol>
</nav>
```


#### CacheBust
Get a version suffixed file based on json manifest.

Example manifest (eg located at: `/var/www/build/rev-manifest.json`):
```json
{
  "assets/js/app.js": "assets/js/app-a9341845.js",
  "assets/css/style.css": "assets/css/style-ca20fa46.css"
}
```

```php
// set path to public root
$helper->cacheBust->setPublic('/var/www');

// returns /build/assets/js/app-a9341845.js
$helper->cacheBust('assets/js/app.js', 'build/rev-manifest.json');

// can set a default manifest as well
$helper->cacheBust->setDefaultManifest('build/rev-manifest.json');
$helper->cacheBust('assets/js/app.js');
```

#### Icon
Create some markup suitable for styling as an icon 
(eg. glyphicons or fontawesome)

```php
echo $helper->icon('edit');
echo $helper->icon('edit', 'Edit Entry');
echo $helper->icon('edit', true);
```
Outputs:
```html
<span class="icon icon-edit" aria-hidden="true"><!-- --></span>

<span class="icon icon-edit" aria-hidden="true"><!-- --></span> <span class="sr-only">Edit Entry</span>

<span class="icon icon-edit" aria-hidden="true"><!-- --></span> <span class="sr-only">edit</span>
```

#### Links
Links helper.
(see [Aura\Html\Helper\Links Documentation](https://github.com/auraphp/Aura.Html/blob/2.x/README-HELPERS.md#links) for core function)

```php
$helper->links->icons();
echo $helper->links;

// can pass array to override defaults:
$icons = [
    'apple-touch-icon' => [
        'pattern' => '/assets/ico/apple-touch-icon-%sx%1$s.png',
        'sizes' => [144, 114, 72, 57]
    ],
    'icon' => [
        'pattern' => '/assets/ico/favicon-%sx%1$s.png',
        'sizes' => [192, 96, 32, 16],
        'attr' => ['type' => 'image/png']
    ]
];

$helper->links->icons($icons);
```
Outputs:
```html
<link rel="apple-touch-icon" sizes="144x144" href="/assets/ico/apple-touch-icon-144x144.png" />
<link rel="apple-touch-icon" sizes="114x114" href="/assets/ico/apple-touch-icon-114x114.png" />
<link rel="apple-touch-icon" sizes="72x72" href="/assets/ico/apple-touch-icon-72x72.png" />
<link rel="apple-touch-icon" sizes="57x57" href="/assets/ico/apple-touch-icon-57x57.png" />
<link rel="icon" sizes="192x192" href="/assets/ico/favicon-192x192.png" type="image/png" />
<link rel="icon" sizes="96x96" href="/assets/ico/favicon-96x96.png" type="image/png" />
<link rel="icon" sizes="32x32" href="/assets/ico/favicon-32x32.png" type="image/png" />
<link rel="icon" sizes="16x16" href="/assets/ico/favicon-16x16.png" type="image/png" />
```

#### Metas
Add meta tags
(see [Aura\Html\Helper\Metas Documentation](https://github.com/auraphp/Aura.Html/blob/2.x/README-HELPERS.md#metas) for core function)
```php
$helper->metas()
    ->addProperty('foo', 'bar')
    ->addOpenGraphProperty('foo', 'bar')
    ->charset() // pass arg to override default
    ->compat() // pass arg to override default
    ->description('description here')
    ->loc() // pass arg to override default
    ->robots('noindex, follow') // no arg? defaults to 'index, follow'
    ->url('http://example.com')
    ->viewport() // pass arg to override default
    ->image('/image.png');

echo $helper->metas();

```
Outputs:
```html
<meta charset="UTF-8" />
<meta property="foo" content="bar" />
<meta property="og:foo" content="bar" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="description" property="og:description" content="description here" />
<meta property="og:locale" content="en_US" />
<meta name="robots" content="noindex, follow" />
<meta property="og:url" content="http://example.com" />
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
<meta name="image" property="og:image" content="/image.png" />
<link rel="image_src" href="/image.png" />
```

#### Modal
Bootstrap Modal
```php
echo $helper->modal(['attr' => ['id' => 'test']])
    ->setTitle('Test Modal')
    ->setBody('Body Here')
    ->setFooter('Modal Footer')
    ->setButton('Launch', ['class' => 'btn-success']);

// Or...

echo $helper->modal(
    [
        'attr'   => ['id' => 'test'],
        'title'  => 'Test Modal',
        'body'   => 'Body Here',
        'footer' => 'Modal Footer',
        'button' => ['Launch', ['class' => 'btn-sucess']]
    ]
);

```
Outputs:
```html

<button class="btn-success" type="button" data-toggle="modal" data-target="#test">
    Launch
</button>
<div id="test" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="test-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="test-label">Test Modal</h4>
            </div>
            <div class="modal-body">
                Body Here
            </div>
            <div class="modal-footer">
                Modal Footer
            </div>
        </div>
    </div>
</div>
```

#### Scripts
Scripts helper
```php
$helper->scripts->bust()
    ->setPublic('/var/www/')
    ->setDefaultManifest('build/rev-manifest.json');

$helper->scripts->bust()->add('assets/js/app.js');

$helper->scripts->addInline('alert("foo")');
$helper->scripts->addEventListener('function(){alert("foo")}');

$helper->scripts->addEventListener(
    'alert(event.type)', // snippet
    'click', // event type
    'document.document.getElementById("test")', // target
    true // wrap snippet in function?
);

$helper->scripts->inlineCaptureStart();
echo 'alert("foo")';
$helper->scripts->captureEnd();


$helper->scripts->eventCaptureStart();
// can take same args as addEventListener
echo 'alert("foo")';
$helper->scripts->captureEnd();

echo $helper->scripts;

```
Outputs:
```html
<script src="/build/assets/js/app-a9341845.js" type="text/javascript"></script>
<script type="text/javascript">alert("foo")</script>
<script type="text/javascript">document.addEventListener("DOMContentLoaded", function(){alert("foo")});</script>
<script type="text/javascript">document.document.getElementById("test").addEventListener("click", function(event) { alert(event.type) });</script>
<script type="text/javascript">alert("foo")</script>
<script type="text/javascript">document.addEventListener("DOMContentLoaded", alert("foo"));</script>
```

#### Styles
Styles helper
(see [Aura\Html\Helper\Styles Documentation](https://github.com/auraphp/Aura.Html/blob/2.x/README-HELPERS.md#styles) for core function)
```php
$helper->styles->bust()
    ->setPublic('/var/www/')
    ->setDefaultManifest('build/rev-manifest.json');

$helper->styles->bust()->add('assets/css/style.css');

$helper->styles->addInline('.test{color:red;}');

$helper->styles->inlineCaptureStart();
echo ".test{color:red;}";
$helper->styles->captureEnd();

echo $helper->styles;

```
Outputs:
```html
    <link rel="stylesheet" href="/build/assets/css/style-ca20fa46.css" type="text/css" media="screen" />
    <style type="text/css" media="screen">.test{color:red;}</style>
    <style type="text/css" media="screen">.test{color:red;}</style>
```

#### Title
Title helper
(see [Aura\Html\Helper\Title Documentation](https://github.com/auraphp/Aura.Html/blob/2.x/README-HELPERS.md#title) for core function)
```php
$helper->title
    ->set('Page Title')
    ->setSite('Site Title');

echo $helper->title;
```
Outputs:
```html
<title>Page Title</title>
<meta name="title" property="og:title" content="Page Title" />
<meta property="og:site_name" content="Site Title" />
```


[ico-version]: https://img.shields.io/packagist/v/jnjxp/html.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-AGPL-911911.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/jnjxp/html/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/jnjxp/html.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/jnjxp/html.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/jnjxp/html.svg?style=flat-square

[link-license]: https://www.gnu.org/licenses/agpl-3.0.html
[link-packagist]: https://packagist.org/packages/jnjxp/html
[link-travis]: https://travis-ci.org/jnjxp/html
[link-scrutinizer]: https://scrutinizer-ci.com/g/jnjxp/html
[link-code-quality]: https://scrutinizer-ci.com/g/jnjxp/html
[link-downloads]: https://packagist.org/packages/jnjxp/html
