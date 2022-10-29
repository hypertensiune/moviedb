# moviedb

## Description

This is a php web app for browsing movies and tv shows. Heavily inspired by [themoviedb.org](themoviedb.org) to the point it's almost a clone. All the data used is provided by the [TMDB Api](https://developers.themoviedb.org/3).

Most of the features available on [themoviedb.org](themoviedb.org) are avaialabe here like:
- Searching for movies, tv shows, people & viewing details about them
- Daily & weekly trends and popular movies / tv shows
- Reading reviews

It also has a bookmarking and favorites system. For this to work it needs a database with the following table

```
  CREATE TABLE table_name (
    id INT AUTO_INCREMENT PRIMAY KEY,
    username VARCHAR(50),
    email VARCHAR(100),
    password VARCHAR(255)
  )
  
```


<p align="center">
  <img src="https://github.com/hypertensiune/moviedb/blob/main/screenshots/Screenshot_1.png"/>
  <img src="https://github.com/hypertensiune/moviedb/blob/main/screenshots/Screenshot_2.png"/>
  <img src="https://github.com/hypertensiune/moviedb/blob/main/screenshots/Screenshot_3.png"/>
</p>
