# img-finder
PHP Library to find images in several public repositories 

## Install

```bash
$ composer require ginsen/img-finder
```

## Config file

Create a configuration file in yaml format, `img-finder.yml`, with the following content:

```yaml
img-finder:
    repositories:
        ImgFinder\Repository\PexelsRepository:
            params:
                authorization: your-authorization  # Visit https://www.pexels.com/es-es/api/new/

    # Optional
    translators:
        ImgFinder\Translator\DictionaryYaml:
            no_cache: true
            params:
                filename: img-finder/doc/examples/yaml_dictionary.yml

        ImgFinder\Translator\GoogleTranslate:
            params:
                apikey: your-credentials
                from: es
                to: en
```
And replace your credentials for use your contract services and delete the repositories that do not have 
credentials for their use.

If you do not have credentials to use *GoogleTranslate* remove this translator service, **the dictionary does not need
credentials**, you can configure it to translate the search terms you want to English, such as a tag cloud. Note that 
**the dictionary is not useful for free text searches**.

## Use

Create a config instance with the created yml file, and inject it into **the main ImgFinder class**.

```php
$file   = '/your/path/img-finder.yml';
$config = ImgFinder\Config::fromYaml($file);

$finder = new ImgFinder\ImgFinder($config);
```

**ImgFinder** is now available to query image repositories, just it only necessary to create a request.

```php
$request = ImgFinder\Request::set('nature');
// same as:
$request = ImgFinder\Request::set('nature', 1, 10, 'landscape');
```
Both requests are the same, **"nature"** is the search term, **1** is the default page, **10** is the number of response
images for each repository and page, and finally **"landscape"** is the orientation.

Finally you only need to perform the search.

```php
$response = $finder->search($request);
```

This is the complete code of the entire operation.

```php
use ImgFinder\Config;
use ImgFinder\ImgFinder;
use ImgFinder\Request;

$file   = '/your/path/img-finder.yml';
$config = Config::fromYaml($file);

$finder = new ImgFinder($config);

$request  = Request::set('nature');
$response = $finder->search($request);

$imagesUrls = $response->toArray();
/**
 array:10 [
  0 => "https://some-repository/photos/520094.jpeg"
  1 => "https://some-repository/photos/45824.jpeg"
  2 => "https://some-repository/photos/5692.jpeg"
  3 => "https://some-repository/photos/233.jpg"
  4 => "https://some-repository/photos/327224.jpeg"
  5 => "https://some-repository/photos/306405.jpeg"
  6 => "https://some-repository/photos/324264.jpeg"
  7 => "https://some-repository/photos/28625.jpeg"
  8 => "https://some-repository/photos/354304.jpeg"
  9 => "https://some-repository/photos/5001.jpeg"
 ]
 */
```

## Cache optional

If you wish, you can cache requests to improve performance and not stress the image repositories.

For example, if you use the `symfony/cache` component you can inject it into the initial configuration.

Example:

```bash
$ composer require symfony/cache
```

Create **Redis** cache service.

```php
use ImgFinder\Config;
use Symfony\Component\Cache\Adapter\RedisAdapter;

$redisConn = RedisAdapter::createConnection('redis://my.server.com:6379');
$cache     = new RedisAdapter($redisConn, 'imgfinder', 60);

$file   = '/your/path/img-finder.yml';
$config = Config::fromYaml($file, $cache);
```
