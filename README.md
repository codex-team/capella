# [Сapella](https://capella.ifmo.su)

Cloud service for image storage and delivery. Upload files and accept image-filters on the fly with simple API.

Made with :heart: by [CodeX Team](https://ifmo.su)

<!-- *gif* -->

## Content

* [Usage](#usage)

* [Upload API](#upload-api)

    * [Request](#request)

    * [Response](#response)

    * [Example](#example)

* [Get image](#get-image)

    * [Filters](#filters)

## Usage

1. Open Capella or use API to upload image.

2. Get image by given url with applied filters.

### File requirements

Max size for the file is `15MB`.

At this time we support these types of images:

- jpg
- jpeg
- png
- gif
- bmp

Please note that each uploaded file would be converted to PNG.

## Upload API

### Request

Per one request you can upload one file or link.

You can upload image file or send link to image from your app by making a request to `https://capella.ifmo.su/upload`.

| Method | URI      | Data                  |
|--------|----------|-----------------------|
| `POST` | `upload` | `file` field in files |
| `POST` | `upload` | `link` field in data  |

You will get a json response from server.

### Response

Each response will have at least `success` and `message` fields.

| Field     | Type    | Description       |
|-----------|---------|-------------------|
| `success` | Boolean | Request validness |
| `message` | String  | Result message    |

#### Success

| Field     | Type    | Description or value                   |
|-----------|---------|----------------------------------------|
| `success` | Boolean | `true`                                 |
| `message` | String  | `Image uploaded`                       |
| `id`      | String  | Image id                               |
| `url`     | String  | Full link to uploaded image on Capella |

```json
{
    "success": true,
    "message": "Image uploaded",
    "id": "28d23486-c32a-41ae-94e6-72f73a139a7a",
    "url": "https://capella.ifmo.su/28d23486-c32a-41ae-94e6-72f73a139a7a"
}
```

#### Failure

| Field     | Type    | Description or value          |
|-----------|---------|-------------------------------|
| `success` | Boolean | `false`                       |
| `message` | String  | Reason why request was failed |

```json
{
    "success": false,
    "message": "Wrong source mime-type"
}
```

#### List of messages for failed requests

| Message                          |  Description                          |
|----------------------------------|---------------------------------------|
| `Method not allowed`             | Request method is not POST            |
| `File or link is missing`        | No expected data was found            |
| `File is missing`                | File name is empty                    |
| `Link is missing`                | Field link is empty                   |
| `Wrong source mime-type`         | No support file with this mime-type   |
| `Source is too big`              | File size is more than a limit        |
| `Source is damaged`              | Source has no data, size or mime-type |
| `Can't get headers for this URL` | Wrong url was passed                  |

### Example

#### CURL

```bash
# Upload file

curl -X POST https://capella.ifmo.su/upload -F "file=@/path/to/image.png"
```

```bash
# Upload image by link

curl -X POST https://capella.ifmo.su/upload -d "link=https://path.to/image.png"
```

#### Python

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

## Get image

You can get each uploaded image by the following url scheme.

`https://capella.ifmo.su/<image_id>`

### Filters

Add filters at the end of request image URL.

#### Resize

Scale the image to the largest size such that both its width and its height can fit inside the target rectangle.

| Param    | Type    | Description                                                  |
|----------|---------|--------------------------------------------------------------|
| `width`  | Integer | Max image width or max image box size if no height was given |
| `height` | Integer | (optional) Max image height                                  |

`https://capella.ifmo.su/<image_id>/resize/300x400`
`https://capella.ifmo.su/<image_id>/resize/500`

#### Crop

Cover the target rectangle by the image. Nice tool for creating covers or profile pics.

| Param    | Type    | Description                                                                |
|----------|---------|----------------------------------------------------------------------------|
| `width`  | Integer | Target rectangle width or target rectangle box size if no height was given |
| `height` | Integer | (optional) Target rectangle height                                         |

`https://capella.ifmo.su/<image_id>/crop/300x400`
`https://capella.ifmo.su/<image_id>/crop/250`

##### Additional params

If you need to crop area from specified point then pass these params.

Note that this way `width` and `height` will be params for cropped area size.

| Param    | Type    | Description |
|----------|---------|-------------|
| `x`      | Integer | Left indent |
| `y`      | Integer | Top indent  |

`https://capella.ifmo.su/<image_id>/crop/300x400&20,15`


#### Pixelize

Render image using large colored blocks.

| Param     | Type    | Description                          |
|-----------|---------|--------------------------------------|
| `pixels`  | Integer | Number of pixels on the largest side |

`https://capella.ifmo.su/<image_id>/pixelize/25`


## Links

Capella — https://capella.ifmo.su

Repository — https://github.com/codex-team/capella

Report a bug — https://github.com/codex-team/capella/issues/new

CodeX Team — https://ifmo.su
