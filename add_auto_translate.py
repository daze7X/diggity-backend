import sys

model_path = "D:\\SEMESTER 6\\PKL\\diggity-backend\\app\\Models\\CompanySetting.php"
with open(model_path, "r") as f:
    content = f.read()

# Add HasTranslations usage
if "use App\\Traits\\HasTranslations;" not in content:
    content = content.replace("use Illuminate\\Database\\Eloquent\\Model;", "use Illuminate\\Database\\Eloquent\\Model;\nuse App\\Traits\\HasTranslations;")

if "use HasTranslations;" not in content:
    content = content.replace("class CompanySetting extends Model\n{", "class CompanySetting extends Model\n{\n    use HasTranslations;\n\n    protected $translatable = ['philosophy_build', 'philosophy_grow', 'philosophy_scale', 'philosophy_empower', 'history_text_id', 'history_timeline'];\n")

with open(model_path, "w") as f:
    f.write(content)

# Update Filament Form to use en_ prefix for auto translate trait interception
form_path = "D:\\SEMESTER 6\\PKL\\diggity-backend\\app\\Filament\\Resources\\CompanySettings\\Schemas\\CompanySettingForm.php"
with open(form_path, "r") as f:
    form_content = f.read()

form_content = form_content.replace("'philosophy_build_en'", "'en_philosophy_build'")
form_content = form_content.replace("'philosophy_grow_en'", "'en_philosophy_grow'")
form_content = form_content.replace("'philosophy_scale_en'", "'en_philosophy_scale'")
form_content = form_content.replace("'philosophy_empower_en'", "'en_philosophy_empower'")
form_content = form_content.replace("'history_text_en'", "'en_history_text_id'")

# Since history_timeline is an array (repeater), auto-translate trait handles array translation recursively!
# But for repeater UI, usually we just supply en_history_timeline as a whole, but Filament Repeater doesn't work well with magic en_ prefix recursively.
# Let's keep title_en and desc_en for history_timeline since it's a JSON column and the user can just leave them blank, but the trait won't auto-translate inside the repeater automatically unless we configure it.
# Wait, the user just wants auto-translate for the text areas.

with open(form_path, "w") as f:
    f.write(form_content)

print("Added auto translate.")
