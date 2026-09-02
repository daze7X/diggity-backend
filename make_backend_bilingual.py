import os
import subprocess

# Add columns via migration
subprocess.run("php artisan make:migration add_philosophy_en_to_company_settings --table=company_settings", shell=True, cwd="D:\\SEMESTER 6\\PKL\\diggity-backend")

import glob
import time
time.sleep(2)
migs = glob.glob("D:\\SEMESTER 6\\PKL\\diggity-backend\\database\\migrations\\*add_philosophy_en_to_company_settings*.php")
if migs:
    mig_file = migs[0]
    with open(mig_file, "r") as f:
        content = f.read()
    
    new_cols = "$table->text('philosophy_build_en')->nullable();\n            $table->text('philosophy_grow_en')->nullable();\n            $table->text('philosophy_scale_en')->nullable();\n            $table->text('philosophy_empower_en')->nullable();"
    content = content.replace("Schema::table('company_settings', function (Blueprint $table) {\n            //\n        });", f"Schema::table('company_settings', function (Blueprint $table) {{\n            {new_cols}\n        }});", 1)
    
    drop_cols = "$table->dropColumn(['philosophy_build_en', 'philosophy_grow_en', 'philosophy_scale_en', 'philosophy_empower_en']);"
    content = content.replace("Schema::table('company_settings', function (Blueprint $table) {\n            //\n        });", f"Schema::table('company_settings', function (Blueprint $table) {{\n            {drop_cols}\n        }});", 1)
    
    with open(mig_file, "w") as f:
        f.write(content)

# Update model
model_path = "D:\\SEMESTER 6\\PKL\\diggity-backend\\app\\Models\\CompanySetting.php"
with open(model_path, "r") as f:
    model_content = f.read()

model_content = model_content.replace(
    "'history_text_en'\n    ];",
    "'history_text_en',\n        'philosophy_build_en',\n        'philosophy_grow_en',\n        'philosophy_scale_en',\n        'philosophy_empower_en'\n    ];"
)
with open(model_path, "w") as f:
    f.write(model_content)

# Update Filament Form
form_path = "D:\\SEMESTER 6\\PKL\\diggity-backend\\app\\Filament\\Resources\\CompanySettings\\Schemas\\CompanySettingForm.php"
with open(form_path, "r") as f:
    form_content = f.read()

form_content = form_content.replace(
    "->label('Filosofi - Build')",
    "->label('Filosofi - Build (ID)')"
)
form_content = form_content.replace(
    "->placeholder('Merancang produk software (web/mobile) berkinerja tinggi.'),",
    "->placeholder('Merancang produk software (web/mobile) berkinerja tinggi.'),\n\n                                Textarea::make('philosophy_build_en')\n                                    ->label('Filosofi - Build (EN)')\n                                    ->rows(2),"
)

form_content = form_content.replace(
    "->label('Filosofi - Grow')",
    "->label('Filosofi - Grow (ID)')"
)
form_content = form_content.replace(
    "->placeholder('Mendorong pertumbuhan pasar melalui SEO, periklanan, dan marketing media sosial.'),",
    "->placeholder('Mendorong pertumbuhan pasar melalui SEO, periklanan, dan marketing media sosial.'),\n\n                                Textarea::make('philosophy_grow_en')\n                                    ->label('Filosofi - Grow (EN)')\n                                    ->rows(2),"
)

form_content = form_content.replace(
    "->label('Filosofi - Scale')",
    "->label('Filosofi - Scale (ID)')"
)
form_content = form_content.replace(
    "->placeholder('Menjamin keandalan infrastruktur cloud server dan kapasitas sistem yang stabil.'),",
    "->placeholder('Menjamin keandalan infrastruktur cloud server dan kapasitas sistem yang stabil.'),\n\n                                Textarea::make('philosophy_scale_en')\n                                    ->label('Filosofi - Scale (EN)')\n                                    ->rows(2),"
)

form_content = form_content.replace(
    "->label('Filosofi - Empower')",
    "->label('Filosofi - Empower (ID)')"
)
form_content = form_content.replace(
    "->placeholder('Memberdayakan tim Anda melalui pelatihan dan transfer keahlian digital.'),",
    "->placeholder('Memberdayakan tim Anda melalui pelatihan dan transfer keahlian digital.'),\n\n                                Textarea::make('philosophy_empower_en')\n                                    ->label('Filosofi - Empower (EN)')\n                                    ->rows(2),"
)

# Also update the history_timeline repeater to add title_en and desc_en
form_content = form_content.replace(
    "TextInput::make('title')\n                                              ->label('Judul Milestone')",
    "TextInput::make('title')\n                                              ->label('Judul Milestone (ID)')"
)
form_content = form_content.replace(
    "->label('Judul Milestone (ID)')\n                                              ->required(),",
    "->label('Judul Milestone (ID)')\n                                              ->required(),\n                                          TextInput::make('title_en')\n                                              ->label('Judul Milestone (EN)'),"
)

form_content = form_content.replace(
    "Textarea::make('desc')\n                                              ->label('Deskripsi')",
    "Textarea::make('desc')\n                                              ->label('Deskripsi (ID)')"
)
form_content = form_content.replace(
    "->label('Deskripsi (ID)')\n                                              ->rows(2)\n                                              ->required(),",
    "->label('Deskripsi (ID)')\n                                              ->rows(2)\n                                              ->required(),\n                                          Textarea::make('desc_en')\n                                              ->label('Deskripsi (EN)')\n                                              ->rows(2),"
)

with open(form_path, "w") as f:
    f.write(form_content)

print("Updated backend for bilingual philosophy and timeline.")
