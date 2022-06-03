<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            // dados pessoais
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->string('cep')->nullable();
            $table->string('rua')->nullable();
            $table->string('num')->nullable();
            $table->string('etc')->nullable();
            $table->string('bairro')->nullable();
            $table->string('cidade')->nullable();
            $table->string('uf')->nullable();
            
            // dados para acesso e permissões
            $table->string('team')->nullable();
            $table->string('expires_at')->nullable();
            $table->string('url')->nullable();
            $table->string('api_key')->nullable();

            // dados da conta
            $table->string('password');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        User::create([
            'name' => 'weverton',
            'email' => '***REMOVED***@gmail.com',
            'phone' => '+5534988291040',
            'password' => bcrypt('***REMOVED***'),
            'email_verified_at' => now(),
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
