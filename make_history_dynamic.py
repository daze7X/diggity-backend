import os
import subprocess
import re

# 1. Create Migration
subprocess.run("php artisan make:migration add_history_text_to_company_settings --table=company_settings", shell=True, cwd="D:\\SEMESTER 6\\PKL\\diggity-backend")

import glob
import time
time.sleep(2)
migrations = glob.glob("D:\\SEMESTER 6\\PKL\\diggity-backend\\database\\migrations\\*add_history_text_to_company_settings*.php")
if migrations:
    mig_file = migrations[0]
    with open(mig_file, "r") as f:
        m_content = f.read()
    
    m_content = m_content.replace(
        "Schema::table('company_settings', function (Blueprint $table) {\n            //\n        });",
        "Schema::table('company_settings', function (Blueprint $table) {\n            $table->text('history_text_id')->nullable();\n            $table->text('history_text_en')->nullable();\n        });",
        1
    )
    m_content = m_content.replace(
        "Schema::table('company_settings', function (Blueprint $table) {\n            //\n        });",
        "Schema::table('company_settings', function (Blueprint $table) {\n            $table->dropColumn(['history_text_id', 'history_text_en']);\n        });",
        1
    )
    with open(mig_file, "w") as f:
        f.write(m_content)

# 2. Update Model
model_path = "D:\\SEMESTER 6\\PKL\\diggity-backend\\app\\Models\\CompanySetting.php"
with open(model_path, "r") as f:
    model_content = f.read()

model_content = model_content.replace(
    "'company_profile_pdf'\n    ];",
    "'company_profile_pdf',\n        'history_text_id',\n        'history_text_en'\n    ];"
)
with open(model_path, "w") as f:
    f.write(model_content)

# 3. Update Filament Form
form_path = "D:\\SEMESTER 6\\PKL\\diggity-backend\\app\\Filament\\Resources\\CompanySettings\\Schemas\\CompanySettingForm.php"
with open(form_path, "r") as f:
    form_content = f.read()

new_fields = """                                Textarea::make('history_text_id')
                                    ->label('Teks Sejarah Singkat (Bahasa Indonesia)')
                                    ->rows(4),

                                Textarea::make('history_text_en')
                                    ->label('Brief History Text (English)')
                                    ->rows(4),
"""
form_content = form_content.replace(
    "Tab::make('Filosofi & Partner')\n                            ->components([",
    "Tab::make('Filosofi & Partner')\n                            ->components([\n" + new_fields
)
with open(form_path, "w") as f:
    f.write(form_content)

# 4. Update Frontend
fe_path = "D:\\SEMESTER 6\\PKL\\diggity-frontend\\app\\about\\page.tsx"
with open(fe_path, "r", encoding='utf-8') as f:
    fe_content = f.read()

old_p = """                                <p className="text-text-gray leading-relaxed text-sm md:text-base">
                                    {locale === 'en'
                                        ? 'Established in 2018 in Tangerang, Diggity was born from a vision to deliver global-standard digital solutions for local businesses. We believe in structured growth frameworks to help businesses build technical foundations, dominate markets, scale capacity, and train internal capabilities.'
                                        : 'Didirikan pada tahun 2018 di Tangerang, Diggity lahir dari visi untuk memberikan solusi digital berkualitas global bagi bisnis lokal. Kami meyakini filosofi pertumbuhan terstruktur untuk membantu bisnis membangun fondasi teknis, mendominasi pasar, menskalakan kapasitas, dan melatih kemandirian internal.'}
                                </p>"""

new_p = """                                <p className="text-text-gray leading-relaxed text-sm md:text-base">
                                    {locale === 'en'
                                        ? (settings?.history_text_en || 'Established in 2018 in Tangerang, Diggity was born from a vision to deliver global-standard digital solutions for local businesses. We believe in structured growth frameworks to help businesses build technical foundations, dominate markets, scale capacity, and train internal capabilities.')
                                        : (settings?.history_text_id || 'Didirikan pada tahun 2018 di Tangerang, Diggity lahir dari visi untuk memberikan solusi digital berkualitas global bagi bisnis lokal. Kami meyakini filosofi pertumbuhan terstruktur untuk membantu bisnis membangun fondasi teknis, mendominasi pasar, menskalakan kapasitas, dan melatih kemandirian internal.')}
                                </p>"""

fe_content = fe_content.replace(old_p, new_p)
with open(fe_path, "w", encoding='utf-8') as f:
    f.write(fe_content)

print("Done generating all dynamic history changes.")
