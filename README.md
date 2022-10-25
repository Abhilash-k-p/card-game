## The APP

- Frontend: <http://localhost:80>
- Backend: <http://localhost:80/api>
- Database
  - Hostname: `mysql`
  - Port: `3306`
  - Username: `root`
  - Password:
  - Database: `acto_card_challenge`

### Default tech stack

- PHP 8.1.4
- Laravel Framework 9.7.0
- MySQL 8.0
- Redis latest
- Mailhog latest

### Your Tech Stack

_Put an `x` in all the boxes that apply and fill all the information between `<>`. **Add more boxes if needed**._

- [ ] <Editor/IDE>
- [ ] Vue \<version>
- [ ] Tailwind \<version>

### API Reference

#### Play a game

```http
POST /api/play
```

| Parameter  | Type      | Description                                              |
| :--------  | :-------  | :-------------------------                               |
| `user_id`  | `string`  | **Required**. User that is playing the game              |
| `cards`    | `array`   | **Required**. cards played by the user                   |
| `distinct` | `boolean` | if only distinct cards should be played. **Not implemented** |

#### Get leaderboard

```http
GET /api/leaderboard
```

| Parameter | Type     | Description   |
| :-------- | :------- | :------------ |
| `cursor`  | `string` | [Page location](https://laravel.com/docs/master/pagination#cursor-pagination) |

## Instructions to run the app

_Please add or update instructions in this section._

[Clone the project](https://docs.github.com/en/repositories/creating-and-managing-repositories/cloning-a-repository)

```bash
git clone https://link-to-project
```

Go to the project directory

```bash
cd card-game-challenge
```

Install dependencies

```bash
composer install
```

Start the server with [Sail](https://laravel.com/docs/master/sail#starting-and-stopping-sail) - [(make sure you have docker installed)](https://docs.docker.com/get-docker/)

```bash
vendor/bin/sail up -d
```

Run migrations

```bash
vendor/bin/sail artisan migrate
```

Install Front-end dependencies

```bash
vendor/bin/sail npm install
```

Compile Front-end

```bash
vendor/bin/sail npm run dev
```

Visit <http://localhost:80> on your default web browser
