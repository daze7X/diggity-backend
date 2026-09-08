const fs = require('fs');
const file = 'app/Filament/Resources/Products/ProductResource.php';
let content = fs.readFileSync(file, 'utf8');

const target = `    public static function getRelations(): array
    {
        return [
            //
        ];
    }`;

const targetCRLF = target.replace(/\n/g, '\r\n');

const replacement = `    public static function getRelations(): array
    {
        return [
            RelationManagers\\PricingsRelationManager::class,
        ];
    }`;

if (content.includes(target)) {
    content = content.replace(target, replacement);
    fs.writeFileSync(file, content);
    console.log("Success LF");
} else if (content.includes(targetCRLF)) {
    content = content.replace(targetCRLF, replacement);
    fs.writeFileSync(file, content);
    console.log("Success CRLF");
} else {
    console.log("Target not found!");
}
