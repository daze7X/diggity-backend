const fs = require('fs');

function updateModel(file, addFillable) {
    let content = fs.readFileSync(file, 'utf8');
    if (!content.includes("'pricing_id'")) {
        // Find fillable array
        const fillableMatch = content.match(/protected \$fillable = \[([\s\S]*?)\];/);
        if (fillableMatch) {
            let fillableContent = fillableMatch[1];
            // Ensure trailing comma and add pricing_id
            fillableContent = fillableContent.trim();
            if (!fillableContent.endsWith(',')) fillableContent += ',';
            fillableContent += "\n        'pricing_id',";
            content = content.replace(fillableMatch[1], "\n        " + fillableContent.trim() + "\n    ");
        }
    }
    
    // Add relationship
    if (!content.includes("public function pricing()")) {
        content = content.replace(/}\s*$/, `
    public function pricing(): BelongsTo
    {
        return $this->belongsTo(Pricing::class);
    }
}
`);
    }

    fs.writeFileSync(file, content);
}

updateModel('app/Models/OrderItem.php');
updateModel('app/Models/UserLicense.php');
console.log("Updated OrderItem and UserLicense models");
