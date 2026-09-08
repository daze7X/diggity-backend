const fs = require('fs');
const file = 'routes/api.php';
let content = fs.readFileSync(file, 'utf8');

content = content.replace("with(['category', 'seoMeta'])", "with(['category', 'seoMeta', 'pricings'])");
content = content.replace("Product::with('category')", "Product::with(['category', 'pricings'])");

fs.writeFileSync(file, content);
console.log("Eager loaded pricings in API routes");
