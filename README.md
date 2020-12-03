# img-finder
App to find images in several public repositories 

## Install

```bash
$ composer require ginsen/img-finder
```

## Config file

```yaml
translators:
  ImgFinder\Translate\Translators\DictionaryYaml:
    params:
      filename: img-finder/doc/examples/dictionary.yml
  ImgFinder\Translate\Translators\GoogleTranslate:
    params:
      credentials: your-credentials
      from: es
      to: es

repositories:
  ImgFinder\Repository\Repositories\PexelsRepository:
    params:
      authorization: your-authorization  # Visit https://www.pexels.com/es-es/api/new/
```
