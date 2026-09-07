import sys

path = "D:\\SEMESTER 6\\PKL\\diggity-backend\\app\\Filament\\Resources\\CompanySettings\\Schemas\\CompanySettingForm.php"
with open(path, "r", encoding="utf-8") as f:
    content = f.read()

# Add ->columnSpanFull() back to the Tabs component
bad_code = """                                    ->grid(2)
                                    ->columnSpanFull(),
                            ]),
                    ]),

                \Filament\Schemas\Components\Section::make('English Translations (Lokalisasi EN)')"""

good_code = """                                    ->grid(2)
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpanFull(),

                \Filament\Schemas\Components\Section::make('English Translations (Lokalisasi EN)')"""

content = content.replace(bad_code, good_code)

with open(path, "w", encoding="utf-8") as f:
    f.write(content)

print("Restored columnSpanFull to Tabs.")
