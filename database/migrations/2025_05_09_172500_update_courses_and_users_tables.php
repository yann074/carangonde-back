<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->string('pdf')->nullable(); // exemplo de novo campo
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('cpf'); // substitua pelo nome do campo que deseja remover
        });
    }

    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn('pdf');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('cpf'); // recria o campo removido
        });
    }
};
