<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_usuario')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('edad')->nullable();
            $table->text('descripcion')->nullable();
            $table->decimal('precio', 8, 2)->nullable();
            $table->string('numero_celular', 20)->nullable();
            $table->string('ciudad', 100)->nullable();
            $table->enum('rol', ['admin', 'usuario'])->default('usuario');
            $table->boolean('estado_publicidad')->default(true);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('users');
    }
};