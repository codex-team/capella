# [Сapella](https://capella.ifmo.su)

Cloud service for image storage and delivery. Upload files and accept image-filters on the fly with simple API.

Made with :heart: by [CodeX Team](https://ifmo.su)

<!-- *gif* -->

## Usage

...

- upload image

- get image and apply filters

...

## Upload API

There are two ways to upload image. You can also upload image file or send link to image from your app.

Make request to `https://capella.ifmo.su/upload`.

| Method | URI      | Data                  |
|--------|----------|-----------------------|
| `POST` | `upload` | `file` field in files |
| `POST` | `upload` | `link` field in data  |


### CURL examples

```bash
# Upload file

curl -X POST https://capella.ifmo.su/upload -F "file=@/path/to/image.png"
```

```bash
# Upload image by link

curl -X POST https://capella.ifmo.su/upload -d "link=https://path.to/image.png"
```

### Python examples

```python
# Upload file

import requests
import json

files = {
    'file': open('./image.png','rb')
}

r = requests.post('https://capella.ifmo.su/upload', files=files)
response = json.loads(r.content)

print(response)
```

```python
# Upload image by link

import requests
import json

data = {
    'link': 'https://path.to/image.png'
}

r = requests.post('https://capella.ifmo.su/upload', data=data)
response = json.loads(r.content)

print(response)
```

### Get image

...

`https://capella.ifmo.su/<image_id>`

...

## Links

Capella — https://capella.ifmo.su

Repository — https://github.com/codex-team/capella

Report a bug — https://github.com/codex-team/capella/issues/new

CodeX Team — https://ifmo.su
