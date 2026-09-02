import sys
import glob

files = glob.glob("database/migrations/*add_company_profile_pdf*.php")
if not files:
    print("Migration not found")
    sys.exit(1)

file = files[0]
with open(file, 'r', encoding='utf-8') as f:
    content = f.read()

content = content.replace(
    "Schema::table('company_settings', function (Blueprint $table) {\n            //\n        });",
    "Schema::table('company_settings', function (Blueprint $table) {\n            $table->string('company_profile_pdf')->nullable()->after('philosophy_empower');\n        });",
    1
)

content = content.replace(
    "Schema::table('company_settings', function (Blueprint $table) {\n            //\n        });",
    "Schema::table('company_settings', function (Blueprint $table) {\n            $table->dropColumn('company_profile_pdf');\n        });",
    1
)

with open(file, 'w', encoding='utf-8') as f:
    f.write(content)

print(f"Updated migration {file}")
