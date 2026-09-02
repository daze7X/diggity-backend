import sys
import re

path = "D:\\SEMESTER 6\\PKL\\diggity-backend\\app\\Filament\\Resources\\CompanySettings\\Schemas\\CompanySettingForm.php"
with open(path, "r", encoding="utf-8") as f:
    content = f.read()

# First, ensure we don't have duplicated or leftover en_ inputs.
content = re.sub(r"Textarea::make\('en_history_text_id'\)[\s\S]*?->rows\(\d+\),", "", content)
content = re.sub(r"Textarea::make\('en_philosophy_build'\)[\s\S]*?->rows\(\d+\),", "", content)
content = re.sub(r"Textarea::make\('en_philosophy_grow'\)[\s\S]*?->rows\(\d+\),", "", content)
content = re.sub(r"Textarea::make\('en_philosophy_scale'\)[\s\S]*?->rows\(\d+\),", "", content)
content = re.sub(r"Textarea::make\('en_philosophy_empower'\)[\s\S]*?->rows\(\d+\),", "", content)
content = re.sub(r"\\Filament\\Forms\\Components\\Section::make\('English Translations.*?\]\),", "", content, flags=re.DOTALL)

# Let's insert the Section right after the Tabs component, before ->columnSpanFull()
section_code = """
                \Filament\Forms\Components\Section::make('English Translations (Lokalisasi EN)')
                    ->collapsed()
                    ->schema([
                        Textarea::make('en_history_text_id')->label('Sejarah Singkat (EN)')->rows(4),
                        Textarea::make('en_philosophy_build')->label('Filosofi - Build (EN)')->rows(2),
                        Textarea::make('en_philosophy_grow')->label('Filosofi - Grow (EN)')->rows(2),
                        Textarea::make('en_philosophy_scale')->label('Filosofi - Scale (EN)')->rows(2),
                        Textarea::make('en_philosophy_empower')->label('Filosofi - Empower (EN)')->rows(2),
                        Repeater::make('en_history_timeline')
                            ->label('Timeline Sejarah Perusahaan (EN)')
                            ->schema([
                                TextInput::make('year')
                                    ->label('Tahun'),
                                TextInput::make('title')
                                    ->label('Judul Milestone (EN)'),
                                Textarea::make('desc')
                                    ->label('Deskripsi (EN)')
                                    ->rows(2),
                            ])
                            ->grid(2)
                            ->columnSpanFull()
                            ->helperText('Kosongkan baris di sini jika ingin menggunakan Auto-Translate dari Milestones Sejarah di atas.'),
                    ]),
"""

# The file ends with:
#                     ])
#                     ->columnSpanFull(),
#             ]);
#     }
# }

content = content.replace("                    ])\n                    ->columnSpanFull(),", "                    ]),\n" + section_code + "                    ->columnSpanFull(),")

with open(path, "w", encoding="utf-8") as f:
    f.write(content)

print("Re-added all English fields into a clean Section.")
