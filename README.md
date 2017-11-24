# [Сapella](https://capella.ifmo.su)

Cloud service for image storage and delivery. Upload files and accept image-filters on the fly with the simple API.

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

1. Open [capella.ifmo.su](https://capella.ifmo.su) or use [API](#upload-api) to upload an image.

2. Get image by given URL with applied filters.

### File requirements

Maximum size for the file is `15MB`.

Capella supports these types of images:

- jpg
- jpeg
- png
- gif
- bmp

Please note that each uploaded file would be converted to PNG.

## Upload API

### Request

You can upload one file or URL per one request.

You can upload image file or send link to the image from your app by making a request to `https://capella.ifmo.su/upload`.

| Method | URI      | Data                      |
|--------|----------|---------------------------|
| `POST` | `upload` | file in `file` field      |
| `POST` | `upload` | image url in `link` field |

You will get a JSON response from server.

### Response

Each response will have at least `success` and `message` fields.

| Field     | Type    | Description       |
|-----------|---------|-------------------|
| `success` | Boolean | Request validness |
| `message` | String  | Result message    |

#### Success

| Field     | Type    | Description or value            |
|-----------|---------|---------------------------------|
| `success` | Boolean | `true`                          |
| `message` | String  | `Image uploaded`                |
| `id`      | String  | Image id                        |
| `url`     | String  | Full link to the uploaded image |

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
| `File is missing`                | Filename is missing                   |
| `Link is missing`                | Field link is empty                   |
| `Wrong source mime-type`         | No support file with this mime-type   |
| `Source is too big`              | File size exceeds the limit           |
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

You can get each uploaded image by the following URL scheme.

`https://capella.ifmo.su/<image_id>`

[![](https://capella.ifmo.su/07fbdd02-34ee-484b-9592-0d0ebb8454a5)](https://capella.ifmo.su/07fbdd02-34ee-484b-9592-0d0ebb8454a5)

### Filters

Apply filter by adding it at the end of the image URL.

`https://capella.ifmo.su/<image_id>/<filter>/<params>`

You can use as many filters as you want.

`/<filter_1>/<params_1>/<filter_2>/<params_2>...`

Note that the order of filters affects the result:

| Filter                 | Result                                                                        |
|------------------------|-------------------------------------------------------------------------------|
| `/resize/100/crop/200` | [![][codex-stickers-resize-100-crop-200]][codex-stickers-resize-100-crop-200] |
| `/crop/200/resize/100` | [![][codex-stickers-crop-200-resize-100]][codex-stickers-crop-200-resize-100] |

[codex-stickers-resize-100-crop-200]: https://capella.ifmo.su/07fbdd02-34ee-484b-9592-0d0ebb8454a5/resize/100/crop/200
[codex-stickers-crop-200-resize-100]: https://capella.ifmo.su/07fbdd02-34ee-484b-9592-0d0ebb8454a5/crop/200/resize/100

#### Resize

Scale the image to the largest size such that both its width and its height can fit inside the target rectangle.

| Param    | Type    | Description                                                                  |
|----------|---------|------------------------------------------------------------------------------|
| `width`  | Integer | Maximum image`s width or maximum target square`s size if no height was given |
| `height` | Integer | (optional) Maximum image's height                                            |

Example: `https://capella.ifmo.su/<image_id>/resize/300x400`

| Filter                | Result                                                              |
|-----------------------|---------------------------------------------------------------------|
| `/resize/300x400`     | [![][codex-stickers-resize-300-400]][codex-stickers-resize-300-400] |
| `/resize/150`         | [![][codex-stickers-resize-150]][codex-stickers-resize-150]         |

[codex-stickers-resize-150]: https://capella.ifmo.su/07fbdd02-34ee-484b-9592-0d0ebb8454a5/resize/150
[codex-stickers-resize-300-400]: https://capella.ifmo.su/07fbdd02-34ee-484b-9592-0d0ebb8454a5/resize/300x400


#### Crop

Cover the target rectangle by the image. Nice tool for creating covers or profile pics.

| Param    | Type    | Description                                                             |
|----------|---------|-------------------------------------------------------------------------|
| `width`  | Integer | Target rectangle`s width or target square`s size if no height was given |
| `height` | Integer | (optional) Target rectangle height                                      |

Example: `https://capella.ifmo.su/<image_id>/crop/150`

| Filter              | Result                                                          |
|---------------------|-----------------------------------------------------------------|
| `/crop/150`         | [![][codex-stickers-crop-150]][codex-stickers-crop-150]         |
| `/crop/200x400`     | [![][codex-stickers-crop-200-400]][codex-stickers-crop-200-400] |
| `/crop/400x200`     | [![][codex-stickers-crop-400-200]][codex-stickers-crop-400-200] |

[codex-stickers-crop-150]: https://capella.ifmo.su/07fbdd02-34ee-484b-9592-0d0ebb8454a5/crop/150
[codex-stickers-crop-200-400]: https://capella.ifmo.su/07fbdd02-34ee-484b-9592-0d0ebb8454a5/crop/200x400
[codex-stickers-crop-400-200]: https://capella.ifmo.su/07fbdd02-34ee-484b-9592-0d0ebb8454a5/crop/400x200


##### Additional params

If you need to crop an area from specified point then pass these params.

Note that this way `width` and `height` will be size params for the cropped area.

| Param    | Type    | Description |
|----------|---------|-------------|
| `x`      | Integer | Left indent |
| `y`      | Integer | Top indent  |

Example: `https://capella.ifmo.su/<image_id>/crop/400x300&500,150`

| Filter                  | Result                                                                          |
|-------------------------|---------------------------------------------------------------------------------|
| `/crop/400x300&500,150` | [![][codex-stickers-crop-400-300-500-150]][codex-stickers-crop-400-300-500-150] |
| `/crop/300x400&200,150` | [![][codex-stickers-crop-300-400-200-150]][codex-stickers-crop-300-400-200-150] |

[codex-stickers-crop-400-300-500-150]: https://capella.ifmo.su/07fbdd02-34ee-484b-9592-0d0ebb8454a5/crop/400x300&500,150
[codex-stickers-crop-300-400-200-150]: https://capella.ifmo.su/07fbdd02-34ee-484b-9592-0d0ebb8454a5/crop/300x400&200,150

#### Pixelize

Render image using large colored blocks.

| Param     | Type    | Description                          |
|-----------|---------|--------------------------------------|
| `pixels`  | Integer | Number of pixels on the largest side |

Example: `https://capella.ifmo.su/<image_id>/pixelize/20`

| Filter         | Result                                                        |
|----------------|---------------------------------------------------------------|
| `/pixelize/20` | [![][codex-stickers-pixelize-20]][codex-stickers-pixelize-20] |
| `/pixelize/50` | [![][codex-stickers-pixelize-50]][codex-stickers-pixelize-50] |

[codex-stickers-pixelize-20]: https://capella.ifmo.su/07fbdd02-34ee-484b-9592-0d0ebb8454a5/pixelize/20
[codex-stickers-pixelize-50]: https://capella.ifmo.su/07fbdd02-34ee-484b-9592-0d0ebb8454a5/pixelize/50

## Issues and improvements

Ask a question or report a bug on [create issue page](https://github.com/codex-team/capella/issues/new).

Know how to improve Capella? [Fork it](https://github.com/codex-team/capella) and send pull request.

You can also drop a few lines to [CodeX Team's email](mailto:team@ifmo.su).

## License

MIT

Copyright (c) 2017 CodeX Team <team@ifmo.su>

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
