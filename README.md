

# C&C Community Website
CnC.Community is a new website that hopes to serve as an aggregate for C&C news and modding content from across the community; 
as well as provide a platform for influencers and livestreamers from the wider C&C community to promote their content. 

## Why is it necessary? 
Check out [our mission](OURMISSION.MD)

## 🚀 Quick start

**Using docker**

```shell
    docker-compose up -d --build
    docker-compose run --rm composer install
    docker-compose run --rm npm run dev
    docker-compose run --rm artisan migrate
    docker-compose run artisan storage:link
```




## Images 

It could be the symlink for images needs to be updated for you. 
If so run `rm -rf public/storage` from the src.

* Get container id by running `docker ps`
* Relink symlink for storage `docker exec -it 15f2f7114930 php artisan storage:link`