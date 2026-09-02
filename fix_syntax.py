import sys

path = "D:\\SEMESTER 6\\PKL\\diggity-backend\\app\\Filament\\Resources\\CompanySettings\\Schemas\\CompanySettingForm.php"
with open(path, "r", encoding="utf-8") as f:
    content = f.read()

# Fix the syntax error at the end of the file
bad_code = """                    ]),
                    ->columnSpanFull(),
            ]);
    }
}"""

good_code = """                    ])
                    ->columnSpanFull(),
            ]);
    }
}"""

# Actually, the section ends with `]),\n                    ->columnSpanFull(),` which is the syntax error.
# Wait, look at the output from PowerShell:
#                     ]),
#                     ->columnSpanFull(),
#             ]);
content = content.replace("                    ]),\n                    ->columnSpanFull(),\n            ]);", "                    ])\n                    ->columnSpanFull(),\n            ]);")

with open(path, "w", encoding="utf-8") as f:
    f.write(content)

print("Fixed syntax error.")
