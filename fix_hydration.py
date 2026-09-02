import sys

path = "D:\\SEMESTER 6\\PKL\\diggity-backend\\app\\Traits\\HasTranslations.php"
with open(path, "r") as f:
    content = f.read()

# Make sure toArray appends the en_ fields so Filament can hydrate them
old_toArray = """    public function toArray()
    {
        $attributes = parent::toArray();"""
        
new_toArray = """    public function toArray()
    {
        $attributes = parent::toArray();
        $translatableFields = $this->getTranslatableFields();
        if ($this->relationLoaded('translations') || $this->exists) {
            foreach ($translatableFields as $field) {
                $translated = $this->getTranslation($field, 'en');
                if ($translated !== null) {
                    $attributes['en_' . $field] = $translated;
                }
            }
        }"""

content = content.replace(old_toArray, new_toArray)

with open(path, "w") as f:
    f.write(content)

print("Fixed Filament hydration for en_ fields.")
