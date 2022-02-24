<p align="center"><a href="https://wesley.io.ke" target="_blank"><img src="https://laratutorials.com/wp-content/uploads/2022/02/Laravel-9-Vue-JS-File-Upload-Example-1024x499.jpg" width="400"></a></p>
<h3>Laravel Vue JS File Upload Example</h3>
Laravel vue js file upload example; Through this tutorial, i am going to show you how to upload files, images and documents with vue js components in laravel 9 apps.


Laravel 9 Vue JS File Upload with Axios Example
Use the below given steps to upload files into database and webserver folder using vue js in laravel 9 apps:

Step 1: Install Laravel 9 App
Step 2: Configure App to Database
Step 3: Create Model And Migration
Step 4: NPM Configuration
Step 5: Add Routes
Step 6: Create Controller By Command
Step 7: Create Vue Component
Step 8: Register Vue App
Step 9: Run Development Server
Step 1: Install Laravel 9 App
Run the following command on command prompt to install laravel new fresh setup:
```php
 composer create-project --prefer-dist laravel/laravel blog 
 ```
Step 2: Configure App to Database
Visit to your project .env file and set up database credential and move next step:

```php
 DB_CONNECTION=mysql 
 DB_HOST=127.0.0.1 
 DB_PORT=3306 
 DB_DATABASE=here your database name here
 DB_USERNAME=here database username here
 DB_PASSWORD=here database password here
 ```
Step 3: Create Model And Migration

Run the following command on command prompt to create model and migration file:
```php
php artisan make:model Photo -m
```
This command will create one model name photo.php and also create one migration file for the photos table.

Now open create_photos_table.php migration file from database>migrations and replace up() function with following code:

```php
<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreatePhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('photos');
    }
}
```
Run the following command on command prompt to migrate the table:
```php
php artisan migrate
```
Step 4: NPM Configuration
Run the following command on command prompt to install Vue and install Vue dependencies using NPM:
```php
composer require laravel/ui
php artisan ui vue
npm install
npm run dev
```
Install all Vue dependencies:


Step 5: Add Routes
Visit to routes folder and open web.php file and add the following routes into your file:
```php
Route::get('upload_file', function () {
    return view('upload');
});
use App\Http\Controllers\FileUploadController;
Route::post('store_file', [FileUploadController::class, 'fileStore']);
```
Step 6: Create Controller By Command
Run the following command on command prompt to create a controller by an artisan:

php artisan make:controller FileUploadController
Visit toapp\Http\Controllers and open FileUploadController.php file. Then update the following code into your FileUploadController.php file:
```php
<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
Use App\Models\Photo;
class FileUploadController extends Controller
{
    // function to store file in 'upload' folder
    public function fileStore(Request $request)
    {
        $upload_path = public_path('upload');
        $file_name = $request->file->getClientOriginalName();
        $generated_new_name = time() . '.' . $request->file->getClientOriginalExtension();
        $request->file->move($upload_path, $generated_new_name);
        
        $insert['title'] = $file_name;
        $check = Photo::insertGetId($insert);
        return response()->json(['success' => 'You have successfully uploaded "' . $file_name . '"']);
    }
}
```
Step 7: Create Vue Component
Visit to resources/assets/js/components folder and create a filed called FileUpload.vue.


And update the following code into your FileUpload.vue components file:
```php
<template>
    <div class="container" style="margin-top: 50px;">
        <div class="text-center">
            <h4>File Upload with VueJS and Laravel</h4><br>
            <div style="max-width: 500px; margin: 0 auto;">
                <div v-if="success !== ''" class="alert alert-success" role="alert">
                    {{success}}
                </div>
                <form @submit="submitForm" enctype="multipart/form-data">
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" name="filename" class="custom-file-input" id="inputFileUpload"
                                   v-on:change="onFileChange">
                            <label class="custom-file-label" for="inputFileUpload">Choose file</label>
                        </div>
                        <div class="input-group-append">
                            <input type="submit" class="btn btn-primary" value="Upload">
                        </div>
                    </div>
                    <br>
                    <p class="text-danger font-weight-bold">{{filename}}</p>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        mounted() {
            console.log('Component successfully mounted.')
        },
        data() {
            return {
                filename: '',
                file: '',
                success: ''
            };
        },
        methods: {
            onFileChange(e) {
                //console.log(e.target.files[0]);
                this.filename = "Selected File: " + e.target.files[0].name;
                this.file = e.target.files[0];
            },
            submitForm(e) {
                e.preventDefault();
                let currentObj = this;
                const config = {
                    headers: {
                        'content-type': 'multipart/form-data',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    }
                }
                // form data
                let formData = new FormData();
                formData.append('file', this.file);
                // send upload request
                axios.post('/store_file', formData, config)
                    .then(function (response) {
                        currentObj.success = response.data.success;
                        currentObj.filename = "";
                    })
                    .catch(function (error) {
                        currentObj.output = error;
                    });
            }
        }
    }
</script>
```
Now open resources/assets/js/app.js and include the FileUpload.vue component like this:app.js
```php
require('./bootstrap');
window.Vue = require('vue');
Vue.component('file-upload-component', require('./components/FileUpload.vue').default);
const app = new Vue({
    el: '#app',
});
```
Step 8: Register Vue App
Create a blade view file to define Vue’s app. Go to resources/views folder and make a file named upload.blade.php. Then update the following code into upload.blade.php as follow:
```php
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <title>File Upload with VueJS and Laravel - Laratutorials.com</title>
    <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css">
</head>
<body>
<div id="app">
    <file-upload-component></file-upload-component>
</div>
<script src="{{asset('js/app.js')}}"></script>
</body>
</html>
```
Step 9: Run Development Server
Run the following command on command prompt to start development server:
```php

npm run dev
or 
npm run watch
```