import sys

def modify():
    filepath = 'app/Models/Category.php'
    with open(filepath, 'r', encoding='utf-8') as f:
        content = f.read()

    # Add products relation
    if 'public function products()' not in content:
        products_relation = """
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}
"""
        content = content.replace("}\n", products_relation)

    with open(filepath, 'w', encoding='utf-8') as f:
        f.write(content)
    print("Added products() relation to Category.php.")

modify()
