const fs = require('fs');
const file = 'app/Filament/Resources/Products/RelationManagers/PricingsRelationManager.php';
let content = fs.readFileSync(file, 'utf8');

content = content.replace(/use Filament\\Forms\\Form;/g, 'use Filament\\Schemas\\Schema;');
content = content.replace(/public function form\(Form \$form\): Form/g, 'public function form(Schema $schema): Schema');
content = content.replace(/return \$form/g, 'return $schema');

fs.writeFileSync(file, content);
console.log("Fixed PricingsRelationManager form schema signature");
