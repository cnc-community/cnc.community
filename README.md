

# C&C Community Website
CnC.Community is a new website that hopes to serve as an aggregate for C&C news and modding content from across the community; 
as well as provide a platform for influencers and livestreamers from the wider C&C community to promote their content. 

## Why is it necessary? 
Check out [our mission](OURMISSION.MD)

## 🚀 Quick start

**Without docker**

* Create a database and rename `env.example` to `.env`, updating `DB_DATABASE`, `DB_USERNAME` and `DB_PASSWORD`
* In the `src` directory is the standard Laravel files. Run the following commands:

```shell
    composer install
    npm install
    php artisan migrate migrate:refresh --seed
    php artisan storage:link
    php artisan serve --port=8080
```

## Development
```shell
docker-compose -f docker-compose-dev.yml build app
docker-compose -f docker-compose-dev.yml up -d 
docker-compose -f docker-compose-dev.yml exec app bash ./install.sh

```

## Production
```
docker-compose build app
docker-compose up -d
docker-compose exec app bash ./install.sh
```


## Images 

It could be the symlink for images needs to be updated for you. 
If so run `rm -rf public/storage` from the src.

* Get container id by running `docker ps`
* Relink symlink for storage `docker exec -it 15f2f7114930 php artisan storage:link`


### Special
- Will convert text for startime to varchar(255) for now until work out what to do processing wise

```
ALTER TABLE matches CHANGE starttime starttime VARCHAR(20) NULL
```

### Indexes 
- Add index
```
ALTER TABLE `matches` ADD INDEX `matches_leaderboard_history_id_index` (leaderboard_history_id)
```

- Fulltext search for player ids/names
```
ALTER TABLE `matches` ADD FULLTEXT `matches_fulltext_players_index` (players)
ALTER TABLE `matches` ADD FULLTEXT `matches_fulltext_names_index` (names)
```