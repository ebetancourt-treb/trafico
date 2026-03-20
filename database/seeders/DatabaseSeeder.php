<?php

namespace Database\Seeders;

use App\Models\CompanyValue;
use App\Models\Industry;
use App\Models\ProductCategory;
use App\Models\Product;
use App\Models\Section;
use App\Models\SiteSetting;
use App\Models\Slide;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ─── Admin User ───
        User::updateOrCreate(
            ['email' => 'admin@trafico.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('password'),
            ]
        );

        // ─── Site Settings ───
        $settings = [
            ['key' => 'site_name', 'value' => 'Tráfico Soluciones Viales', 'type' => 'text', 'group' => 'general'],
            ['key' => 'phone', 'value' => '871 511 8808', 'type' => 'text', 'group' => 'contact'],
            ['key' => 'email', 'value' => 'ventas@trafico.com', 'type' => 'text', 'group' => 'contact'],
            ['key' => 'whatsapp', 'value' => '528715118808', 'type' => 'text', 'group' => 'contact'],
            ['key' => 'facebook', 'value' => '#', 'type' => 'text', 'group' => 'social'],
            ['key' => 'instagram', 'value' => '#', 'type' => 'text', 'group' => 'social'],
            ['key' => 'tiktok', 'value' => '#', 'type' => 'text', 'group' => 'social'],
            ['key' => 'logo', 'value' => 'images/logo.png', 'type' => 'image', 'group' => 'general'],
            ['key' => 'catalogo_pdf', 'value' => null, 'type' => 'file', 'group' => 'general'],
            ['key' => 'portafolio_pdf', 'value' => null, 'type' => 'file', 'group' => 'general'],
        ];

        foreach ($settings as $setting) {
            SiteSetting::updateOrCreate(['key' => $setting['key']], $setting);
        }

        // ─── Slides ───
        Slide::updateOrCreate(['title' => 'Pintura Vial'], [
            'subtitle' => 'Soluciones profesionales para señalamiento vial',
            'cta_text' => 'MÁS INFORMACIÓN',
            'cta_url' => '#productos',
            'image' => 'images/slides/slide-1.jpg',
            'side_image' => 'images/slides/slide-1-side.jpg',
            'order' => 1,
            'is_active' => true,
        ]);

        // ─── Sections ───
        Section::updateOrCreate(['slug' => 'nosotros'], [
            'title' => '¿Quiénes Somos?',
            'content' => 'En Tráfico trabajamos para hacer más seguras y eficientes las vialidades de nuestras ciudades. Nos apasiona ofrecer soluciones de señalamiento que orienten, protejan y generen confianza en cada camino, cuidando siempre la vida de quienes transitan por ellos.',
            'image' => 'images/nosotros.jpg',
            'order' => 1,
        ]);

        Section::updateOrCreate(['slug' => 'mision'], [
            'title' => 'Nuestra Misión',
            'content' => 'En Tráfico trabajamos para hacer más seguras y eficientes las vialidades de nuestras ciudades. Nos apasiona ofrecer soluciones de señalamiento que orienten, protejan y generen confianza en cada camino, cuidando siempre la vida de quienes transitan por ellos.',
            'order' => 2,
        ]);

        Section::updateOrCreate(['slug' => 'vision'], [
            'title' => 'Nuestra Visión',
            'content' => 'Queremos ser una empresa reconocida por hacer la diferencia en la seguridad vial: por nuestra calidad, compromiso y la forma en que tratamos a nuestros clientes y comunidades. Buscamos crecer con propósito, llevando orden, confianza y bienestar a cada proyecto que realizamos.',
            'order' => 3,
        ]);

        // ─── Company Values ───
        $values = [
            ['title' => 'Seguridad', 'description' => 'Todo lo que hacemos tiene como fin proteger la vida.', 'order' => 1],
            ['title' => 'Compromiso', 'description' => 'Cumplimos nuestras promesas, sin importar el tamaño del reto.', 'order' => 2],
            ['title' => 'Cercanía', 'description' => 'Escuchamos, entendemos y acompañamos a nuestros clientes.', 'order' => 3],
            ['title' => 'Honestidad', 'description' => 'Actuamos con transparencia, construyendo relaciones de confianza.', 'order' => 4],
            ['title' => 'Pasión', 'description' => 'Nos mueve el orgullo de contribuir al desarrollo de nuestras ciudades.', 'order' => 5],
        ];

        foreach ($values as $value) {
            CompanyValue::updateOrCreate(['title' => $value['title']], $value);
        }

        // ─── Product Categories & Products ───
        $categories = [
            [
                'name' => 'Señalamiento Vial',
                'slug' => 'senalamiento-vial',
                'icon' => 'road-sign',
                'order' => 1,
                'products' => [],
            ],
            [
                'name' => 'Pintura Vial',
                'slug' => 'pintura-vial',
                'icon' => 'paint-bucket',
                'order' => 2,
                'products' => [
                    ['name' => 'Pintura Tráfico', 'slug' => 'pintura-trafico', 'order' => 1],
                    ['name' => 'Pintura Termoplástica', 'slug' => 'pintura-termoplastica', 'order' => 2],
                    ['name' => 'Pintura Epóxica', 'slug' => 'pintura-epoxica', 'order' => 3],
                    ['name' => 'Microesfera', 'slug' => 'microesfera', 'order' => 4],
                ],
            ],
            [
                'name' => 'Accesorios Viales',
                'slug' => 'accesorios-viales',
                'icon' => 'cone',
                'order' => 3,
                'products' => [],
            ],
            [
                'name' => 'Protección en Obra',
                'slug' => 'proteccion-en-obra',
                'icon' => 'hard-hat',
                'order' => 4,
                'products' => [],
            ],
        ];

        foreach ($categories as $catData) {
            $products = $catData['products'];
            unset($catData['products']);

            $category = ProductCategory::updateOrCreate(['slug' => $catData['slug']], $catData);

            foreach ($products as $productData) {
                $productData['product_category_id'] = $category->id;
                Product::updateOrCreate(['slug' => $productData['slug']], $productData);
            }
        }

        // ─── Industries ───
        $industries = [
            [
                'name' => 'Residencial',
                'slug' => 'residencial',
                'icon' => 'home',
                'order' => 1,
                'sub_items' => ['Fraccionamientos', 'Condominios', 'Privadas'],
            ],
            [
                'name' => 'Comercial',
                'slug' => 'comercial',
                'icon' => 'building',
                'order' => 2,
                'sub_items' => ['Plazas comerciales', 'Supermercados', 'Centros comerciales'],
            ],
            [
                'name' => 'Sector Privado',
                'slug' => 'sector-privado',
                'icon' => 'factory',
                'order' => 3,
                'sub_items' => ['Constructoras', 'Desarrolladores Inmobiliarios', 'Parques Industriales', 'Infraestructura Vial'],
            ],
            [
                'name' => 'Gubernamental',
                'slug' => 'gubernamental',
                'icon' => 'landmark',
                'order' => 4,
                'sub_items' => ['Municipios', 'Gobiernos estatales', 'Dependencias federales'],
            ],
        ];

        foreach ($industries as $industry) {
            Industry::updateOrCreate(['slug' => $industry['slug']], $industry);
        }
    }
}
