# img-finder
App to find images in several public repositories 

## Install

```bash
$ composer require ginsen/img-finder
```

## Config file

```yaml
translate:
  dictionary:
    enable: true
    path: app/mirutalocal/dictio_es_en.po
  google_translate:
    enable: true
    credentials: {token: ~, from: es, to: en}

repositories:
  - unsplash: {applicationId: ~}
  - pexels: {user: ~, password: ~}
```
