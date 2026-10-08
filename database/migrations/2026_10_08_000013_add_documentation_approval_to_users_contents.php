<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void {
  Schema::table('users', fn(Blueprint $t) => $t->boolean('is_documentation_admin')->default(false)->after('role'));
  Schema::table('contents', function(Blueprint $t){$t->string('approval_status',20)->default('approved')->after('attachment_path');$t->foreignId('approved_by')->nullable()->after('approval_status')->constrained('users')->nullOnDelete();$t->timestamp('approved_at')->nullable()->after('approved_by');});
 }
 public function down(): void { Schema::table('contents',fn(Blueprint $t)=>$t->dropForeign(['approved_by'])); Schema::table('contents',fn(Blueprint $t)=>$t->dropColumn(['approval_status','approved_by','approved_at'])); Schema::table('users',fn(Blueprint $t)=>$t->dropColumn('is_documentation_admin')); }
};
