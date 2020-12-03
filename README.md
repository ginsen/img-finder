# img-finder
App to find images in several public repositories 

## Install

```bash
$ composer require ginsen/img-finder
```

## Config file

```yaml
translators:
  - {class: 'ImgFinder\Translate\DictionaryYaml', params: {filename: img-finder/doc/examples/dictionary.yml}}
  - {class: 'ImgFinder\Translate\GoogleTranslate', params: {credentials: foo, from: es, to: es }}

repositories:
  - {class: 'ImgFinder\Repository\UnsplashRepository', params: {applicationId: ~}}
  - {class: 'ImgFinder\Repository\PexelsRepository', params: {user: ~, password: ~}}
```
