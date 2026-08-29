<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ProductsRestructureSeeder extends Seeder
{
    public function run()
    {
        // First, optionally clear existing products & their categories if needed. 
        // We will just create or update.

        $structure = [
            'Business Software' => [
                'Website & Commerce' => [
                    'Diggity eCommerce', 'Diggity Website', 'Diggity Blog', 'Diggity Forum', 'Diggity eLearning', 'Diggity Live Chat'
                ],
                'Sales' => [
                    'Diggity CRM', 'Diggity Sales', 'Diggity POS', 'Diggity Subscriptions', 'Diggity Rental'
                ],
                'Finance' => [
                    'Diggity Accounting', 'Diggity Invoicing', 'Diggity Expenses', 'Diggity Documents', 'Diggity Spreadsheets', 'Diggity Sign', 'Diggity ESG'
                ],
                'Inventory & Manufacturing' => [
                    'Diggity Inventory', 'Diggity Manufacturing', 'Diggity PLM', 'Diggity Purchase', 'Diggity Maintenance', 'Diggity Quality'
                ],
                'Human Resources' => [
                    'Diggity HR', 'Diggity Recruitment', 'Diggity Time Off', 'Diggity Appraisals', 'Diggity Employee Referral', 'Diggity Fleet'
                ],
                'Marketing' => [
                    'Diggity Marketing Automation', 'Diggity Email Marketing', 'Diggity SMS Marketing', 'Diggity Social Marketing', 'Diggity Events', 'Diggity Survey'
                ],
                'Services' => [
                    'Diggity Project', 'Diggity Timesheet', 'Diggity Field Service', 'Diggity Helpdesk', 'Diggity Planning', 'Diggity Appointments'
                ],
                'Productivity' => [
                    'Diggity Discuss', 'Diggity Approvals', 'Diggity IoT', 'Diggity VoIP', 'Diggity Knowledge', 'Diggity AI'
                ]
            ],
            'Digital Marketplace' => [
                'Graphics' => [
                    'Illustrations', 'Icons'
                ],
                'Design Templates' => [
                    'Printable Templates', 'Product Mockups'
                ],
                '3D' => [
                    '3D Models', '3D Templates'
                ],
                'Web' => [
                    'Admin Templates', 'Website Templates', 'Landing Page Templates', 'CMS Templates', 'UI Templates', 'Dashboard Templates'
                ],
                'Resources' => [
                    'Digital Assets', 'Fonts', 'Plugins', 'Presentation Templates', 'Documents'
                ]
            ]
        ];

        DB::beginTransaction();
        try {
            foreach ($structure as $mainCatName => $subCats) {
                // Create Main Category
                $mainCat = Category::firstOrCreate(
                    ['slug' => Str::slug($mainCatName), 'type' => 'product'],
                    ['name' => $mainCatName, 'parent_id' => null]
                );

                foreach ($subCats as $subCatName => $products) {
                    // Create Subcategory
                    $subCat = Category::firstOrCreate(
                        ['slug' => Str::slug($subCatName), 'type' => 'product', 'parent_id' => $mainCat->id],
                        ['name' => $subCatName]
                    );

                    foreach ($products as $productName) {
                        // Create Product
                        Product::firstOrCreate(
                            ['slug' => Str::slug($productName)],
                            [
                                'category_id' => $subCat->id,
                                'name' => $productName,
                                'sku' => strtoupper(Str::slug($productName, '-')) . '-' . rand(1000, 9999),
                                'price' => rand(10, 100) * 10000,
                                'billing_period' => 'monthly',
                                'description' => 'Solusi profesional ' . $productName . ' dari Diggity.',
                                'is_active' => 'true',
                            ]
                        );
                        // Ensure it's attached to the correct subcategory in case it already existed
                        Product::where('slug', Str::slug($productName))->update(['category_id' => $subCat->id]);
                    }
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
