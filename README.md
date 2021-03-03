# Coding challenge

Software Engineer - Coding challenge

### Installing

simply run 

```
git clone https://github.com/AmineAlyate/codingChallenge.git --branch master
```

Then in the project folder run the following comands

```
npm i --save && composer i
```
Let's generate the app key

```
php artisan key:generate
```
Rename .env.example to .env and create databse with the name codingchallenge and run

```
php artisan config:cache
```

###a Now u are good to go hope u enjoy it :)

## Running the tests

```
php artisan test
```

### CLI

Create category
```
php artisan make:category {name} {parent categorie -optional}
```

Delete category
```
php artisan delete:category {id}
```

Add Product
```
php artisan make:product {name} {description} {price}
```

delete Product
```
php artisan delete:product {id}
```

## Built With

* [Laravel](https://laravel.com/) - on The Server Side
* [Vuejs](https://vuejs.org/) - on The Fontend
* [Tailwind css](https://tailwindcss.com/) - For Styling

## Author

* **Alyate Mohamed Amine**
