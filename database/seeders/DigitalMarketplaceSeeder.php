<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;

class DigitalMarketplaceSeeder extends Seeder
{
    public function run()
    {
        \ = Category::firstOrCreate([
            'slug' => 'digital-marketplace',
        ], [
            'name' => 'Digital Marketplace',
            'type' => 'product',
            'description' => 'Katalog aset digital premium siap pakai.',
            'is_active' => true,
        ]);

        \ = [
            'Graphics' => [
                'Illustrations' => [
                    ['name' => 'Modern Business Illustration Pack', 'desc' => 'Creative illustrations and visual assets.', 'price' => 99000, 'is_popular' => true, 'is_featured' => true],
                    ['name' => 'Startup & Tech Vector Pack', 'desc' => '100+ scalable vector illustrations for modern apps.', 'price' => 0, 'is_popular' => false, 'is_featured' => false],
                ],
                'Icons' => [
                    ['name' => 'Minimalist Line Icon Set', 'desc' => 'Clean and simple icons for UI design.', 'price' => 45000, 'is_popular' => true, 'is_featured' => false],
                ]
            ],
            'Design Templates' => [
                'Printable Templates' => [
                    ['name' => 'Corporate Brochure Template', 'desc' => 'Print-ready trifold brochure design.', 'price' => 75000, 'is_popular' => false, 'is_featured' => false],
                ],
                'Product Mockups' => [
                    ['name' => 'Clean iPhone 15 Pro Mockups', 'desc' => 'High-resolution realistic iPhone mockups.', 'price' => 120000, 'is_popular' => true, 'is_featured' => true],
                    ['name' => 'Apparel T-Shirt Mockup Bundle', 'desc' => 'Photorealistic t-shirt mockups for clothing brands.', 'price' => 0, 'is_popular' => true, 'is_featured' => false],
                ]
            ],
            '3D' => [
                '3D Models' => [
                    ['name' => 'Low Poly Character Pack', 'desc' => 'Game-ready 3D character models rigged.', 'price' => 150000, 'is_popular' => true, 'is_featured' => true],
                    ['name' => 'Cyberpunk City Assets 3D', 'desc' => 'High quality modular 3D city assets.', 'price' => 250000, 'is_popular' => false, 'is_featured' => false],
                ],
                '3D Templates' => [
                    ['name' => 'Blender Product Reveal Scene', 'desc' => 'Ready to render 3D studio setup.', 'price' => 85000, 'is_popular' => false, 'is_featured' => false],
                ]
            ],
            'Web' => [
                'Admin Templates' => [
                    ['name' => 'Diggity Admin Dashboard', 'desc' => 'Modern admin template built with React and Tailwind.', 'price' => 199000, 'is_popular' => true, 'is_featured' => true],
                ],
                'Website Templates' => [
                    ['name' => 'SaaS Company Template', 'desc' => 'Complete Next.js website template for SaaS.', 'price' => 159000, 'is_popular' => true, 'is_featured' => false],
                ],
                'Landing Page Templates' => [
                    ['name' => 'App Showcase Landing Page', 'desc' => 'Beautiful one-page design to showcase mobile apps.', 'price' => 0, 'is_popular' => false, 'is_featured' => true],
                ],
                'UI Templates' => [
                    ['name' => 'Modern Finance Dashboard UI Kit', 'desc' => 'Complete UI Kit for finance and banking apps.', 'price' => 149000, 'is_popular' => true, 'is_featured' => true],
                    ['name' => 'E-Commerce App UI Kit', 'desc' => 'Premium UI kit for mobile shopping apps.', 'price' => 189000, 'is_popular' => true, 'is_featured' => false],
                ]
            ],
            'Resources' => [
                'Fonts' => [
                    ['name' => 'Diggity Sans Serif Typeface', 'desc' => 'Clean geometric sans serif font family.', 'price' => 0, 'is_popular' => true, 'is_featured' => true],
                ],
                'Presentation Templates' => [
                    ['name' => 'Pitch Deck Pro', 'desc' => 'Premium investor pitch deck template for startups.', 'price' => 89000, 'is_popular' => true, 'is_featured' => false],
                ]
            ]
        ];

        foreach (\ as \ => \) {
            \ = Category::firstOrCreate([
                'slug' => Str::slug(\),
            ], [
                'name' => \,
                'parent_id' => \->id,
                'type' => 'product',
                'is_active' => true,
            ]);

            foreach (\ as \ => \) {
                \ = Category::firstOrCreate([
                    'slug' => Str::slug(\),
                ], [
                    'name' => \,
                    'parent_id' => \->id,
                    'type' => 'product',
                    'is_active' => true,
                ]);

                foreach (\ as \) {
                    Product::firstOrCreate([
                        'slug' => Str::slug(\['name']),
                    ], [
                        'name' => \['name'],
                        'description' => \['desc'],
                        'short_description' => \['desc'],
                        'category_id' => \->id,
                        'is_active' => true,
                        'is_featured' => \['is_featured'],
                        'is_popular' => \['is_popular'],
                    ]);
                    
                    \ = Product::where('slug', Str::slug(\['name']))->first();
                    if (\ && \->pricings()->count() == 0) {
                        \->pricings()->create([
                            'pricing_label' => ['en' => (\['price'] > 0 ? 'Premium' : 'Free'), 'id' => (\['price'] > 0 ? 'Berbayar' : 'Gratis')],
                            'type' => \['price'] > 0 ? 'paid' : 'free',
                            'price' => \['price'],
                            'currency' => 'IDR',
                        ]);
                    }
                }
            }
        }
    }
}
