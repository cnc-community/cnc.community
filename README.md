![C&C Community Logo](https://user-images.githubusercontent.com/6104940/114301177-8f611c00-9abb-11eb-91b2-09dfaf77daef.png)

# C&C Community Website
CnC.Community is a website that hopes to serve as an aggregate for C&C news and modding content from across the community; 
as well as provide a platform for influencers and livestreamers from the wider C&C community to promote their content. 

## Why is it necessary? 
Check out [our mission](https://cnc.community/news/official-news/our-mission)

## 🚀 Quick start

## Development
Node 14.21.3

```shell
docker-compose -f docker-dev-compose.yml build
docker-compose -f docker-dev-compose.yml up -d 
docker-compose -f docker-dev-compose.yml exec app bash ./install.sh
```

### Vite Configuration
To access public routes you may need to have the vite manifest.json file configured.
To do this you can run npm install && npm run build within the src directory.

## Production
```
docker-compose build
docker-compose up -d
docker-compose exec app bash ./install.sh
```

## Seeding Leaderboard for Local Development
- Login to `localhost:8080/admin/dashboard` with local env credentials: `admin@cnc.community` & `password` 
- Run the leaderboard sync. This will require Steam credentials to be filled into the src/.env file.

```
# exec into your running app container
docker exec -it <container-id> sh

# manually run the sync commands
php artisan remasters:sync
php artisan ninebitarmies:sync

# additional graph sync command
php artisan cache:graphstats
```

- Login to phpmyadmin `localhost:8081/` with `root` and `cnccommunity`. Run the sql queries in the `cnccommunity_ladder` table:

```
ALTER TABLE `matches` ADD INDEX `matches_leaderboard_history_id_index` (leaderboard_history_id)
```

- Fulltext search for player ids/names
```
ALTER TABLE `matches` ADD FULLTEXT `matches_fulltext_players_index` (players)
ALTER TABLE `matches` ADD FULLTEXT `matches_fulltext_names_index` (names)
```

## Other

## Steam API Key
It seems after a period of time steam API key expire. If anything steam related on the site is no longer displaying, edit the .env and update `STEAM_API_KEY` with a new steam key. Register a new steam key here: https://steamcommunity.com/dev. Clear site wide cache the site should be fetching steam related content again.


### Images 

It could be the symlink for images needs to be updated for you. 
If so run `rm -rf public/storage` from the src.

* Get container id by running `docker ps`
* Relink symlink for storage `docker exec -it <container_id> php artisan storage:link`



### Getting setup without docker

* Create a database and rename `env.example` to `.env`, updating `DB_DATABASE`, `DB_USERNAME` and `DB_PASSWORD`
* In the `src` directory is the standard Laravel files. Run the following commands:

```shell
    composer install
    npm install
    php artisan migrate migrate:fresh --seed
    php artisan storage:link
    php artisan serve --port=8080
```
