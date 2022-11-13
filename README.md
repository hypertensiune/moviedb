# moviedb - php movie database

## Description

This is a php web app for browsing movies and tv shows. Heavily inspired by [themoviedb.org](themoviedb.org) to the point it's almost a clone. All the data used is provided by the [TMDB Api](https://developers.themoviedb.org/3).

Most of the features available on [themoviedb.org](themoviedb.org) are avaialabe here like:
- Searching for movies, tv shows, people & viewing details about them
- Daily & weekly trends and popular movies / tv shows
- Reading reviews


## Usage

- Donwload or clone the repository and place the ***mdb*** directory inside your server's ***htdocs*** directory.
- Create the ***mdb/.htaccess*** file with the following content:
```
RewriteEngine On

RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.+)$ index.php [QSA,L]
```
- Create the ***mdb/src/.htaccess*** with the following content:
```
Require all denied
```

## Screeshots

<p align="center">
  <img src="https://github.com/hypertensiune/moviedb/blob/main/screenshots/Screenshot_1.png"/>
  <img src="https://github.com/hypertensiune/moviedb/blob/main/screenshots/Screenshot_2.png"/>
  <img src="https://github.com/hypertensiune/moviedb/blob/main/screenshots/Screenshot_3.png"/>
</p>
