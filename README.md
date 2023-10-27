<h1>Laravel (v10) REST api CRUD example</h1>


<h2>Clone instruction:</h2>
<ul>
    

<li>Run <code>git clone 'link projer github'</code></li>
<li>Run <code>composer install</code>
<li><p>Edit your database path in .env file after below step</p>
Run <code>cp .env.example .env or copy .env.example .env</code> </li>
<li>Run <code>php artisan key:generate</code></li>
<li>Run <code>php artisan migrate</code></li>
<li>Run <code>php artisan db:seed</code></li>
<li>Run <code>php artisan serve</code></li>
</ul>
<b>TEST using postman or other rest client app</b>



<h2>Instruction for creating Fresh project<h2>
<b>Create a new laravel project using composer:</b>

<code>composer create-project laravel/laravel example-app</code>

<b>Open the project using VS code editor and run the </b>
<code>$ php artisan serve</code>

<p>for checking laravel server running properly</p>

Open your XAMPP and start apache and mysql, then open phpmyadmin

create a new database as laravel-rest-api

Edit your .env file of laravel project, go to DB_CONNECTION section and change the following
<code>
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel-rest-api (your db name)
DB_USERNAME=root (your db username)
DB_PASSWORD=   (your db password)
</code>

Create a table called PRODUCTS

<code>php artisan make:migration create_products_table</code>

it will create new migration file, add the these fields in that migration file

<code>
$table->string('product_name', 255)->nullable();
$table->string('price', 255)->nullable();
$table->text('details')->nullable();
</code>
run the migration file 
File location <code>(database/migrations/xxxxxx_create_products_table)</code>
<code>php artisan migrate</code>


Make a model file 
<code>php artisan make:model Products</code>
File location <code>(app/models/Products.php)</code>


Create a Controller file
file location <code>(pp/Http/Controllers)</code>

<code>php artisan make:controller ProductController</code>

Go to the ProductController file add these functions for CRUD
<code>

    public function index(){
        $products = Products::all();
        //response in JSON format
        return response()->json($products);
    }

    public function addNew(Request $request){
        $product = new Products();
        $product->product_name = $request->product_name;
        $product->price = $request->price;
        $product->details = $request->details;
        $product->save();
        return response()->json(["message"=>"New Product added successfully"], 201);
    }


    public function displayByid($id){
        $product = Products::find($id);
        if(!empty($product)){
            return response()->json(["message"=> "Product Details", "product"=> $product]);
        }else{
            return response()->json(["message"=> "Opps! Product not found."], 404);
        }
    }

  
    public function updateProduct(Request $request, $id){
        if(Products::where("id", $id)->exists()){
            $product = Products::find($id);
            $product->product_name = is_null($request->product_name) ? $product->product_name : $request->product_name;
            $product->price = is_null($request->price) ? $product->price : $request->price;
            $product->details = is_null($request->details) ? $product->details : $request->details;

            $product->save();
            return response()->json(["message"=>"Product updated successfully"], 201);

        }else{
            return response()->json(["message"=>"Product not found"], 404);
        }
    }
    public function deleteProduct($id){
        if(Products::where("id", $id)->exists()){
            $product = Products::find($id);
            $product->delete();
            return response()->json(["message"=> "Product deleted successfully"], 202);
        }else{
            return response()->json(["message"=> "Product not found"], 404);
        }
    }
</code>
<h3>Create the routes</h3>
<p>Routing is a way to generate your REST api web application’s request endpoint URL.</p>
File location (routes/api.php)

<code>
Route::get('/products', [ProductController::class,'index']);
Route::get('/products/{id}', [ProductController::class,'displayByid']);
Route::post('/products', [ProductController::class,'addNew']);
Route::put('/products/{id}', [ProductController::class,'updateProduct']);
Route::delete('/products/{id}', [ProductController::class,'deleteProduct']);

</code>

TEST THE REST API USING POSTMAN OR other REST CLIENT APP
