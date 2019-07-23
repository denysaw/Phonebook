# Phone book
PhalconPHP test task for ([test task](TASK.md) for [Hostaway](https://www.hostaway.com/)).

## Requirements
`git`, `docker`, `docker-compose`

## Installing
This step will run docker containers, install composer dependencies, migrate, seed DB and create `up` file.
```bash
git clone git@github.com:denysaw/phonebook.git
cd phonebook
./init
```

## Start the application all further times
This will only run your docker containers
```bash
./up
```

## Short API reference
Current CRUD API endpoints:

#### Retrieve and search items
Retrieve slice of all items with limit and offset (pagination) and search query

**URL** : `/api/items`

**Method** : `GET`

**URL Params** :
- `p` - Page, default = 1
- `l` - Limit (items per page), default = 100
- `q` - Query, search across both names

**Successful return contains** :
- `status`
- `first`
- `before`
- `previous`
- `current`
- `last`
- `next`
- `total_pages`
- `total_items`
- `limit`

---

#### Get item by id

**URL** : `/api/items/:id`

**Method** : `GET`

**Successful return contains** :
- `status`
- `item`

---

#### Retrieve total items count

**URL** : `/api/items/total`

**Method** : `GET`

**Successful return contains** :
- `status`
- `totalItems`

---

#### Add a new item

**URL** : `/api/items`

**Method** : `POST`

**ContentType**: `JSON` - should contain all required fields

**Successful return contains** :
- `status`
- `id` - ID of just inserted item

**Failed return contains** :
- `status` - `error`
- `messages`

---

#### Edit an existing item

**URL** : `/api/items/:id`

**Methods** : `PUT`, `PATCH` 

**ContentType**: `JSON` - should contain only the fields you need to update

**Successful return contains** :
- `status`
- `updated` - list of updated fields

**Failed return contains** :
- `status` - `error`
- `messages`

---

#### Delete an item

**URL** : `/api/items/:id`

**Method** : `DELETE` 

**Successful return contains** :
- `status`

**Failed return contains** :
- `status` - `error`
- `messages`


## Test the application
Run validation unit tests:
```bash
phpunit
```

## Author's comments
Hello there! =) Really nice and interesting task! And whatta coincidence, I also love Phalcon and actively using it during last year for a personal needs. Surely here's a lot to improve, extend and scale, but for the start it's ok, IMAO :) Used Micro to get rid of services I don't need.
- **Bonus 1:** Wasn't hard, used standard Phalcon's paginator
- **Bonus 2:** Coding own bicycle is a lot of time, hadn't such :) Surely I could extend some wrappers like [Padlock](https://github.com/tegaphilip/padlock) and [Nueko](https://github.com/nueko/phalcon-oauth2-server), but in such case it would be very hard to find my code :)
- **Bonus 3:** Logging also with a standard logger, caching done with Redis.
- **Bonus 4:** I was working with Vagrant long time ago, sorry, but already switched to Docker :)

Thank you for attention and a happy code-review ;)