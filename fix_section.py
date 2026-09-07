import sys

path = "D:\\SEMESTER 6\\PKL\\diggity-backend\\app\\Filament\\Resources\\CompanySettings\\Schemas\\CompanySettingForm.php"
with open(path, "r", encoding="utf-8") as f:
    content = f.read()

content = content.replace(
    "\Filament\Forms\Components\Section::make",
    "\Filament\Schemas\Components\Section::make"
)

with open(path, "w", encoding="utf-8") as f:
    f.write(content)

print("Fixed Section namespace.")
