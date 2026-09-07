<?php
$products = \App\Models\Product::all();
foreach($products as $p) {
    if (is_array($p->specifications) && isset($p->specifications[0]['key'])) {
        $newSpecs = [];
        foreach($p->specifications as $spec) {
            if(isset($spec['key']) && isset($spec['value'])) {
                $newSpecs[$spec['key']] = $spec['value'];
            }
        }
        $p->specifications = $newSpecs;
    }
    
    // Also check en_ properties manually if needed, but HasTranslations handles the save via virtual attributes
    if (is_array($p->en_specifications) && isset($p->en_specifications[0]['key'])) {
        $newEnSpecs = [];
        foreach($p->en_specifications as $spec) {
            if(isset($spec['key']) && isset($spec['value'])) {
                $newEnSpecs[$spec['key']] = $spec['value'];
            }
        }
        $p->en_specifications = $newEnSpecs;
    }
    $p->save();
}
echo "Data cleaned!\n";
