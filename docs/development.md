# Developer's guide

To run a local copy of Capella you'll need:

- Docker and docker-compose
- Node.js and npm/Yarn

## Setting up the environment

Follow the [deployment guide](deployment.md) to run a local copy of Capella.

## Build scripts and styles

Use webpack to build scripts and styles for Capella.
Firstly you heed to install Node.js dependencies.
 
```shell
npm i
```

or

```shell
yarn install
```

Build bundles for development (fast rebuild). Run this command in separate terminal. Webpack will watch project files and rebuild bundles on changes.

```shell
npm run build:dev
```

or

```shell
yarn build:dev
```

Build bundles for production (compress bundles). Run this command before committing changes. 

```shell
npm run build
```

or

```shell
yarn build
```

## Fix PHP code style

Run this command before committing changes.

```shell
docker exec -i capella_php_1 composer csfix
```

## Watch server's logs 

If you need to watch Capella server's logs then connect to nginx container and open `/var/log/nginx/capella_error.log`

You can watch the end of logs file with the following command:

```shell
docker exec -i capella_nginx_1 tail -f /var/log/nginx/capella_error.log
```

## Disable cache

If you need to disable cache then set param `DISABLE_CACHE` in .env file  to `True` 

```dotenv
...
### Cache server connection params
CACHE_HOST = memcached
CACHE_PORT = 11211
DISABLE_CACHE = True
```
