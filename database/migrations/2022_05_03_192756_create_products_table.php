<?php

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('image')->nullable();
            $table->string('price')->nullable();
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('tags')->nullable();
            $table->timestamps();
        });

        Schema::create('product_user', function (Blueprint $table) {
            $table->string('product_id')
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('user_id')
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('reference')->nullable();
            $table->timestamps();
        });
        

        // insert some dummy data
        $user = User::find(1);
        $product = new Product();
        $product->name = 'Painel de Controle';
        $product->description = 'Dashboard para controle de vendas, clientes e produtos';
        $product->image = 'banner.jpg';
        $product->price = '150';
        $product->user_id = $user->id;
        $product->save();
        $user->contracts()->attach(1);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
        Schema::dropIfExists('product_user');
    }
};
