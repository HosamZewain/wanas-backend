<?php

use App\Constants\GenderConstants;
use App\Constants\UserStatusConstants;
use App\Constants\UserTypeConstants;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            
            $table->string('name')->change();
            $table->string('activation_code')->after('password')->nullable();
            $table->date('birth_date')->after('activation_code')->nullable();
            $table->boolean('notification_active')->after('birth_date')->default(0);
            $table->double('rate')->after('notification_active')->default(0);
            $table->tinyInteger('gender')->after('rate')->default(GenderConstants::MALE->value);
            $table->tinyInteger('status')->after('gender')->default(UserStatusConstants::NOT_APPROVED->value);
            $table->tinyInteger('type')->after('status')->default(UserTypeConstants::CLIENT->value);
            $table->boolean('is_active')->after('type')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            
            $table->dropColumn('activation_code');
            $table->dropColumn('birth_date');
            $table->dropColumn('notification_active');
            $table->dropColumn('rate');
            $table->dropColumn('gender');
            $table->dropColumn('status');
            $table->dropColumn('type');
            
        });
    }
};
